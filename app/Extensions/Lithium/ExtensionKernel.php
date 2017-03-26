<?php

namespace App\Extensions\Lithium;

use App\Http\Controllers\Controller;
use App\Extensions\Lithium\Models\LithiumExtension;
use App\Extensions\Lithium\Controllers\LithiumController;
use App\SynthesisCMS\API\SynthesisExtension;
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
		$extension = LithiumExtension::create(['id' => $id]);
	}

	public function onPageDeleted($id){
		$extension = LithiumExtension::where(['id' => $id])->first();
		$extension->delete();
	}

	public function getExtensionName(){
		return trans('Lithium::lithium.name');
	}

	public function getExtensionType(){
		return SynthesisExtensionType::Module;
	}

	public function editGet($page)
	{
		return \View::make('Lithium::partials/edit')->with(['page' => $page, 'extension_instance' => LithiumExtension::where('id', $page->id)->first()]);
	}

	public function editPost($id, $request)
	{
		$extension = LithiumExtension::where('id', $id)->first();
		$extension->atom = $request->get('lithium-atom');
		$extension->showHeader = $request->get('showHeader') == "on";
		$extension->save();
	}

	public function routes($page, $base_slug){
		$kernel = $this;
		\Route::group(['middleware' => 'web'], function () use ($page, $kernel, $base_slug) {
			\Route::get($base_slug, function() use ($page, $kernel, $base_slug) {
	    			return \App::make('App\Extensions\Lithium\Controllers\LithiumController')->index($page, $kernel, $base_slug);
			})->middleware('web');
			\Route::get($base_slug . '/atom/{id}', function() use ($page, $kernel, $base_slug) {
	    			return \App::make('App\Extensions\Lithium\Controllers\LithiumController')->atom(\Route::input('id'), $kernel, $page, $base_slug);
			})->middleware('web');
		});
	}
}
