<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContentEditorRequest;
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
     * Function that checks if the public directory
     * contains all needed compiled resources for the website
     * or needs a re-compilation with nodejs
     * @return bool
     */
    public static function checkPublicDirectoryResourcesFilesystemOK()
    {
        if (!file_exists(public_path('favicon.ico')) && file_exists(base_path("public/img/synthesiscms-icon.svg"))) {
            $pngPath = resource_path("assets/logos/dist/synthesiscms-icon.png");
            $fSize = getimagesize($pngPath);
            $fW = $fSize[0];
            $fH = $fSize[1];
            $scale = min($fW, $fH) / max($fW, $fH);
            if ($fW > $fH) {
                $w = 180;
                $h = (180 * $scale);
            } else if ($fW < $fH) {
                $w = (180 * $scale);
                $h = 180;
            } else {
                $w = 180;
                $h = 180;
            }
            $icoLib = new \PHP_ICO($pngPath, array(array($w, $h)));
            $icoLib->save_ico(public_path('favicon.ico'));
        }
        $mixManifestPath = public_path("/mix-manifest.json");
        return file_exists($mixManifestPath);
    }

    /**
     * Function that lists all images & directories inside the public/synthesis-uploads directory
     * The returned is an array of images & directories inside the public/synthesis-uploads in the following format: Array('imgs' => Array(), 'dirs' => Array()
     * @param ContentEditorRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function files_list(ContentEditorRequest $request)
    {
        $storage = $this->getUploadsDisk();
        $currentDir = $request->get("path");
        $allFiles = $storage->files($currentDir);
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
                    'size' => Toolbox::human_filesize($currentSize),
                ]);
            }
        }

        $directories = array();

        foreach ($storage->directories($currentDir) as $dir) {
            array_push($directories, [
                'name' => $dir,
                'itemsCount' => count($storage->files($dir)),
            ]);
        }

        $data = [
            'files' => $filteredFiles,
            'directories' => $directories,
        ];
        return response($data);
    }

    /**
     * Function that creates a directory inside the public/synthesis-uploads directory
     * @param ContentEditorRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function createDir(ContentEditorRequest $request)
    {
        $storage = $this->getUploadsDisk();
        $path = ltrim($request->get('path'), "/");

        $success = true;

        if ($storage->exists($path)) {
            $success = false;
        } else {
            if (!$storage->makeDirectory($path)) {
                $success = false;
            }
        }

        $data = [
            'success' => $success,
        ];

        return response($data);
    }

    private function getUploadsDisk()
    {
        return Storage::disk('uploads');
    }

    /**
     * Function that uploads a file to public/synthesis-uploads
     * @param ContentEditorRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * response with: boolean 'success', string 'message', string 'file' - relative url to file (if upload successful),
     */
    public function uploadPost(ContentEditorRequest $request)
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
                        'message' => 'server error',
                    );
                }
            } else {
                $data = array(
                    'success' => false,
                    'message' => 'received improper file (either an executable - not allowed - or a directory)',
                );
            }
        } else {
            $data = array(
                'hasFile' => $request->hasFile('synthesiscms-file'),
                'success' => false,
                'message' => 'no file received',
            );
        }

        return response($data);
    }

    /**
     * Function that sends the requested file from a non-straightly-public
     * virtual storage folder (see config/filesystems.php)
     * @param \Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * response with the requested file contents or a 404 repsonse
     */
    public function uploadGet($file, \Request $request)
    {
        $storage = $this->getUploadsDisk();
        if ($storage->has($file)) {
            return response()->file($storage->path($file));
        } else {
            return response()->view("errors/404")->setStatusCode(404);
        }
    }

    /**
     * Function that sends the requested file from a non-straightly-public
     * virtual storage folder (see config/filesystems.php) within a download response
     * @param ContentEditorRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * response with the requested file contents or a 404 repsonse
     */
    public function uploadDownload($file, ContentEditorRequest $request)
    {
        $storage = $this->getUploadsDisk();
        if ($storage->has($file)) {
            return response()->download($storage->path($file));
        } else {
            return response()->view("errors/404")->setStatusCode(404);
        }
    }
}
