<?php

/*
|--------------------------------------------------------------------------
| Lithium Extension Global Laravel App Routes
|--------------------------------------------------------------------------
|
| All the global (laravel app) routes related to the Lithium extension have to go in here.
| These routes are interpreted from the root of app url, e.g. defining a route as
| Route::get('/extension' [...]) will listen at host:port/extension
| If you want to add relative routes, use SynthesisCMS API
| Add relative routes to ExtensionKernel.php using the SynthesisCMS\API\SynthesisRouter class.
|
*/

Route::group(['middleware' => 'admin'], function () {
	Route::get('/admin/manage_applets/Nitrogen/create', ['uses' => 'App\\Extensions\\Nitrogen\\ExtensionKernel@settingsCreatePositionGet']);
	Route::post('/admin/manage_applets/Nitrogen/create', ['uses' => 'App\\Extensions\\Nitrogen\\ExtensionKernel@settingsCreatePositionPost']);
	Route::get('/admin/manage_applets/Nitrogen/delete/{id}', ['uses' => 'App\\Extensions\\Nitrogen\\ExtensionKernel@settingsDeletePosition']);
	Route::get('/admin/manage_applets/Nitrogen/up/{id}', ['uses' => 'App\\Extensions\\Nitrogen\\ExtensionKernel@settingsPositionUp']);
	Route::get('/admin/manage_applets/Nitrogen/down/{id}', ['uses' => 'App\\Extensions\\Nitrogen\\ExtensionKernel@settingsPositionDown']);
	Route::get('/admin/manage_applets/Nitrogen/edit/{id}', ['uses' => 'App\\Extensions\\Nitrogen\\ExtensionKernel@settingsEditPositionGet']);
	Route::post('/admin/manage_applets/Nitrogen/edit/{id}', ['uses' => 'App\\Extensions\\Nitrogen\\ExtensionKernel@settingsEditPositionPost']);
});

?>
