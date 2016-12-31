<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function lang($language){
	    $language2 = strtolower($language);
	    echo($language2);
	    Session::put('language',$language2);
	    \App::setLocale($language2);
	    return \Redirect::route('home')->with('message', trans("synthesiscms/main.msg_language_changed") . $language);
    }
}
