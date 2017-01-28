<?php

namespace App\Modules\Hydrogen;

use App\Http\Controllers\Controller;
use App\Modules\Hydrogen\Models\HydrogenModule;
use App\Modules\Hydrogen\Controllers\HydrogenController;
use App\SynthesisCMS\API\SynthesisModule;

/**
 * ModuleKernel
 *
 * Module Kernel to control all the functionality directly
 * related to the Module. This class is required, otherwise any routes
 * using this module will throw an internal CMS error!
 */

class ModuleKernel extends SynthesisModule
{

	public function create($id){
		$module = HydrogenModule::create(['id' => $id]);
	}

	public function delete($id){
		$module = HydrogenModule::where(['id' => $id])->first();
		$module->delete();
	}

	public function getModuleName(){
		return trans('synthesiscms/modules.hydrogen');
	}

	public function editGet($page)
	{
		return \View::make('hydrogen::partials/edit')->with(['page' => $page]);
	}

	public function editPost($id, $request)
	{
		$module = HydrogenModule::where('id', $id)->first();
		$module->molecule = $request->get('hydrogen-molecule');
		$module->save();
	}

	public function routes($page, $base_slug){
		$kernel = $this;
		\Route::group(['middleware' => 'web'], function () use ($page, $kernel, $base_slug) {
			\Route::get($base_slug, function() use ($page, $kernel, $base_slug) {
	    			return \App::make('App\Modules\Hydrogen\Controllers\HydrogenController')->index($page, $kernel, $base_slug);
			})->middleware('web');
			\Route::get($base_slug . '/atom/{id}', function() use ($page, $kernel, $base_slug) {
	    			return \App::make('App\Modules\Hydrogen\Controllers\HydrogenController')->atom(\Route::input('id'), $kernel, $page, $base_slug);
			})->middleware('web');
		});
	}
}
