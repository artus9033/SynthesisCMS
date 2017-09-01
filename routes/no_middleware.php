<?php

Route::get('/synthesis-uploads/{file}', 'Backend\\SynthesisFilesystemController@uploadGet')->name('synthesis_upload_get');
Route::get('/synthesis-uploads/{file}/download', 'Backend\\SynthesisFilesystemController@uploadDownload')->name('synthesis_upload_download');

Route::get('/install', 'Backend\\InstallationController@index')->name('install');

Route::get('/update', 'Backend\\UpdateController@index')->name('update');

?>
