<?php

namespace App\Providers;

use App\Models\Content\Page;
use App\SynthesisCMS\API\Positions\SynthesisPositionManager;
use Dotenv\Dotenv;
use Exception;
use Illuminate\Support\ServiceProvider;

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

        if (\App::runningInConsole()) {
            foreach ($extensionsDirlist as $key => $extension) {
                // Load extension database migrations
                if (is_dir($extension . '/Migrations')) {
                    $this->loadMigrationsFrom($extension . '/Migrations');
                }
            }
        }
        $dotenv = method_exists("\Dotenv\Dotenv", "create") ? Dotenv::create(base_path()) : new Dotenv(base_path());
        $dotenv->load();

        try {
            foreach (Page::all() as $key => $page) {
                if ($page) {
                    $ext_path = app_path() . "/Extensions/" . $page->extension . "/ExtensionKernel.php";
                    if (file_exists($ext_path)) {
                        \App::make('\App\Extensions\\' . $page->extension . '\ExtensionKernel')->routes($page, $page->slug);
                    }
                }
            }
        } catch (Exception $e) {}

        if (!\App::runningInConsole()) {
            $manager = new SynthesisPositionManager();
            $extensions = array();

            foreach ($extensionsDirlist as $key => $extension) {
                $extension = basename($extension);

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
                $kpath = '\App\\Extensions\\' . $extension . '\\ExtensionKernel';
                $kernel = new $kpath;
                $kernel->hookPositions($manager);
                $kernel->registerMiddleware();

                array_push($extensions, array($kernel, $extension));
            }

            view()->share('synthesiscmsPositionManager', $manager);
            view()->share('synthesiscmsExtensions', $extensions);
        }
    }

    public function register()
    {
    }
}
