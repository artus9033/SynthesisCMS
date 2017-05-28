<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
	public function lang($language){
	    $language2 = strtolower($language);
	    \Session::put('locale', $language2);
	    \App::setLocale($language2);
	    return \Redirect::back()->with('messages', array(trans("synthesiscms/main.msg_language_changed") . $language2));
    }
}
