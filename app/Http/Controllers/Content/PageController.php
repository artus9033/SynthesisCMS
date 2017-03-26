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
}
