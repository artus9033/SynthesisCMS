<?php

namespace App\Http\Middleware\SynthesisCMS;

use Closure;

class HookExtensionsMiddleware
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
		if (!\App::runningInConsole()) {
			// For each of the registered extensions, include their middleware
			$extensions = \App\Models\Settings\Settings::getActiveInstance()->getInstalledExtensions();
			$exec_next = true;
			while (list(, $extension) = each($extensions)) {
				$kpath = 'App\\Extensions\\' . $extension . '\\ExtensionKernel';
				$kernel = new $kpath;
				if (!$kernel->registerMiddleware($request, $next)) {
					$exec_next = false;
					break;
				}
			}
			if ($exec_next) {
				return $next($request);
			}
		}
	}
}
