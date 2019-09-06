<?php

Route::get('/synthesis-uploads/{file?}', 'Backend\\SynthesisFilesystemController@uploadGet')->where('file', '(.*)')->name('synthesis_upload_get');
Route::get('/synthesis-uploads/{file?}/download', 'Backend\\SynthesisFilesystemController@uploadDownload')->where('file', '(.*)')->name('synthesis_upload_download');

Route::get('/install', 'Backend\\InstallationController@index')->name('install');
