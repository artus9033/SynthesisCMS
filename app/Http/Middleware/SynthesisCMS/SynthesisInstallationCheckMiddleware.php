<?php

namespace App\Http\Middleware\SynthesisCMS;

use App\Models\Installer\InstallerModel;
use App\Toolbox;
use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SynthesisInstallationCheckMiddleware
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
		$cmsAlright = false;
		try {
			if(DB::connection()){
				if (Schema::hasTable(with(new InstallerModel())->getTable())) {
					if (InstallerModel::wasEverInstalled()) {
						$cmsAlright = true;
					}
				}
			}
		} catch (\Exception $e) {
			$cmsAlright = false;
		}
		if($request->url() == route('install')){
			if($cmsAlright) {
				return response(view('installer.error_already_installed'));
			}
		}else{
			if(!$cmsAlright) {
				// The locale middleware won't be executed if execution block reaches here
				\App::setLocale(strtolower(Toolbox::getBrowserLocale()));
				return response(view('installer.error_not_installed'));
			}
		}
		return $next($request);
	}
}
