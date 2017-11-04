<?php

namespace App\Providers;

use App\Models\Content\Page;
use App\Models\Settings\Settings;
use App\SynthesisCMS\API\Positions\SynthesisPositionManager;
use Dotenv\Dotenv;
use Exception;
use Illuminate\Support\ServiceProvider;
use mysqli;

class ExtensionsServiceProvider extends ServiceProvider
{

	/**
	 * Will make sure that the required extensions have been fully loaded
	 * @return void
	 */
	public function boot()
	{
		$extensionsDirectoryPath = dirname(__DIR__) . '/Extensions/';
		$extensionsDirlist = glob($extensionsDirectoryPath . "*");

		if(\App::runningInConsole()) {
			while (list(, $extension) = each($extensionsDirlist)) {
				// Load extension database migrations
				if (is_dir($extension . '/Migrations')) {
					$this->loadMigrationsFrom($extension . '/Migrations');
				}
			}
		}
		$dbConnectionGood = true;
		$dotenv = new Dotenv(base_path());
		$dotenv->load();
		mysqli_report(MYSQLI_REPORT_STRICT);
		try {
			@(new mysqli(getenv('DB_HOST'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'), getenv('DB_DATABASE'), getenv('DB_PORT')));
		} catch (Exception $e) {
			$dbConnectionGood = false;
		}
		try {
			if($dbConnectionGood) {
				foreach (Page::all() as $key => $page) {
					if ($page) {
						$ext_path = app_path() . "/Extensions/" . $page->extension . "/ExtensionKernel.php";
						if (file_exists($ext_path)) {
							\App::make('\App\Extensions\\' . $page->extension . '\ExtensionKernel')->routes($page, $page->slug);
						}
					}
				}
			}
		} catch (Exception $e) {}

		if (!\App::runningInConsole()) {
			$manager = new SynthesisPositionManager();
			$settingsInstance = Settings::getActiveInstance();
			if(!is_null($settingsInstance)) {
				// For each of the registered extensions, include their routes, views & translations
				$extensions = $settingsInstance->getInstalledExtensions();
			}else{
				$extensions = array();
			}

			while (list(, $extension) = each($extensions)) {

				// Load the routes for each of the extensions
				if (file_exists($extensionsDirectoryPath . $extension . '/laravelRoutes.php')) {
					include $extensionsDirectoryPath . $extension . '/laravelRoutes.php';
				}

				// Load views
				if (is_dir($extensionsDirectoryPath . $extension . '/Views')) {
					$this->loadViewsFrom($extensionsDirectoryPath . $extension . '/Views', $extension);
				}
				// Load translation files, then callable by trans("extensionName::path.to.file.and.value.from.extension.lang")
				if (is_dir($extensionsDirectoryPath . $extension . '/Lang')) {
					$this->loadTranslationsFrom($extensionsDirectoryPath . $extension . '/Lang', $extension);
				}

				// Load defines & hooks of positions
				$kpath = 'App\\Extensions\\' . $extension . '\\ExtensionKernel';
				$kernel = new $kpath;
				$kernel->hookPositions($manager);
				$kernel->registerMiddleware();
			}

			view()->share('synthesiscmsPositionManager', $manager);
		}
	}

	public function register()
	{
	}
}