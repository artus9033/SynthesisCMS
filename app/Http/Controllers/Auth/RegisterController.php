<?php

namespace App\Http\Controllers\Auth;

use App\Toolbox;
use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\Settings\Settings;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Validator;

class RegisterController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Register Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users as well as their
	| validation and creation. By default this controller uses a trait to
	| provide this functionality without requiring any additional code.
	|
	*/

	use RegistersUsers;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data)
	{
		return Validator::make($data, [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:' . User::getTableName(),
			'password' => 'required|min:6|confirmed',
		]);
	}

	/**
	 * Where to redirect users after login / registration.
	 *
	 * @return string
	 */
	protected function redirectTo(){
		return Settings::getActiveInstance()->getField('home_page');
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array $data
	 * @return User
	 */
	protected function create(array $data)
	{
		$bIsAdmin = false;
		if (User::all()->isEmpty()) {
			$bIsAdmin = true;
		}
		return User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
			'is_admin' => $bIsAdmin,
		]);
	}

	/**
	 * The user has been registered.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  mixed  $user
	 * @return mixed
	 */
	protected function registered(Request $request, $user)
	{
		Toolbox::addToastToBag(trans('synthesiscms/auth.toast_registered_successfully', ['username' => $user->name]));
	}
}
