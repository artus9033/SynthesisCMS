<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileFormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;

class ProfileController extends Controller
{
	public function info()
	{
		if(Auth::check()){
			return view('auth.profile');
		}else{
			return view('auth.error');
		}
	}

	public function info_edit()
	{
		if(Auth::check()){
			return view('auth.profile_password');
		}else{
			return view('auth.error');
		}
	}

	public function edit(ProfileFormRequest $request)
	{
		$passwd = $request->get('newpassword');
		$passwd2 = $request->get('newpassword2');
		$passwd_old = $request->get('oldpassword');
		$errors = array();
		$err = false;

		if($passwd != $passwd2){
			$err = true;
			array_push($errors, trans('synthesiscms/auth.err_passwords_differ'));
		}

		if(!($passwd != "" && strlen($passwd) >= 6)){
			$err = true;
			array_push($errors, trans('synthesiscms/auth.err_password_too_short'));
		}

		if(\Hash::check($passwd_old, Auth::user()->getAuthPassword())){
			Auth::user()->password = \Hash::make($passwd);
		}else{
			$err = true;
			array_push($errors, trans('synthesiscms/auth.err_password_original_bad'));
		}

		if($err){
			return \Redirect::route('profile')->with('errors', $errors);
		}else{
			Auth::user()->save();
			return \Redirect::route('profile')->with('message', trans('synthesiscms/auth.msg_changed_passwd'));
		}
	}
}
