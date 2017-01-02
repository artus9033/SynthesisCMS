<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BackendRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;

class BackendController extends Controller
{

	public function index()
	{
		if(Auth::check() && Auth::user()->is_admin){
			return view('admin.admin');
		}else{
			return view('auth.error');
		}
	}

	public function manageUsersGet()
	{
		if(Auth::check()){
			return view('admin.manage_users');
		}else{
			return view('auth.error');
		}
	}

	public function manageUsersPost(BackendRequest $request)
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

	public function privileges($id){
		$uname = User::select('name')->where('id', $id)->first()['name'];
		$privs = User::select('is_admin')->where('id', $id)->first()['is_admin'] == true;
		return view('admin.change_user_privileges', ['priv' => $privs, 'uid' => $id, 'uname' => $uname]);
	}

	public function privileges_change($id, BackendRequest $request){
		if($id == Auth::user()->id){
			return view('admin.change_user_privileges')->with('errors', trans("admin.err_cant_edit_self_privileges"));
		}
		$is_admin_new = $request->input("is_admin") === 'true'? true : false;
		$usr = User::find($id);
		$usr->is_admin = $is_admin_new;
		$usr->save();
		return \Redirect::route('manage_users')->with('message', trans('synthesiscms/admin.msg_user_privileges_successfully_changed', ['name' => $usr->name]));
	}

	public function manageRoutesGet()
	{
		if(Auth::check()){
			return view('admin.manage_routes');
		}else{
			return view('auth.error');
		}
	}

	public function manageRoutesPost($id, BackendRequest $request)
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
