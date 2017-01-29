<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileFormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Http\Requests\BackendRequest;
use App\Models\Content\Page;
use App\Models\Content\Molecule;
use App\Models\Content\Atom;
use App\Toolbox;

class ProfileController extends Controller
{
	public function infoGet()
	{
		if(Auth::check()){
			return view('auth.profile');
		}else{
			return view('auth.error');
		}
	}

	public function editGet()
	{
		if(Auth::check()){
			return view('auth.profile_password');
		}else{
			return view('auth.error');
		}
	}

	public function editPost(ProfileFormRequest $request)
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

	public function delete($id){
		$user = User::find($id);
		$user->delete();
		return \Redirect::back()->with('message', trans('synthesiscms/profile.msg_user_deleted'));
	}

	public function manageUsersGet()
	{
		return view('admin.manage_users');
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

	public function privilegesGet($id){
		$uname = User::select('name')->where('id', $id)->first()['name'];
		$privs = User::select('is_admin')->where('id', $id)->first()['is_admin'] == true;
		return view('admin.change_user_privileges', ['priv' => $privs, 'uid' => $id, 'uname' => $uname]);
	}

	public function changePrivilegesGet($id, BackendRequest $request){
		if($id == Auth::user()->id){
			return view('admin.change_user_privileges')->with('errors', trans("admin.err_cant_edit_self_privileges"));
		}
		$is_admin_new = $request->input("is_admin") === 'true'? true : false;
		$usr = User::find($id);
		$usr->is_admin = $is_admin_new;
		$usr->save();
		return \Redirect::route('manage_users')->with('message', trans('synthesiscms/admin.msg_user_privileges_successfully_changed', ['name' => $usr->name]));
	}
}