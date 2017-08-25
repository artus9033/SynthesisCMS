<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\BackendRequest;
use App\Toolbox;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

/**
 * Class SynthesisFilesystemController
 * @package App\Http\Controllers\Backend
 */
class SynthesisFilesystemController extends Controller
{

	/**
	 * SynthesisFilesystemController constructor.
	 */
	function __construct()
	{

	}

	/**
	 * Function that checks if the public directory
	 * contains all needed compiled resources for the website
	 * or needs a re-compilation with nodejs
	 * @return bool
	 */
	static function checkPublicDirectoryResourcesFilesystemOK()
	{
		$mixManifestPath = public_path() . "/mix-manifest.json";
		$synthesisStorageSymlink = public_path() . "/storage";
		return file_exists($mixManifestPath) && file_exists($synthesisStorageSymlink);
	}

	/**
	 * Function that lists all images & directories inside the public/synthesis-uploads directory
	 * The returned is an array of images & directories inside the public/synthesis-uploads in the following format: Array('imgs' => Array(), 'dirs' => Array()
	 * @param BackendRequest $request
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	function files_list(BackendRequest $request)
	{
		$storage = $this->getUploadsDisk();
		$allFiles = $storage->files();
		$requestedExtensions = $request->get('extensions');
		$filteredFiles = array();
		foreach ($allFiles as $file) {
			$currentExtension = File::extension($file);
			$currentMimeType = $storage->mimeType($file);
			$currentSize = $storage->size($file);
			if (in_array($currentExtension, $requestedExtensions) || in_array("*", $requestedExtensions)) {
				array_push($filteredFiles, [
					'name' => $file,
					'path' => ('/synthesis-uploads/' . $file),
					'extension' => $currentExtension,
					'mime_type' => $currentMimeType,
					'size' => Toolbox::human_filesize($currentSize)
				]);
			}
		}
		$directories = Array();
		foreach($storage->directories() as $dir){
			array_push($directories, [
				'name' => $dir,
				'itemsCount' => count($storage->files($dir))
			]);
		}
		$data = [
			'files' => $filteredFiles,
			'directories' => $directories
		];
		return response($data);
	}

	private function getUploadsDisk()
	{
		return Storage::disk('uploads');
	}

	/**
	 * Function that uploads a file to public/synthesis-uploads
	 * @param BackendRequest $request
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 * response with: boolean 'success', string 'message', string 'file' - relative url to file (if upload successful),
	 */
	function uploadPost(BackendRequest $request)
	{
		function getNewFileName($storage, $filePath, $filename, $fileExtension, $bRandomPrefix = false)
		{
			if ($storage->exists($filePath . $filename . "." . $fileExtension)) {
				$uid = uniqid(($bRandomPrefix ? str_random(6) : ""), $bRandomPrefix);
				return getNewFileName($storage, $filePath, $filename . $uid, $fileExtension, true);
			} else {
				return ($filename . "." . $fileExtension);
			}
		}

		if ($request->hasFile('synthesiscms-file') && $request->has('path')) {
			$file = $request->file('synthesiscms-file');
			if ($file->isFile() && !$file->isExecutable()) {
				$storage = $this->getUploadsDisk();
				$fname = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
				$fext = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
				$fdir = $request->get('path');
				$fpathRelative = $fdir . getNewFileName($storage, $fdir, $fname, $fext, false);
				if ($storage->putFileAs('', $file, $fpathRelative)) {
					$data = array(
						'success' => true,
						'message' => 'upload successful',
						'file' => '/synthesis-uploads/' . $fpathRelative,
					);
				} else {
					$data = array(
						'success' => false,
						'message' => 'server error'
					);
				}
			}else{
				$data = array(
					'success' => false,
					'message' => 'received improper file (either an executable - not allowed - or a directory)'
				);
			}
		} else {
			$data = array(
				'success' => false,
				'message' => 'no file received'
			);
		}

		return response($data);
	}

	/**
	 * Function that sends the requested file from a non-straightly-public
	 * virtual storage folder (see config/filesystems.php)
	 * @param BackendRequest $request
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 * response with the requested file contents or a 404 repsonse
	 */
	function uploadGet($file, BackendRequest $request)
	{
		$storage = $this->getUploadsDisk();
		if ($storage->has($file)) {
			return response()->file($storage->path($file));
		} else {
			return abort(404);
		}
	}

	/**
	 * Function that sends the requested file from a non-straightly-public
	 * virtual storage folder (see config/filesystems.php) within a download response
	 * @param BackendRequest $request
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 * response with the requested file contents or a 404 repsonse
	 */
	function uploadDownload($file, BackendRequest $request)
	{
		$storage = $this->getUploadsDisk();
		if ($storage->has($file)) {
			return response()->download($storage->path($file));
		} else {
			return abort(404);
		}
	}
}
