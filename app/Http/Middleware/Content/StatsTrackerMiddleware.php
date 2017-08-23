<?php

namespace App\Http\Middleware\Content;

use App\Models\Stats\StatsTracker;
use Closure;

class StatsTrackerMiddleware
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
		StatsTracker::hit();

		return $next($request);
	}
}
