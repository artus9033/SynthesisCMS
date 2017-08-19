<?php

namespace App\Http\Middleware;

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
	public function handle($request, Closure $next, $guard = null)
	{
		if (\Auth::guest()) {
			if ($request->ajax()) {
				return response("Unathorized", 401);
			} else {
				return response(view('auth.error'));
			}
		} else if (!\Auth::user()->is_admin) {
			return \App::abort(401);
		}

		return $next($request);
	}
}
