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
        view()->share('synthesiscmsMainColor', Settings::getFromActive('main_color'));
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
