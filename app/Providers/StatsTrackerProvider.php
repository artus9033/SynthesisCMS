<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Stats\Tracker;

class StatsTrackerProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
	   if(!\App::runningInConsole()){
        	Tracker::hit();
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
