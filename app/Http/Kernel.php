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
     * IMPORTANT: adding any middleware here will make it impossible
     * to prevent it's start; StartSession middleware is executed AFTER
     * this middleware stack, so any middleware placed here
     * should NOT use any class using the Session & things related to it
     *
     * @var array
     */
    protected $middleware = [];

    /**
     * The application's route middleware grroups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        // web - public static routes tracked by the stats tracker; most extensions use this middleware group
        'web' => [
            //\App\Http\Middleware\SynthesisCMS\SynthesisInstallationCheckMiddleware::class,
            \App\Http\Middleware\SynthesisCMS\CheckDatabaseConnectionMiddleware::class,
            \App\Http\Middleware\Security\HttpsRedirectionMiddleware::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \App\Http\Middleware\Content\Locale::class,
            \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
            \App\Http\Middleware\SynthesisCMS\CheckIfSiteEnabled::class,
            \App\Http\Middleware\Security\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\Content\SynthesisHtmlDynamicUrlHandlerMiddleware::class,
            \App\Http\Middleware\SynthesisCMS\SynthesisDevModeMiddleware::class,
            \App\Http\Middleware\Security\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\Content\StatsTrackerMiddleware::class,
            \App\Http\Middleware\SynthesisCMS\HookExtensionsMiddleware::class,
            \App\Http\Middleware\SynthesisCMS\SynthesisFilesystemMiddleware::class,
        ],

        // uploads - public routes that are used for downloading files uploaded to the server; not meant to be indexed by stats tracker
        'uploads' => [
            \App\Http\Middleware\SynthesisCMS\CheckDatabaseConnectionMiddleware::class,
            \App\Http\Middleware\Security\HttpsRedirectionMiddleware::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \App\Http\Middleware\Content\Locale::class,
            \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
            \App\Http\Middleware\SynthesisCMS\CheckIfSiteEnabled::class,
            \App\Http\Middleware\Security\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\Content\SynthesisHtmlDynamicUrlHandlerMiddleware::class,
            \App\Http\Middleware\SynthesisCMS\SynthesisDevModeMiddleware::class,
            \App\Http\Middleware\Security\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\SynthesisCMS\HookExtensionsMiddleware::class,
            \App\Http\Middleware\SynthesisCMS\SynthesisFilesystemMiddleware::class,
        ],

        // web_internal - should be used by routes that are not meant to be indexed by stats tracker
        'web_internal' => [
            //\App\Http\Middleware\SynthesisCMS\SynthesisInstallationCheckMiddleware::class,
            \App\Http\Middleware\SynthesisCMS\CheckDatabaseConnectionMiddleware::class,
            \App\Http\Middleware\Security\HttpsRedirectionMiddleware::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \App\Http\Middleware\Content\Locale::class,
            \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
            \App\Http\Middleware\SynthesisCMS\CheckIfSiteEnabled::class,
            \App\Http\Middleware\Security\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\Content\SynthesisHtmlDynamicUrlHandlerMiddleware::class,
            \App\Http\Middleware\SynthesisCMS\SynthesisDevModeMiddleware::class,
            \App\Http\Middleware\Security\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\SynthesisCMS\HookExtensionsMiddleware::class,
            \App\Http\Middleware\SynthesisCMS\SynthesisFilesystemMiddleware::class,
        ],

        // web_internal_persistent - should be used by routes that are not meant to be indexed by stats tracker & that shouldn't be influenced by SynthesisCMS enable/disable site setting
        'web_internal_persistent' => [
            //\App\Http\Middleware\SynthesisCMS\SynthesisInstallationCheckMiddleware::class,
            \App\Http\Middleware\SynthesisCMS\CheckDatabaseConnectionMiddleware::class,
            \App\Http\Middleware\Security\HttpsRedirectionMiddleware::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \App\Http\Middleware\Content\Locale::class,
            \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
            \App\Http\Middleware\Security\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\Content\SynthesisHtmlDynamicUrlHandlerMiddleware::class,
            \App\Http\Middleware\SynthesisCMS\SynthesisDevModeMiddleware::class,
            \App\Http\Middleware\Security\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\SynthesisCMS\HookExtensionsMiddleware::class,
            \App\Http\Middleware\SynthesisCMS\SynthesisFilesystemMiddleware::class,
        ],

        'admin' => [
            //\App\Http\Middleware\SynthesisCMS\SynthesisInstallationCheckMiddleware::class,
            \App\Http\Middleware\SynthesisCMS\CheckDatabaseConnectionMiddleware::class,
            \App\Http\Middleware\Security\HttpsRedirectionMiddleware::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \App\Http\Middleware\Content\Locale::class,
            \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
            \App\Http\Middleware\Security\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\Content\SynthesisHtmlDynamicUrlHandlerMiddleware::class,
            \App\Http\Middleware\SynthesisCMS\SynthesisDevModeMiddleware::class,
            \App\Http\Middleware\Security\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            //\App\Http\Middleware\SynthesisCMS\SynthesisInstallationCheckMiddleware::class,
            \App\Http\Middleware\SynthesisCMS\CheckDatabaseConnectionMiddleware::class,
            \App\Http\Middleware\Security\HttpsRedirectionMiddleware::class,
            \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
            \App\Http\Middleware\SynthesisCMS\CheckIfSiteEnabled::class,
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
}
