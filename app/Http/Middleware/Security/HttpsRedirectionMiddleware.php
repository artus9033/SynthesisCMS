<?php

namespace App\Http\Middleware\Security;

use App\Models\Settings\Settings;
use Closure;

class HttpsRedirectionMiddleware
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
		if (!$request->secure() && Settings::getActiveInstance()->getField('force_https')) {
			return redirect()->secure($request->path());
		}

        return $next($request);
    }
}
