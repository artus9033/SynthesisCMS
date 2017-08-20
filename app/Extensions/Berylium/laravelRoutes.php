<?php

/*
|--------------------------------------------------------------------------
| Berylium Extension Global Laravel App Routes
|--------------------------------------------------------------------------
|
| All the global (laravel app) routes related to the Berylium extension have to go in here.
| These routes are interpreted from the root of app url, e.g. defining a route as
| Route::get('/extension' [...]) will listen at host:port/extension
| If you want to add relative routes, use SynthesisCMS API
| Add relative routes to ExtensionKernel.php using the SynthesisCMS\API\SynthesisRouter class.
|
*/

Route::group(['middleware' => 'admin'], function () {
	Route::get('/admin/manage_applets/Berylium/create', ['uses' => 'App\\Extensions\\Berylium\\ExtensionKernel@settingsCreatePositionGet']);
	Route::post('/admin/manage_applets/Berylium/create', ['uses' => 'App\\Extensions\\Berylium\\ExtensionKernel@settingsCreatePositionPost']);
	Route::get('/admin/manage_applets/Berylium/delete/{id}', ['uses' => 'App\\Extensions\\Berylium\\ExtensionKernel@settingsDeletePosition']);
	Route::get('/admin/manage_applets/Berylium/up/{id}', ['uses' => 'App\\Extensions\\Berylium\\ExtensionKernel@settingsPositionUp']);
	Route::get('/admin/manage_applets/Berylium/down/{id}', ['uses' => 'App\\Extensions\\Berylium\\ExtensionKernel@settingsPositionDown']);
	Route::get('/admin/manage_applets/Berylium/edit/{id}', ['uses' => 'App\\Extensions\\Berylium\\ExtensionKernel@settingsEditPositionGet']);
	Route::post('/admin/manage_applets/Berylium/edit/{id}', ['uses' => 'App\\Extensions\\Berylium\\ExtensionKernel@settingsEditPositionPost']);
});

?>
