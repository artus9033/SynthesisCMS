<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
	public function lang($language)
	{
		$languageLowerCase = strtolower($language);
		\Session::put('locale', $languageLowerCase);
		\App::setLocale($languageLowerCase);
		return \Redirect::back()->with('messages', array(trans("synthesiscms/main.msg_language_changed") . $languageLowerCase));
	}
}
