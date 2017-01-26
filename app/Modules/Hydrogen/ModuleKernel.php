<?php

namespace App\Modules\Hydrogen;

use App\Http\Controllers\Controller;
use App\Modules\Hydrogen\Models\HydrogenModule;
use App\Modules\Hydrogen\Controllers\HydrogenController;
use App\SynthesisCMS\API\SynthesisRouter;
use App\SynthesisCMS\API\RequestMethod;
use App\SynthesisCMS\API\ResponseMethod;

/**
 * ModuleKernel
 *
 * Module Kernel to control all the functionality directly
 * related to the Module. This class is required, otherwise any routes
 * using this module will throw an internal CMS error!
 */

class ModuleKernel extends Controller
{

	public function create($id){
		$module = HydrogenModule::create(['id' => $id]);
	}

	public function routes($page, $base_slug){
		$kernel = $this;
		\Route::group(['middleware' => 'web'], function () use ($page, $kernel, $base_slug) {
			\Route::get($base_slug, function() use ($page, $kernel, $base_slug) {
	    			return \App::make('App\Modules\Hydrogen\Controllers\HydrogenController')->index($page, $kernel);
			})->middleware('web');
			\Route::get($base_slug . '/atom/{id}', function() use ($page, $kernel, $base_slug) {
	    			return \App::make('App\Modules\Hydrogen\Controllers\HydrogenController')->atom(\Route::input('id'), $kernel, $page);
			})->middleware('web');
		});
	}

	//Function used by the route edit app view
	public function edit($page)
	{
		return \View::make('hydrogen::partials/edit')->with(['page' => $page]);
	}
}
