<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
	/**
	 * The application's global HTTP middleware stack.
	 *
	 * These middleware are run during every request to your application.
	 *
	 * @var array
	 */
	protected $middleware = [
		\Illuminate\Session\Middleware\StartSession::class,
		\App\Http\Middleware\Content\Locale::class,
		\Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
		\App\Http\Middleware\Content\SynthesisHtmlDynamicUrlHandlerMiddleware::class,
	];

	/**
	 * The application's route middleware groups.
	 *
	 * @var array
	 */
	protected $middlewareGroups = [
		'web' => [
			\App\Http\Middleware\Security\EncryptCookies::class,
			\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
			\Illuminate\View\Middleware\ShareErrorsFromSession::class,
			\App\Http\Middleware\Security\VerifyCsrfToken::class,
			\Illuminate\Routing\Middleware\SubstituteBindings::class,
			\App\Http\Middleware\Content\StatsTrackerMiddleware::class,
			\App\Http\Middleware\SynthesisCMS\HookExtensionsMiddleware::class,
			\App\Http\Middleware\SynthesisCMS\SynthesisFilesystemMiddleware::class,
		],

		// web_internal - should be used by routes that are not meant to be indexed by stats tracker
		'web_internal' => [
			\App\Http\Middleware\Security\EncryptCookies::class,
			\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
			\Illuminate\View\Middleware\ShareErrorsFromSession::class,
			\App\Http\Middleware\Security\VerifyCsrfToken::class,
			\Illuminate\Routing\Middleware\SubstituteBindings::class,
			\App\Http\Middleware\SynthesisCMS\HookExtensionsMiddleware::class,
			\App\Http\Middleware\SynthesisCMS\SynthesisFilesystemMiddleware::class,
		],

		'admin' => [
			\App\Http\Middleware\Security\EncryptCookies::class,
			\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
			\Illuminate\View\Middleware\ShareErrorsFromSession::class,
			\App\Http\Middleware\Security\VerifyCsrfToken::class,
			\Illuminate\Routing\Middleware\SubstituteBindings::class,
			\App\Http\Middleware\Auth\Admin::class,
		],

		'basic_auth' => [
			\App\Http\Middleware\Auth\BasicProfileMiddleware::class,
		],

		'api' => [
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
		'adminRole' => \App\Http\Middleware\Auth\Admin::class,
	];
}
