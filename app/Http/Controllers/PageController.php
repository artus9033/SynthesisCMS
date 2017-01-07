<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;

class PageController extends Controller
{
	public function show($slug = 'home')
	{
		$slug = str_replace("\\", "/", $slug);
		if(!starts_with($slug, "/")){
			$slug_bak = $slug;
			$slug = "/" . $slug_bak;
		}
		$page = Page::where('slug', $slug)->first();
		if(is_null($page)){
			abort(404);
		}else{
			$mod_path = "synthesiscms/modules/" . $page->module . ".php";
			if(file_exists($mod_path)){
				require($mod_path);
				return \View::make('pages.index')->with(['page' => $page, 'slug' => $page->slug, 'module' => $page->module]);
			}else{
				return \View::make('errors.cms')->with(['error' => trans("synthesiscms/errors.err_module_not_found"), 'help' => trans("synthesiscms/errors.err_module_not_found_help")]);
			}
		}
	}
}
