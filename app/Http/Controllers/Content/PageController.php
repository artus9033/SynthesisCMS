<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content\Page;
use App\Toolbox;
use App\Http\Requests\BackendRequest;
use App\Models\Auth\User;
use App\Models\Content\Molecule;
use App\Models\Content\Atom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;

class PageController extends Controller
{
	public function lang($language){
	    $language2 = strtolower($language);
	    \Session::put('locale', $language2);
	    \App::setLocale($language2);
	    return \Redirect::back()->with('messages', array(trans("synthesiscms/main.msg_language_changed") . $language2));
    }

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
		echo Page::where('slug', $slug)->count();
		exit;
		$page = Page::where('slug', $slug)->first();
		if(is_null($page)){
			abort(404);
		}else{
			$mod_path = app_path() . "/Extensions/" . $page->extension . "/ExtensionKernel.php";
			$mod_path = str_replace("/", "\\", $mod_path);
			if(file_exists($mod_path)){
				echo \App::make('\App\Extensions\\'.$page->extension.'\ExtensionKernel')->index($page, $slug);
			}else{
				return \View::make('errors.cms')->with(['error' => trans("synthesiscms/errors.err_extension_not_found"), 'help' => trans("synthesiscms/errors.err_extension_not_found_help")]);
			}
		}
	}
}
