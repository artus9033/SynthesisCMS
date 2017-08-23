<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\BackendRequest;
use App\Toolbox;

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
		$synthesisUploadsDirPath = public_path() . "/synthesis-uploads/";
		if (!file_exists($synthesisUploadsDirPath)) {
			mkdir($synthesisUploadsDirPath);
		}
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
		return file_exists($mixManifestPath);
	}

	/**
	 * Function that lists all images & directories inside the public/synthesis-uploads directory
	 * The returned is an array of images & directories inside the public/synthesis-uploads in the following format: Array('imgs' => Array(), 'dirs' => Array()
	 * @param BackendRequest $request
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	function files_list(BackendRequest $request)
	{
		$dir = public_path() . "/synthesis-uploads/";
		$exts = $request->get('extensions');
		$ext_str = "";
		$len = count($exts);
		foreach ($exts as $i => $ext) {
			$ext_str .= $ext;
			if ($i != $len - 1) {
				$ext_str .= ',';
			}
		}
		$imgs = array();
		foreach (glob($dir . '*.{' . $ext_str . '}', GLOB_BRACE) as $file) {
			array_push($imgs, ['name' => basename($file), 'path' => url('/') . '/synthesis-uploads/' . basename($file), 'extension' => pathinfo($file, PATHINFO_EXTENSION), 'mime_type' => mime_content_type($file), 'size' => Toolbox::human_filesize(filesize($file))]);
		}
		$dirs = glob($dir . '*', GLOB_ONLYDIR);
		$data = ['imgs' => $imgs, 'dirs' => $dirs];
		return response($data);
	}

	/**
	 * Function that uploads a file to public/synthesis-uploads
	 * @param BackendRequest $request
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 * response with an array storing results of the upload process in the following format:
	 * either array('message' => 'uploadNotAjax', 'formData' => $_POST) if the request is not ajax,
	 * array('message' => 'uploadError', 'formData' => $_POST) if there was an error while moving the file
	 * or array('success' => true, 'file' => url('/') . '/synthesis-uploads/' . basename($file)) if the upload was successful
	)
	 */
	function uploadPost(BackendRequest $request)
	{
		function getNewFileName($path, $filename_original)
		{
			if (file_exists($path . $filename_original)) {
				return pathinfo($filename_original, PATHINFO_FILENAME) . md5(date('Y-m-d H:i:s:u')) . "." . pathinfo($path . $filename_original, PATHINFO_EXTENSION);
			} else {
				return $filename_original;
			}
		}

		$uploadDir = public_path() . '/synthesis-uploads/';

		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			$file = array_shift($_FILES);
			$newname = getNewFileName($uploadDir, basename($file['name']));
			if (move_uploaded_file($file['tmp_name'], $uploadDir . basename($newname))) {
				$file = dirname($_SERVER['PHP_SELF']) . str_replace('./', '/', $uploadDir) . $newname;
				$headers = apache_request_headers();
				$data = array(
					'success' => true,
					'file' => url('/') . '/synthesis-uploads/' . basename($file),
				);
			} else {
				$error = true;
				$data = array(
					'message' => 'uploadError',
					'formData' => $_POST
				);
			}
		} else {
			$data = array(
				'message' => 'uploadNotAjax',
				'formData' => $_POST
			);
		}

		return response($data);
	}

}
