<?php

//TODO: add a generic favicon.ico to /public and add it to git

//redirect /backend to /admin
Route::any('/backend', function () {
	return redirect(route('admin'));
})->name('backend');

Route::any('/backend/{anything}', function ($anything) {
	return redirect(route('admin') . '/' . $anything);
})->name('backend_wildcard');

Route::auth();

Route::get('/lang/{language}', 'Content\\PageController@lang')->name('lang');
Route::get('/profile', 'Auth\\ProfileController@infoGet')->name('profile');
Route::get('/profile/delete/{id}', 'Auth\\ProfileController@delete')->name('profile_delete');
Route::get('/profile/password', 'Auth\\ProfileController@editGet')->name('profile_password');
Route::post('/profile/password', 'Auth\\ProfileController@editPost')->name('profile_password_post');

?>
