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
            $synthesiscmsExtensions = view()->shared("synthesiscmsExtensions");
            $exec_next = true;
            foreach ($synthesiscmsExtensions as $extensionPack) {
                $kernel = $extensionPack[0];
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
