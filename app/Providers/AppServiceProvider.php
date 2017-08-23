<?php

namespace App\Providers;

use App\SynthesisCMS\API\Constants;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		if (!\App::runningInConsole()) {
			view()->share('synthesiscmsUrlMiddlewareHandlerStartTag', Constants::synthesiscmsUrlMiddlewareHandlerStartTag);
			view()->share('synthesiscmsUrlMiddlewareHandlerEndTag', Constants::synthesiscmsUrlMiddlewareHandlerEndTag);
		}
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}
