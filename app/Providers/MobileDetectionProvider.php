<?php

namespace App\Providers;

use Detection\MobileDetect;
use Illuminate\Support\ServiceProvider;

class MobileDetectionProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		if (!\App::runningInConsole()) {
			$detect = new MobileDetect();

			/*
			 * Device detection
			 */

			$bIsAnyMobile = $detect->isMobile();
			$bIsTablet = $detect->isTablet();
			$bIsPhone = ($bIsAnyMobile && !$bIsTablet);
			$bIsDesktop = !$bIsAnyMobile;

			view()->share("synthesiscmsClientIsPhone", $bIsPhone);
			view()->share("synthesiscmsClientIsTablet", $bIsTablet);
			view()->share("synthesiscmsClientIsDesktop", $bIsDesktop);
			view()->share("synthesiscmsClientIsAnyMobile", $bIsAnyMobile);

			/*
			 * TODO: Browser & OS detection
			 */
		}
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}
