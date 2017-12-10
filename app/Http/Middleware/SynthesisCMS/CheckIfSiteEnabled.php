<?php

namespace App\Http\Middleware\SynthesisCMS;

use App\Models\Settings\Settings;
use Carbon\Carbon;
use Closure;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;

class CheckIfSiteEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		if(!Settings::getActiveInstance()->getField('site_enabled')){

			throw new MaintenanceModeException(Carbon::now()->getTimestamp(), 'Please try again later', 'Maintenance break');
		}

        return $next($request);
    }
}
