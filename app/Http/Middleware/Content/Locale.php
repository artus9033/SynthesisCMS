<?php

namespace App\Http\Middleware\Content;

use App\Toolbox;
use Closure;

class Locale
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
		if ($request->session()->has('locale')) {
			\App::setLocale($request->session()->get('locale'));
		} else {
			\App::setLocale(strtolower(Toolbox::getBrowserLocale()));
		}

		setlocale(LC_ALL, \App::getLocale());

		return $next($request);
	}
}
