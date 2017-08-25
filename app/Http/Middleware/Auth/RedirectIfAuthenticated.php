<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
	/**
	 * Handle an incoming request.
	 * Redirects to the profile route if the user
	 * tries to access a login, register, etc. route
	 * and is already logged in
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @param  string|null $guard
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = null)
	{
		if (Auth::guard($guard)->check()) {
			return redirect(route('profile'));
		}

		return $next($request);
	}
}
