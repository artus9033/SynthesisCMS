<?php

namespace App\Http;

use App\Toolbox;
use Carbon\Carbon;
use Dotenv\Dotenv;
use Exception;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use mysqli;

class Kernel extends HttpKernel
{

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * These middleware are run during every request to your application.
	 *
	 * IMPORTANT: adding any middleware here will make it impossible
	 * to prevent it's start; StartSession middleware is executed AFTER
	 * this middleware stack, so any middleware placed here
	 * should NOT use any class using the Session & things related to it
	 *
	 * @var array
	 */
	protected $middleware = [];

	/**
	 * The application's route middleware groups.
	 *
	 * @var array
	 */
	protected $middlewareGroups = [
		// web_internal - should be used by routes that are not meant to be indexed by stats tracker
		'web' => [
			//\App\Http\Middleware\SynthesisCMS\SynthesisInstallationCheckMiddleware::class,
			\Illuminate\Session\Middleware\StartSession::class,
			\App\Http\Middleware\Content\Locale::class,
			\Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
			\App\Http\Middleware\Content\SynthesisHtmlDynamicUrlHandlerMiddleware::class,
			\App\Http\Middleware\SynthesisCMS\SynthesisDevModeMiddleware::class,
			\App\Http\Middleware\Security\EncryptCookies::class,
			\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
			\Illuminate\View\Middleware\ShareErrorsFromSession::class,
			\App\Http\Middleware\Security\VerifyCsrfToken::class,
			\Illuminate\Routing\Middleware\SubstituteBindings::class,
			\App\Http\Middleware\Content\StatsTrackerMiddleware::class,
			\App\Http\Middleware\SynthesisCMS\HookExtensionsMiddleware::class,
			\App\Http\Middleware\SynthesisCMS\SynthesisFilesystemMiddleware::class,
			\App\Http\Middleware\SynthesisCMS\SynthesisStorageFilesystemSymlinksMiddleware::class,
		],

		// web_internal - should be used by routes that are not meant to be indexed by stats tracker
		'web_internal' => [
			//\App\Http\Middleware\SynthesisCMS\SynthesisInstallationCheckMiddleware::class,
			\Illuminate\Session\Middleware\StartSession::class,
			\App\Http\Middleware\Content\Locale::class,
			\Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
			\App\Http\Middleware\Content\SynthesisHtmlDynamicUrlHandlerMiddleware::class,
			\App\Http\Middleware\SynthesisCMS\SynthesisDevModeMiddleware::class,
			\App\Http\Middleware\Security\EncryptCookies::class,
			\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
			\Illuminate\View\Middleware\ShareErrorsFromSession::class,
			\App\Http\Middleware\Security\VerifyCsrfToken::class,
			\Illuminate\Routing\Middleware\SubstituteBindings::class,
			\App\Http\Middleware\SynthesisCMS\HookExtensionsMiddleware::class,
			\App\Http\Middleware\SynthesisCMS\SynthesisFilesystemMiddleware::class,
			\App\Http\Middleware\SynthesisCMS\SynthesisStorageFilesystemSymlinksMiddleware::class,
		],

		'admin' => [
			//\App\Http\Middleware\SynthesisCMS\SynthesisInstallationCheckMiddleware::class,
			\Illuminate\Session\Middleware\StartSession::class,
			\App\Http\Middleware\Content\Locale::class,
			\Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
			\App\Http\Middleware\Content\SynthesisHtmlDynamicUrlHandlerMiddleware::class,
			\App\Http\Middleware\SynthesisCMS\SynthesisDevModeMiddleware::class,
			\App\Http\Middleware\Security\EncryptCookies::class,
			\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
			\Illuminate\View\Middleware\ShareErrorsFromSession::class,
			\App\Http\Middleware\Security\VerifyCsrfToken::class,
			\Illuminate\Routing\Middleware\SubstituteBindings::class,
			\App\Http\Middleware\SynthesisCMS\SynthesisStorageFilesystemSymlinksMiddleware::class,
		],

		'api' => [
			//\App\Http\Middleware\SynthesisCMS\SynthesisInstallationCheckMiddleware::class,
			\Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
			'throttle:60,1',
			'bindings',
		],
	];
	/**
	 * The application's route middleware.
	 *
	 * These middleware may be assigned to groups or used individually.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
		'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
		'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
		'can' => \Illuminate\Auth\Middleware\Authorize::class,
		'guest' => \App\Http\Middleware\Auth\RedirectIfAuthenticated::class,
		'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
	];

	public function bootstrap()
	{
		if(!Toolbox::isRunningInConsole()) {
			$dotenv = new Dotenv(__DIR__ . '/../../');
			$dotenv->load();
			mysqli_report(MYSQLI_REPORT_STRICT);
			try {
				@(new mysqli(getenv('DB_HOST'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'), getenv('DB_DATABASE'), getenv('DB_PORT')));
			} catch (Exception $e) {
				echo("Cannot connect to database. Please contact the site administrator for help (P.S. Dear admin, everything You need to know to fix this error is in the error log).");
				error_log($e->getMessage());
				$synthesisBootstrapErrorLogFile = __DIR__ . '/../../storage/logs/synthesiscms-bootstrap-error.log';
				$message = Carbon::now()->toDateTimeString() . " : `" . $e->getMessage() . "`. This error means a problem with Your database connection. Please check your .env file configuration.";
				if (file_exists($synthesisBootstrapErrorLogFile)) {
					$fh = fopen($synthesisBootstrapErrorLogFile, 'a');
					fwrite($fh, $message . "\n");
				} else {
					$fh = fopen($synthesisBootstrapErrorLogFile, 'w');
					fwrite($fh, $message . "\n");
				}
				fclose($fh);
				exit;
			}
			parent::bootstrap();
		}
	}
}
