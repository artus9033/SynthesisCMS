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
        $settings = Settings::getActiveInstance();

        if (is_null($settings)) {
            $isDevModeEnabled = false;
        } else {
            $isDevModeEnabled = $settings->isDevModeEnabled();
        }

        if ($isDevModeEnabled) {
            \Barryvdh\Debugbar\Facade::enable();
        } else {
            \Barryvdh\Debugbar\Facade::disable();
        }

        if (!Toolbox::hasWarningInBag(trans('synthesiscms/settings.msg_warning_dev_mode_active')) && $isDevModeEnabled) {
            Toolbox::addWarningToBag(trans('synthesiscms/settings.msg_warning_dev_mode_active'));
        }

        return $next($request);
    }
}
