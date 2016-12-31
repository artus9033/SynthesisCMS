<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();

Route::group(['middleware' => 'web'], function () {
	Auth::routes();
	Route::auth();

	Route::get('/', function () {
         return redirect('/home');
     });

	Route::get('/lang/{language}', [ 'as' => 'lang', 'uses' => 'HomeController@lang']);

	Route::get('/profile', ['as' => 'profile', 'uses' => 'ProfileController@info']);

     Route::get('/profile/password', ['as' => 'profile', 'uses' => 'ProfileController@info_edit']);

     Route::post('/profile/password', ['as' => 'profile_password', 'uses' => 'ProfileController@edit']);

     Route::get('/home', ['as' => 'home', 'uses' => 'HomeController@index']);
});
