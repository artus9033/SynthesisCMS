<?php

namespace App\Exceptions;

use App\Models\Settings\Settings;
use App\Models\Stats\ExceptionTracker;
use App\Toolbox;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthenticationException::class,
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        TokenMismatchException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        if (!$exception instanceof NotFoundHttpException && !$exception instanceof MaintenanceModeException && !$exception instanceof ServiceUnavailableHttpException) {
            $settings = Settings::getActiveInstance();

            if (is_null($settings)) {
                // works, executed here, because if settings db table doesn't exist,
                // then the dev middleware is unlikely to even be executed before the error handler (here), which ends the app
                $devMode = false;
            } else {
                $devMode = $settings->isDevModeEnabled();
            }

            if (Toolbox::isRunningInConsole()) {
                \Log::critical($exception->getTraceAsString());
            } else {
                parent::report($exception);

                $continue = false;
                $fullPath = str_replace("/", "\\", base_path());

                try {
                    if (Schema::hasTable(with(new ExceptionTracker())->getTable())) {
                        $continue = true;
                    }
                } catch (Exception $e) {
                    $continue = false;
                }

                if ($continue) {
                    ExceptionTracker::saveException($devMode, $exception->getCode(), str_replace($fullPath, "[cms_root]", $exception->getFile()), str_replace($fullPath, "[cms_root]", $exception->getMessage()), str_replace($fullPath, "[cms_root]", $exception->getTraceAsString()), $fullPath);
                }

                \Log::critical($exception->getTraceAsString());
            }
        }
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof TokenMismatchException) {
            Toolbox::addWarningToBag(trans('synthesiscms/errors.warning_csrf_token_expired_please_try_again'));
            return redirect()->back();
        }

        if ($exception instanceof ValidationException) {
            // adding messages/warnings/errors should be handled by the app itself during validation
            // calling parent::render makes sure that all these messages will be flashed to the session
            return parent::render($request, $exception);
        }

        \App::setLocale(strtolower(Toolbox::getBrowserLocale()));

        $settings = Settings::getActiveInstance();

        if (is_null($settings)) {
            // works, executed here, because if settings db table doesn't exist,
            // then the dev middleware is unlikely to even be executed before the error handler (here), which ends the app
            return response(view('errors/fatal')->with(['error' => trans('synthesiscms/errors.db_not_migrated'), 'help' => trans('synthesiscms/errors.db_not_migrated_help')]));
        } else {
            $continue = $settings->isDevModeEnabled();
        }

        if ($continue) {
            \Barryvdh\Debugbar\Facade::enable();
            return parent::render($request, $exception);
        } else {
            \Barryvdh\Debugbar\Facade::disable();
            if ($exception instanceof NotFoundHttpException) {
                return response()->view("errors/404")->setStatusCode(404);
            } else if ($exception instanceof MaintenanceModeException || $exception instanceof ServiceUnavailableHttpException) {
                return response()->view("errors/503")->setStatusCode(503);
            } else if ($exception instanceof AccessDeniedException || $exception instanceof AuthorizationException || $exception instanceof AuthenticationException) {
                return response()->view("errors/403")->setStatusCode(403);
            } else if ($exception instanceof HttpException) {
                switch ($exception->getStatusCode()) {
                    case 403:
                        return response()->view("errors/403")->setStatusCode(403);
                        break;
                    case 404:
                        return response()->view("errors/404")->setStatusCode(404);
                        break;
                    case 503:
                        return response()->view("errors/503")->setStatusCode(503);
                        break;
                    default:
                        return response()->view("errors/500")->setStatusCode(500);
                        break;
                }
            } else {
                //$exception instanceof ModelNotFoundException -> best to show 500 ISE
                return response()->view("errors/500")->setStatusCode(500);
            }
        }
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Illuminate\Auth\AuthenticationException $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthorized.'], 401);
        }

        return redirect()->guest('login');
    }
}
