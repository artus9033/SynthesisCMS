<?php

namespace App\Providers;

use App\Models\Settings\Settings;
use Illuminate\Support\ServiceProvider;

class SettingsVariablesProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		if (!\App::runningInConsole()) {
			$settingsInstance = Settings::getActiveInstance();

			if(!is_null($settingsInstance)) {
				view()->share('synthesiscmsMainColor', $settingsInstance->getField('main_color'));
				view()->share('synthesiscmsMainColorClass', $settingsInstance->getField('color_class'));
				view()->share('synthesiscmsTabColor', $settingsInstance->getField('tab_color'));
				view()->share('synthesiscmsLogoBackgroundColor', $settingsInstance->getField('logo_background_color'));
				view()->share('synthesiscmsShowImageBigBanner', $settingsInstance->getField('show_image_big_banner'));

				view()->share('synthesiscmsHeaderTitle', $settingsInstance->getField('header_title'));
				view()->share('synthesiscmsTabTitle', $settingsInstance->getField('tab_title'));
				view()->share('synthesiscmsHomePage', $settingsInstance->getField('home_page'));
				view()->share('synthesiscmsShowLoginRegisterButtons', $settingsInstance->getField('show_login_register_buttons'));

				view()->share('synthesiscmsFooterCopyright', $settingsInstance->getField('footer_copyright'));
				view()->share('synthesiscmsFooterMoreLinksBottomText', $settingsInstance->getField('footer_more_links_bottom_text'));
				view()->share('synthesiscmsFooterMoreLinksBottomHref', $settingsInstance->getField('footer_more_links_bottom_href'));

				view()->share('synthesiscmsFooterLinksText', $settingsInstance->getField('footer_links_text'));
				view()->share('synthesiscmsFooterLinksContent', $settingsInstance->getField('footer_links_content'));
				view()->share('synthesiscmsFooterHeader', $settingsInstance->getField('footer_header'));
				view()->share('synthesiscmsFooterContent', $settingsInstance->getField('footer_content'));
			}
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
