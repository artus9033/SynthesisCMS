<?php

/*
|--------------------------------------------------------------------------
| Lithium Forms Module Global Laravel App Routes
|--------------------------------------------------------------------------
|
| All the global (laravel app) routes related to the Lithium Forms module have to go in here.
| These routes are interpreted from the root of app url, e.g. defining a route as
| Route::get('/module' [...]) will listen at host:port/module
| If you want to add routes to virtual SynthesisCMS API pages which use this module,
| Add them to synthesisRoutes.php
|
*/

/**
Route::group(['prefix' => "Lithium", 'namespace' => 'App\Modules\Lithium\Controllers'], function () {
	Route::get('/', ['as' => 'Lithium.index', 'uses' => 'IndexController@index']);
	Route::get('model-test', ['as' => 'Lithium.modelTest', 'uses' => 'IndexController@modelTest']);
});
**/
