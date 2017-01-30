<?php

namespace App\Modules\Lithium;

use App\Http\Controllers\Controller;
use App\Modules\Lithium\Models\LithiumModule;
use App\Modules\Lithium\Controllers\LithiumController;
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
		$module = LithiumModule::create(['id' => $id]);
	}

	public function delete($id){
		$module = LithiumModule::where(['id' => $id])->first();
		$module->delete();
	}

	public function getModuleName(){
		return trans('lithium::lithium.name');
	}

	public function editGet($page)
	{
		return \View::make('lithium::partials/edit')->with(['page' => $page]);
	}

	public function editPost($id, $request)
	{
		$module = LithiumModule::where('id', $id)->first();
		$module->atom = $request->get('lithium-atom');
		$module->save();
	}

	public function routes($page, $base_slug){
		$kernel = $this;
		\Route::group(['middleware' => 'web'], function () use ($page, $kernel, $base_slug) {
			\Route::get($base_slug, function() use ($page, $kernel, $base_slug) {
	    			return \App::make('App\Modules\Lithium\Controllers\LithiumController')->index($page, $kernel, $base_slug);
			})->middleware('web');
			\Route::get($base_slug . '/atom/{id}', function() use ($page, $kernel, $base_slug) {
	    			return \App::make('App\Modules\Lithium\Controllers\LithiumController')->atom(\Route::input('id'), $kernel, $page, $base_slug);
			})->middleware('web');
		});
	}
}
