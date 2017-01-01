<?php

namespace App\Http\Middleware;

use Closure;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
  {
    if (\Auth::guard($guard)->guest()) {
      if ($request->ajax()) {
        return response('Unauthorized', 401);
      } else {
        return redirect()->guest('login');
      }
 } else if (!\Auth::guard($guard)->user()->is_admin) {
      return redirect()->guest('login');//TODO view('auth.error');
    }

    return $next($request);
  }
}
