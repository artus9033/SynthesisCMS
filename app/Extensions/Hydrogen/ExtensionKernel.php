<?php

namespace App\Extensions\Hydrogen;

use App\Extensions\Hydrogen\Models\HydrogenExtension;
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
		foreach (HydrogenExtension::where(['id' => $id])->get() as $item) {
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
		foreach (HydrogenExtension::all() as $extensions_instance) {
			foreach (Page::where('id', $extensions_instance->id)->cursor() as $page) {
				array_push($pages, Array($page->page_header, $page->id, $this->getExtensionName()));
			}
		}
		return Array($pages);
	}

	public function getExtensionName()
	{
		return trans('Hydrogen::hydrogen.name');
	}

	public function editGet($page)
	{
		if (HydrogenExtension::where(['id' => $page->id])->exists()) {
			$extension_instance = HydrogenExtension::find($page->id);
		} else {
			$extension_instance = $this->create($page->id);
		}
		return \View::make('Hydrogen::partials/edit')->with(['page' => $page, 'extension_instance' => $extension_instance]);
	}

	public function create($id)
	{
		HydrogenExtension::create(['id' => $id]);
		return HydrogenExtension::find($id);
	}

	public function editPost($id, $request)
	{
		$extension = HydrogenExtension::where('id', $id)->first();
		$extension->articleCategory = $request->get('hydrogen-articleCategory');
		$extension->list_column_count = $request->get('list_column_count');
		$extension->default_sorting_type = $request->get('default_sorting_type');
		$extension->default_sorting_direction = $request->get('default_sorting_direction');
		$extension->articles_on_single_page = $request->get('articles_on_single_page');
		$extension->showHeader = $request->get('showHeader') == "on";
		$extension->save();
	}

	public function routes($page, $base_slug)
	{
		$kernel = $this;
		\Route::group(['middleware' => 'web'], function () use ($page, $kernel, $base_slug) {
			\Route::get($base_slug, function () use ($page, $kernel, $base_slug) {
				return \App::make('App\Extensions\Hydrogen\Controllers\HydrogenController')->index(1, $page, $kernel, $base_slug);
			})->middleware('web');
			\Route::get($base_slug . '/p/{currentPage}', function ($currentPage) use ($page, $kernel, $base_slug) {
				return \App::make('App\Extensions\Hydrogen\Controllers\HydrogenController')->index($currentPage, $page, $kernel, $base_slug);
			})->middleware('web');
			\Route::get($base_slug . '/article/{id}', function () use ($page, $kernel, $base_slug) {
				return \App::make('App\Extensions\Hydrogen\Controllers\HydrogenController')->article(\Route::input('id'), $kernel, $page, $base_slug);
			})->middleware('web');
		});
	}
}
