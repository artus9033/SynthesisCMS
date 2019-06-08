<?php

namespace App\Extensions\Kryptonite;

use App\Extensions\Kryptonite\Models\KryptoniteExtension;
use App\Models\Content\Page;
use App\SynthesisCMS\API\Extensions\SynthesisExtension;
use App\SynthesisCMS\API\Extensions\SynthesisExtensionType;
use \Illuminate\Http\Request;

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
        foreach (KryptoniteExtension::where(['id' => $id])->get() as $item) {
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
        foreach (KryptoniteExtension::all() as $extensions_instance) {
            foreach (Page::where('id', $extensions_instance->id)->cursor() as $page) {
                array_push($pages, array($page->page_title, $page->id, $this->getExtensionName()));
            }
        }
        return array($pages);
    }

    public function getExtensionName()
    {
        return trans('Kryptonite::kryptonite.name');
    }

    public function editGet($page)
    {
        if (KryptoniteExtension::where(['id' => $page->id])->exists()) {
            $extension_instance = KryptoniteExtension::find($page->id);
        } else {
            $extension_instance = $this->create($page->id);
        }
        return \View::make('Kryptonite::partials/edit')->with(['page' => $page, 'extension_instance' => $extension_instance]);
    }

    public function create($id)
    {
        KryptoniteExtension::create(['id' => $id, "redirect_url" => ""]);
        return KryptoniteExtension::find($id);
    }

    public function editPost($id, $request)
    {
        $extension = KryptoniteExtension::where('id', $id)->first();
        $extension->redirect_url = $request->get('redirect_url');
        $extension->url_relative_to_server = $request->get("relativeToRoot") == "on";
        $extension->save();
    }

    public function routes($page, $base_slug)
    {
        $kernel = $this;
        $extension_instance = KryptoniteExtension::find($page->id);
        \Route::get($base_slug, function (Request $request) use ($page, $kernel, $base_slug, $extension_instance) {
            $url = $extension_instance->redirect_url;
            if ($extension_instance->url_relative_to_server) {
                return redirect($url);
            } else {
                return redirect()->away($url);
            }
        })->middleware('web');
    }
}
