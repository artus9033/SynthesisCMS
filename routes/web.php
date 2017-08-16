<?php

//TODO: add a generic favicon.ico to /public and add it to git

//redirect /backend to /admin
Route::any('/backend', function () {
	return redirect(route('admin'));
});
Route::any('/backend/{anything}', function ($anything) {
	return redirect(route('admin') . '/' . $anything);
});

Route::auth();

Route::get('/lang/{language}', ['as' => 'lang', 'uses' => 'Content\\PageController@lang']);
Route::any('/synthesis-uploads/'); //this only holds the route for the synthesis route checker to say it's occupied
Route::any('/synthesis-uploads/{$anything}'); //this only holds the route for the synthesis route checker to say it's occupied
Route::get('/profile', ['as' => 'profile', 'uses' => 'Auth\\ProfileController@infoGet']);
Route::get('/profile/delete/{id}', ['as' => 'profile_delete', 'uses' => 'Auth\\ProfileController@delete']);
Route::get('/profile/password', ['as' => 'profile_password', 'uses' => 'Auth\\ProfileController@editGet']);
Route::post('/profile/password', ['as' => 'profile_password_post', 'uses' => 'Auth\\ProfileController@editPost']);

?>
