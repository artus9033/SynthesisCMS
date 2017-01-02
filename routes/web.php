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
Route::get('/', function () {
    return redirect('/home');
});

Route::get('/p/{slug}', array('as' => 'page.show', 'uses' => 'PageController@show'));

Route::get('/backend', function () {
    return redirect('/admin');
});

Route::group(['middleware' => 'admin'], function () {
	Route::get('/admin', ['as' => 'admin', 'uses' => 'BackendController@index']);

	Route::get('/admin/manage_users', ['as' => 'manage_users', 'uses' => 'BackendController@manageUsersGet']);
     Route::post('/admin/manage_users', ['as' => 'manage_users_post', 'uses' => 'BackendController@manageUsersPost']);

	Route::get('/admin/manage_routes', ['as' => 'manage_routes', 'uses' => 'BackendController@manageRoutesGet']);
	Route::post('/admin/manage_routes/{id}', ['as' => 'manage_routes_post', 'uses' => 'BackendController@manageRoutesPost']);

	Route::get('/admin/user-privileges/{id}', ['as' => 'profile', 'uses' => 'BackendController@privileges']);
	Route::post('/admin/user-privileges/{id}', ['as' => 'profile', 'uses' => 'BackendController@privileges_change']);
});
//Page::where('id', $id)->update(array('image' => 'asdasd'));
Route::group(['middleware' => 'web'], function () {
	Auth::routes();
	Route::auth();

	Route::get('/lang/{language}', [ 'as' => 'lang', 'uses' => 'HomeController@lang']);

	Route::get('/profile', ['as' => 'profile', 'uses' => 'ProfileController@info']);

	Route::get('/profile/delete/{id}', ['as' => 'profile', 'uses' => 'ProfileController@delete']);

     Route::get('/profile/password', ['as' => 'profile', 'uses' => 'ProfileController@info_edit']);

     Route::post('/profile/password', ['as' => 'profile_password', 'uses' => 'ProfileController@edit']);

     Route::get('/home', ['as' => 'home', 'uses' => 'HomeController@index']);
});
