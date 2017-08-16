<?php

namespace App\Extensions\Ferrum;

use App\Extensions\Ferrum\Models\FerrumExtension;
use App\Models\Content\Page;
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

	public function onPageDeleted($id)
	{
		foreach (FerrumExtension::where(['id' => $id])->get() as $item) {
			$item->delete();
		}
	}

	public function getExtensionType()
	{
		return SynthesisExtensionType::Module;
	}

	public function getRoutesAndSubroutes()
	{
		$pages = Array();
		foreach (FerrumExtension::all() as $extensions_instance) {
			foreach (Page::where('id', $extensions_instance->id)->cursor() as $page) {
				array_push($pages, Array($page->page_header, $page->id, $this->getExtensionName()));
			}
		}
		return Array($pages);
	}

	public function getExtensionName()
	{
		return trans('Ferrum::ferrum.name');
	}

	public function editGet($page)
	{
		if (FerrumExtension::where(['id' => $page->id])->exists()) {
			$extension_instance = FerrumExtension::find($page->id);
		} else {
			$extension_instance = $this->create($page->id);
		}
		return \View::make('Ferrum::partials/edit')->with(['page' => $page, 'extension_instance' => $extension_instance]);
	}

	public function create($id)
	{
		FerrumExtension::create(['id' => $id, 'formInJson' => '', 'submitButtonText' => trans('Ferrum::ferrum.default_value_submit_button_text'), 'applicationConfirmationText' => trans('Ferrum::ferrum.default_value_application_confirmation_text')]);
		return FerrumExtension::find($id);
	}

	public function editPost($id, $request)
	{
		$extension = FerrumExtension::where('id', $id)->first();
		$extension->formInJson = $request->get('ferrumJsonifiedFormFromEditor');
		$extension->showHeader = $request->get('showHeader') == "on";
		$extension->submitButtonText = $request->get('ferrum-submit-button-text-editor');
		$extension->applicationConfirmationText = $request->get('applicationConfirmationText');
		$extension->save();
	}

	public function routes($page, $base_slug)
	{
		$kernel = $this;
		\Route::group(['middleware' => 'web'], function () use ($page, $kernel, $base_slug) {
			\Route::get($base_slug, function () use ($page, $kernel, $base_slug) {
				return \App::make('App\Extensions\Ferrum\Controllers\FerrumController')->index($page, $kernel, $base_slug);
			})->middleware('web');
			\Route::get($base_slug . '/confirm/', function () use ($page, $kernel, $base_slug) {
				return \App::make('App\Extensions\Ferrum\Controllers\FerrumController')->confirm($page, $kernel, $base_slug);
			})->middleware('web');
			\Route::post($base_slug . '/apply/', function () use ($page, $kernel, $base_slug) {
				return \App::make('App\Extensions\Ferrum\Controllers\FerrumController')->apply($page, $kernel, $base_slug);
			})->middleware('web');
		});
	}
}
