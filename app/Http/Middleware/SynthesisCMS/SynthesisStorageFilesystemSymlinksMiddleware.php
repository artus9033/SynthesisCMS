<?php

namespace App\Http\Middleware\SynthesisCMS;

use App\SynthesisCMS\API\Auth\UserPrivilegesManager;
use App\SynthesisCMS\API\Scripts\SynthesisArtisanBridge;
use App\Toolbox;
use Closure;
use App\Http\Controllers\Backend\SynthesisFilesystemController;

class SynthesisStorageFilesystemSymlinksMiddleware
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
		if (!file_exists(public_path("storage"))) {
			SynthesisArtisanBridge::artisanStorageLink();
			if(UserPrivilegesManager::isContentEditor()) {
				// Only show the toast to site administration members
				Toolbox::addToastToBag(trans("synthesiscms/main.toast_middleware_symlink_created"));
			}
		}
		return $next($request);
	}
}
