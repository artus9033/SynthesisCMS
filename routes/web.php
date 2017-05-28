<?php
//TODO: add a generic favicon.ico to /public and add it to git
Route::get('/backend', function () {
    return redirect('/admin');
});

Auth::routes();
Route::auth();

Route::get('/lang/{language}', [ 'as' => 'lang', 'uses' => 'Content\\PageController@lang']);

Route::get('/profile', ['as' => 'profile', 'uses' => 'Auth\\ProfileController@infoGet']);
Route::get('/profile/delete/{id}', ['as' => 'profile', 'uses' => 'Auth\\ProfileController@delete']);
Route::get('/profile/password', ['as' => 'profile', 'uses' => 'Auth\\ProfileController@editGet']);
Route::post('/profile/password', ['as' => 'profile_password', 'uses' => 'Auth\\ProfileController@editPost']);

?>
