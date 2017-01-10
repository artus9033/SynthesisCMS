<?php

namespace App\Modules;

use Illuminate\Support\ServiceProvider;

class ModulesServiceProvider extends ServiceProvider
{
	/**
	* Will make sure that the required modules have been fully loaded
	* @return void
	*/
	public function boot()
	{
		// For each of the registered modules, include their routes and Views
		$modules = config("synthesiscmsmodules.modules");

		while (list(,$module) = each($modules)) {

			// Load the routes for each of the modules
			if(file_exists(__DIR__.'/'.$module.'/laravelRoutes.php')) {
				include __DIR__.'/'.$module.'/laravelRoutes.php';
			}

			// Load the views
			if(is_dir(__DIR__.'/'.$module.'/Views')) {
				$this->loadViewsFrom(__DIR__.'/'.$module.'/Views', $module);
			}
			// Load the translation files, then callable by trans("module::path.to.file.and.value.from.module.lang")
			// where 'module' is the name of module starting with lower case!
			if(is_dir(__DIR__.'/'.$module.'/Lang')) {
				$this->loadTranslationsFrom(__DIR__.'/'.$module.'/Lang', $module);
			}
		}
	}

	public function register() {}
	}
