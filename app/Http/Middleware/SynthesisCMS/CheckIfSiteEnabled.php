<?php

namespace App\Http\Middleware\SynthesisCMS;

use App\Models\Settings\Settings;
use App\SynthesisCMS\API\Auth\UserPrivilegesManager;
use App\Toolbox;
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
    	//TODO: rename the setting from enable site to maintenance mode
		if(!Settings::getActiveInstance()->getField('site_enabled')) {
			if(UserPrivilegesManager::isSiteManager()){
				Toolbox::addWarningToBag(trans('synthesiscms/main.warning_site_disabled'));
			}else {
				throw new MaintenanceModeException(Carbon::now()->getTimestamp(), 40, 'Please try again later');
			}
		}

        return $next($request);
    }
}
