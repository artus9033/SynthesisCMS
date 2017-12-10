<?php

// Redirect /backend to /admin
Route::any('/backend/{anything?}', 'Backend\\BackendController@redirectBackendToAdmin')->name('backend');

Route::auth();

Route::get('/lang/{language}', 'Content\\PageController@lang')->name('lang');
Route::get('/profile', 'Auth\\ProfileController@infoGet')->name('profile');
Route::get('/profile/delete/{id}', 'Auth\\ProfileController@delete')->name('profile_delete');
Route::get('/profile/password', 'Auth\\ProfileController@editGet')->name('profile_password');
Route::post('/profile/password', 'Auth\\ProfileController@editPost')->name('profile_password_post');

?>