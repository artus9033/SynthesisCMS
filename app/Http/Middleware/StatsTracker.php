<?php

namespace App\Http\Middleware;

use App\Models\Stats\Tracker;
use Closure;

class StatsTracker
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
		Tracker::hit();

		return $next($request);
	}
}
