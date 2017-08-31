<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
	/**
	 * This namespace is applied to your controller routes.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'App\Http\Controllers';

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @return void
	 */
	public function boot()
	{
		//

		parent::boot();
	}

	/**
	 * Define the routes for the application.
	 *
	 * @return void
	 */
	public function map()
	{
		$this->mapApiRoutes();

		$this->mapWebInternalRoutes();

		$this->mapAdminRoutes();

		$this->mapWebRoutes();

		$this->mapNoMiddlewareRoutes();
	}

	/**
	 * Define the "api" routes for the application.
	 *
	 * These routes are typically stateless.
	 *
	 * @return void
	 */
	protected function mapApiRoutes()
	{
		Route::group([
			'middleware' => 'api',
			'namespace' => $this->namespace,
			'prefix' => 'api',
		], function ($router) {
			require base_path('routes/api.php');
		});
	}

	/**
	 * Define the "web_internal" routes for the application.
	 *
	 * These routes all receive session state, CSRF protection, etc.,
	 *
	 * but they are NOT tracked by the Stats Tracker
	 *
	 * @return void
	 */
	protected function mapWebInternalRoutes()
	{
		Route::group([
			'middleware' => 'web_internal',
			'namespace' => $this->namespace,
		], function ($router) {
			require base_path('routes/web_internal.php');
		});
	}

	/**
	 * Define the "admin" routes for the application.
	 *
	 * These routes are forced to check auth, encrypt cookies, use CSRF, etc.
	 *
	 * @return void
	 */
	protected function mapAdminRoutes()
	{
		Route::group([
			'middleware' => 'admin',
			'namespace' => $this->namespace,
		], function ($router) {
			require base_path('routes/admin.php');
		});
	}

	/**
	 * Define the "web" routes for the application.
	 *
	 * These routes all receive session state, CSRF protection, a Stats Tracker, etc.
	 *
	 * @return void
	 */
	protected function mapWebRoutes()
	{
		Route::group([
			'middleware' => 'web',
			'namespace' => $this->namespace
		], function ($router) {
			require base_path('routes/web.php');
		});
	}

	/**
	 * Define the "no-middleware" routes for the application.
	 *
	 * These routes only receive basic middleware, such as session, locale, csrf, cookies encryption,
	 * but are excluded from any additional middleware
	 *
	 * @return void
	 */
	protected function mapNoMiddlewareRoutes()
	{
		Route::group([
			'namespace' => $this->namespace,
		], function ($router) {
			require base_path('routes/no_middleware.php');
		});
	}
}
