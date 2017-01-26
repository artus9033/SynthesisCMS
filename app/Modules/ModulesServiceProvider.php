<?php

namespace App\Modules;

use Illuminate\Support\ServiceProvider;
use App\Page;

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

			// Load the module config file
			if(file_exists(__DIR__.'/'.$module.'/Lang/'.$module.".php")) {
				$this->publishes([__DIR__.'/'.$module.'/Lang/'.$module.".php" => config_path(strtolower($module).".php")]);
			}

			// Load module database migrations
			if(is_dir(__DIR__.'/'.$module.'/Migrations')) {
				$this->loadMigrationsFrom(__DIR__.'/'.$module.'/Migrations');
			}
		}
		foreach (Page::all() as $key => $page) {
			if(is_null($page)){
				// no pages exist; do nothing
			}else{
				$mod_path = app_path() . "/Modules/" . $page->module . "/ModuleKernel.php";
				$mod_path = str_replace("/", "\\", $mod_path);
				if(file_exists($mod_path)){
					\App::make('\App\Modules\\'.$page->module.'\ModuleKernel')->routes($page, $page->slug);
				}else{
					return \View::make('errors.cms')->with(['error' => trans("synthesiscms/errors.err_module_not_found"), 'help' => trans("synthesiscms/errors.err_module_not_found_help")]);
				}
			}
		}
	}

	public function register() {}
	}
