<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests\BackendRequest;
use App\Models\Auth\User;
use App\Models\Content\Page;
use App\Models\Content\Molecule;
use App\Models\Settings\Settings;
use App\Models\Content\Atom;
use App\Toolbox;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Http\Controllers\Controller;

class TrumbowygUpload extends Controller
{



	function uploadPost(BackendRequest $request){
		function getNewFileName($path, $filename_original){
			if(file_exists($path . $filename_original)){
				return md5(date('Y-m-d H:i:s:u'));
			}else{
				return $filename_original;
			}
		}

		$uploadDir = public_path() . "\\synthesis-uploads\\";

		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			$file = array_shift($_FILES);
			$newname = getNewFileName($uploadDir, basename($file['name']));
			if(move_uploaded_file($file['tmp_name'], $uploadDir . basename($newname))) {
				$file = dirname($_SERVER['PHP_SELF']) . str_replace('./', '/', $uploadDir) . $newname;
				$headers = apache_request_headers();
				$data = array(
					'success' => true,
					'file'    => url('/') . '/synthesis-uploads/' . basename($file),
				);
			} else {
				$error = true;
				$data = array(
					'message' => 'uploadError',
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
