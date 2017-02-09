<?php

namespace App\Extensions\Hydrogen;

use App\Http\Controllers\Controller;
use App\Extensions\Hydrogen\Models\HydrogenExtension;
use App\Extensions\Hydrogen\Controllers\HydrogenController;
use App\SynthesisCMS\API\SynthesisExtension;
use App\SynthesisCMS\API\Positions\SynthesisPositions;
use App\SynthesisCMS\API\Positions\SynthesisPositionManager;
use App\SynthesisCMS\API\SynthesisExtensionType;

/**
 * ExtensionKernel
 *
 * Extension Kernel to control all the functionality directly
 * related to the Extension. This class is required, otherwise any routes
 * using this extension will throw an internal CMS error!
 */

class ExtensionKernel extends SynthesisExtension
{

	public function create($id){
		$extension = HydrogenExtension::create(['id' => $id]);
	}

	public function delete($id){
		$extension = HydrogenExtension::where(['id' => $id])->first();
		$extension->delete();
	}

	public function getExtensionName(){
		return trans('Hydrogen::hydrogen.name');
	}

	public function getExtensionType(){
		return SynthesisExtensionType::Module;
	}

	public function editGet($page)
	{
		return \View::make('Hydrogen::partials/edit')->with(['page' => $page]);
	}

	public function editPost($id, $request)
	{
		$extension = HydrogenExtension::where('id', $id)->first();
		$extension->molecule = $request->get('hydrogen-molecule');
		$extension->list_column_count = $request->get('list_column_count');
		$extension->save();
	}

	public function routes($page, $base_slug){
		$kernel = $this;
		\Route::group(['middleware' => 'web'], function () use ($page, $kernel, $base_slug) {
			\Route::get($base_slug, function() use ($page, $kernel, $base_slug) {
	    			return \App::make('App\Extensions\Hydrogen\Controllers\HydrogenController')->index(1, $page, $kernel, $base_slug);
			})->middleware('web');
			\Route::get($base_slug . '/p/{currentPage}', function($currentPage) use ($page, $kernel, $base_slug) {
	    			return \App::make('App\Extensions\Hydrogen\Controllers\HydrogenController')->index($currentPage, $page, $kernel, $base_slug);
			})->middleware('web');
			\Route::get($base_slug . '/atom/{id}', function() use ($page, $kernel, $base_slug) {
	    			return \App::make('App\Extensions\Hydrogen\Controllers\HydrogenController')->atom(\Route::input('id'), $kernel, $page, $base_slug);
			})->middleware('web');
		});
	}
}
