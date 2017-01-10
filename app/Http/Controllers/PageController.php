<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use App\Toolbox;

class PageController extends Controller
{
	public function show($slug)
	{
		$slug = str_replace("\\", "/", $slug);
		if(!starts_with($slug, "/")){
			$slug_bak = $slug;
			$slug = "/" . $slug_bak;
		}
		$slug = strtok($slug, '/') . '/' . strtok('/');
		if(!starts_with($slug, "/")){
			$slug_bak = $slug;
			$slug = "/" . $slug_bak;
		}
		if(ends_with($slug, "/")){
			$slug = substr($slug, 0, -1);
		}
		if(substr_count($slug, "/") > 1){
			$slug = Toolbox::string_between($slug, '/', '/');
			$slug = str_replace("\\", "/", $slug);
			if(!starts_with($slug, "/")){
				$slug_bak = $slug;
				$slug = "/" . $slug_bak;
			}
			$slug = strtok($slug, '/') . '/' . strtok('/');
			if(!starts_with($slug, "/")){
				$slug_bak = $slug;
				$slug = "/" . $slug_bak;
			}
			if(ends_with($slug, "/")){
				$slug = substr($slug, 0, -1);
			}
		}
		$page = Page::where('slug', $slug)->first();
		if(is_null($page)){
			abort(404);
		}else{
			$mod_path = app_path() . "/Modules/" . $page->module . "/ModuleKernel.php";
			$mod_path = str_replace("/", "\\", $mod_path);
			if(file_exists($mod_path)){
				echo \App::make('\App\Modules\\'.$page->module.'\ModuleKernel')->index($page, $slug);
			}else{
				return \View::make('errors.cms')->with(['error' => trans("synthesiscms/errors.err_module_not_found"), 'help' => trans("synthesiscms/errors.err_module_not_found_help")]);
			}
		}
	}
}
