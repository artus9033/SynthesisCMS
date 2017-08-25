<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Toolbox;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles authenticating users for the application and
	| redirecting them to your home screen. The controller uses a trait
	| to conveniently provide its functionality to your applications.
	|
	*/

	use AuthenticatesUsers;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest', ['except' => 'logout']);
	}

	/**
	 * Log the user out of the application.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function logout(Request $request)
	{
		$this->guard()->logout();

		// Store the chosen site language before flushing the session
		$langBackup = Session::get('locale');

		Session::invalidate();

		// Reflash the chosen site language after flushing the session
		Session::put('locale', $langBackup);

		Toolbox::addToastToBag(trans('synthesiscms/auth.logout_message'));

		return redirect(\App\Models\Settings\Settings::getFromActive('home_page'));
	}

	/**
	 * The user has been authenticated.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  mixed $user
	 * @return mixed
	 */
	protected function authenticated(Request $request, $user)
	{
		Toolbox::addToastToBag(trans('synthesiscms/auth.login_message', ['username' => $user->name]));
		return response()->redirectToIntended(route('profile'));
	}
}
