<?php

namespace App\Http\Middleware\Auth;

use App\SynthesisCMS\API\Auth\UserPrivilegesManager;
use Closure;

class Admin
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (UserPrivilegesManager::isGuest()) {
			if ($request->expectsJson()) {
				return response("Unauthorized.", 401);
			} else {
				return abort(403);
			}
		}

		return $next($request);
	}
}
