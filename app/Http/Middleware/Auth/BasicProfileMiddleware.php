<?php

namespace App\Http\Middleware\Auth;

use App\SynthesisCMS\API\Auth\UserPrivilegesManager;
use Closure;

class BasicProfileMiddleware
{
	/**
	 * This middleware checks if the user performing request
	 * is logged in to any account, otherwise it shows an error screen
	 */

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = null)
	{
		if (UserPrivilegesManager::isAuthenticated()) {
			return $next($request);
		} else {
			return response(view('auth.error'));
		}
	}
}
