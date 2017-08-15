<?php

//TODO: add a generic favicon.ico to /public and add it to git

//redirect /backend to /admin
Route::get('/backend/{anything}', function ($anything) {
	return redirect('/admin/' . $anything);
});

Route::auth();

Route::get('/lang/{language}', ['as' => 'lang', 'uses' => 'Content\\PageController@lang']);

Route::get('/profile', ['as' => 'profile', 'uses' => 'Auth\\ProfileController@infoGet']);
Route::get('/profile/delete/{id}', ['as' => 'profile_delete', 'uses' => 'Auth\\ProfileController@delete']);
Route::get('/profile/password', ['as' => 'profile_password', 'uses' => 'Auth\\ProfileController@editGet']);
Route::post('/profile/password', ['as' => 'profile_password_post', 'uses' => 'Auth\\ProfileController@editPost']);

?>
