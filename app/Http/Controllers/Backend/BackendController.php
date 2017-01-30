<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests\BackendRequest;
use App\Models\Auth\User;
use App\Models\Content\Page;
use App\Models\Content\Molecule;
use App\Models\Settings\Settings;
use App\Models\Content\Atom;
use App\Toolbox;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Http\Controllers\Controller;

class BackendController extends Controller
{
//TODO: all models can be created and edited with empty title/other fields; fix this
//TODO: implement multi-instance setting profiles
	public function index()
	{
		if(Auth::check() && Auth::user()->is_admin){
			return view('admin.admin');
		}else{
			return view('auth.error');
		}
	}

	public function settingsGet(){
		return view('admin.settings');
	}

	public function settingsPost(BackendRequest $request){
		$settings = Settings::getActiveInstance();

	}
}
