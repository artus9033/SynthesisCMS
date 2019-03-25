<?php

namespace App\Http\Middleware\SynthesisCMS;

use Closure;
use App\Http\Controllers\Backend\SynthesisFilesystemController;

class SynthesisFilesystemMiddleware
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
		if (!SynthesisFilesystemController::checkPublicDirectoryResourcesFilesystemOK()) {
			return response(view('errors.cms')->with(
				[
					'error' => trans('synthesiscms/errors.error_resources_need_compilation_text'),
					'help' => trans('synthesiscms/errors.error_resources_need_compilation_help')
				]
			));
		} else {
			return $next($request);
		}
	}
}