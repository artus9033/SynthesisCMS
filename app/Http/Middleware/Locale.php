<?php

namespace App\Http\Middleware;

use Closure;
use App\Toolbox;

class Locale
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
		/**
		* Check if session started
		* (if no, then the app is probably in maintenance mode, but
		* locale needs to be set anyway e.g. for displaying the 503 error page)
		**/
		$session_started = true;
		if (version_compare(PHP_VERSION, "5.4.0") >= 0) {
			$sess = session_status();
			if ($sess == PHP_SESSION_NONE) {
				$session_started = false;
			}
		} else {
			if (!$_SESSION) {
				$session_started = false;
			}
		}
		if($session_started){
			if($request->session()->has('locale')){
				\App::setLocale($request->session()->get('locale'));
			}else{
				\App::setLocale(strtolower(Toolbox::getBrowserLocale()));
			}
		}else{
			\App::setLocale(strtolower(Toolbox::getBrowserLocale()));
		}

		return $next($request);
	}
}
