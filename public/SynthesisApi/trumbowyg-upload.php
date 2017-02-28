<?php

define("UPLOADDIR", dirname(__DIR__) . "\\synthesis-uploads\\");

function getNewFileName($path, $filename_original){
	if(file_exists($path . $filename_original)){
		return md5(date('Y-m-d H:i:s:u'));
	}else{
		return $filename_original;
	}
}

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	$file = array_shift($_FILES);
	$newname = getNewFileName(UPLOADDIR, basename($file['name']));
	if(move_uploaded_file($file['tmp_name'], UPLOADDIR . basename($newname))) {
		$file = dirname($_SERVER['PHP_SELF']) . str_replace('./', '/', UPLOADDIR) . $newname;
		$headers = apache_request_headers();
		$data = array(
			'success' => true,
			'file'    => $headers['synthesiscms_public_url'] . '/synthesis-uploads/' . basename($file),
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

echo json_encode($data);
?>
