<?php

namespace App\Extensions;

use Illuminate\Support\ServiceProvider;
use App\Models\Content\Page;
use App\SynthesisCMS\API\Positions\SynthesisPositionManager;

class ExtensionsServiceProvider extends ServiceProvider
{

	/**
	* Will make sure that the required extensions have been fully loaded
	* @return void
	*/
	public function boot()
	{
		if(\App::runningInConsole()){
			// For each of the registered extensions, include ONLY their migrations
			// as the app is running in a command line
			$extensions = config("synthesiscmsextensions.extensions");

			while (list(,$extension) = each($extensions)) {
				// Load extension database migrations
				if(is_dir(__DIR__.'/'.$extension.'/Migrations')) {
					$this->loadMigrationsFrom(__DIR__.'/'.$extension.'/Migrations');
				}

				// Load the extension config file
				if(file_exists(__DIR__.'/'.$extension.'/Lang/'.$extension.".php")) {
					$this->publishes([__DIR__.'/'.$extension.'/Lang/'.$extension.".php" => config_path(strtolower($extension).".php")]);
				}
			}
		}else{

			$manager = new SynthesisPositionManager();

			// For each of the registered extensions, include their routes and Views
			$extensions = config("synthesiscmsextensions.extensions");

			while (list(,$extension) = each($extensions)) {

				// Load the routes for each of the extensions
				if(file_exists(__DIR__.'/'.$extension.'/laravelRoutes.php')) {
					include __DIR__.'/'.$extension.'/laravelRoutes.php';
				}

				// Load the views
				if(is_dir(__DIR__.'/'.$extension.'/Views')) {
					$this->loadViewsFrom(__DIR__.'/'.$extension.'/Views', $extension);
				}
				// Load the translation files, then callable by trans("extension::path.to.file.and.value.from.extension.lang")
				// where 'extension' is the name of extension starting with lower case!
				if(is_dir(__DIR__.'/'.$extension.'/Lang')) {
					$this->loadTranslationsFrom(__DIR__.'/'.$extension.'/Lang', $extension);
				}

				// Load the extension config file
				if(file_exists(__DIR__.'/'.$extension.'/Lang/'.$extension.".php")) {
					$this->publishes([__DIR__.'/'.$extension.'/Lang/'.$extension.".php" => config_path(strtolower($extension).".php")]);
				}

				// Load extension database migrations
				if(is_dir(__DIR__.'/'.$extension.'/Migrations')) {
					$this->loadMigrationsFrom(__DIR__.'/'.$extension.'/Migrations');
				}

				// Load defines & hooks of positions
				$kpath = 'App\\Extensions\\'.$extension.'\\ExtensionKernel';
				$kernel = new $kpath;
				$kernel->hookPositions($manager);
			}

			view()->share('synthesiscmsPositionManager', $manager);

			foreach (Page::all() as $key => $page) {
				if(is_null($page)){
					// no pages exist; do nothing
				}else{
					$ext_path = app_path() . "/Extensions/" . $page->extension . "/ExtensionKernel.php";
					$ext_path = str_replace("/", '\\', $ext_path);
					if(file_exists($ext_path)){
						\App::make('\App\Extensions\\'.$page->extension.'\ExtensionKernel')->routes($page, $page->slug);
					}else{
						return \View::make('errors.cms')->with(['error' => trans("synthesiscms/errors.err_extension_not_found"), 'help' => trans("synthesiscms/errors.err_extension_not_found_help")]);
					}
				}
			}
		}
	}

	public function register() {}
	}
