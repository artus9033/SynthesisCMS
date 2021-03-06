<?php

namespace App\Extensions\Lithium;

use App\Extensions\Lithium\Models\LithiumExtension;
use App\Models\Content\Page;
use App\SynthesisCMS\API\Extensions\SynthesisExtension;
use App\SynthesisCMS\API\Extensions\SynthesisExtensionType;

/**
 * ExtensionKernel
 *
 * Extension Kernel to control all the functionality directly
 * related to the Extension. This class is required, otherwise any routes
 * using this extension will throw an internal CMS error!
 */
class ExtensionKernel extends SynthesisExtension
{

    public function onRouteDeleted($id)
    {
        foreach (LithiumExtension::where(['id' => $id])->get() as $item) {
            $item->delete();
        }
    }

    public function getExtensionType()
    {
        return SynthesisExtensionType::Module;
    }

    public function getRoutesAndSubroutes()
    {
        $pages = array();
        foreach (LithiumExtension::all() as $extensions_instance) {
            foreach (Page::where('id', $extensions_instance->id)->cursor() as $page) {
                array_push($pages, array($page->page_title, $page->id, $this->getExtensionName()));
            }
        }
        return array($pages);
    }

    public function getExtensionName()
    {
        return trans('Lithium::lithium.name');
    }

    public function editGet($page)
    {
        if (LithiumExtension::where(['id' => $page->id])->exists()) {
            $extension_instance = LithiumExtension::find($page->id);
        } else {
            $extension_instance = $this->create($page->id);
        }
        return \View::make('Lithium::partials/edit')->with(['page' => $page, 'extension_instance' => $extension_instance]);
    }

    public function create($id)
    {
        LithiumExtension::create(['id' => $id]);
        return LithiumExtension::find($id);
    }

    public function editPost($id, $request)
    {
        $extension = LithiumExtension::where('id', $id)->first();
        $extension->article = $request->get('lithium-article');
        $extension->showHeader = $request->get('showHeader') == "on";
        $extension->save();
    }

    public function routes($page, $base_slug)
    {
        $kernel = $this;
        \Route::get($base_slug, function () use ($page, $kernel, $base_slug) {
            return \App::make('App\Extensions\Lithium\Controllers\LithiumController')->index($page, $kernel, $base_slug);
        })->middleware('web');
        \Route::get($base_slug . '/article/{id}', function () use ($page, $kernel, $base_slug) {
            return \App::make('App\Extensions\Lithium\Controllers\LithiumController')->article(\Route::input('id'), $kernel, $page, $base_slug);
        })->middleware('web');
    }
}
