<?php

namespace App\Http\Middleware\Content;

use App\Models\Settings\Settings;
use Closure;

class SettingsVariablesProviderMiddleware
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
			view()->share('synthesiscmsMainColor', Settings::getFromActive('main_color'));
			view()->share('synthesiscmsTabColor', Settings::getFromActive('tab_color'));
			view()->share('synthesiscmsMainColorClass', Settings::getFromActive('color_class'));

			view()->share('synthesiscmsHeaderTitle', Settings::getFromActive('header_title'));
			view()->share('synthesiscmsTabTitle', Settings::getFromActive('tab_title'));
			view()->share('synthesiscmsHomePage', Settings::getFromActive('home_page'));

			view()->share('synthesiscmsFooterCopyright', Settings::getFromActive('footer_copyright'));
			view()->share('synthesiscmsFooterMoreLinksBottomText', Settings::getFromActive('footer_more_links_bottom_text'));
			view()->share('synthesiscmsFooterMoreLinksBottomHref', Settings::getFromActive('footer_more_links_bottom_href'));

			view()->share('synthesiscmsFooterLinksText', Settings::getFromActive('footer_links_text'));
			view()->share('synthesiscmsFooterLinksContent', Settings::getFromActive('footer_links_content'));
			view()->share('synthesiscmsFooterHeader', Settings::getFromActive('footer_header'));
			view()->share('synthesiscmsFooterContent', Settings::getFromActive('footer_content'));
		}

		return $next($request);
	}
}