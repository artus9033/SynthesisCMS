<?php

namespace App\Http\Middleware\SynthesisCMS;

use App\Models\Settings\Settings;
use App\Toolbox;
use Closure;

class SynthesisDevModeMiddleware
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
		if (!Toolbox::hasWarningInBag(trans('synthesiscms/settings.msg_warning_dev_mode_active')) && Settings::isDevModeEnabled()) {
			Toolbox::addWarningToBag(trans('synthesiscms/settings.msg_warning_dev_mode_active'));
		}
		return $next($request);
	}
}
