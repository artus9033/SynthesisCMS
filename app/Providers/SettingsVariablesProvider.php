<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Settings\Settings;
use Illuminate\View\View;

class SettingsVariablesProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
	    if(!\App::runningInConsole()){
		    view()->share('synthesiscmsMainColor', Settings::getFromActive('main_color'));
		    view()->share('synthesiscmsHeaderTitle', Settings::getFromActive('header_title'));
		    view()->share('synthesiscmsTabColor', Settings::getFromActive('tab_color'));
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
