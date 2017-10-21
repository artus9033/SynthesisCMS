<?php

namespace App\Exceptions;

use App\Models\Settings\Settings;
use App\Models\Settings\StaticActiveSettingsInterface;
use App\Models\Stats\ExceptionTracker;
use App\Toolbox;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		\Illuminate\Auth\AuthenticationException::class,
		\Illuminate\Auth\Access\AuthorizationException::class,
		\Symfony\Component\HttpKernel\Exception\HttpException::class,
		\Illuminate\Database\Eloquent\ModelNotFoundException::class,
		\Illuminate\Session\TokenMismatchException::class,
		\Illuminate\Validation\ValidationException::class,
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
		if(!Toolbox::isRunningInConsole()) {
			parent::report($exception);
			if(!$exception instanceof NotFoundHttpException) {
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
					ExceptionTracker::saveException($exception->getCode(), str_replace($fullPath, "[cms_root]", $exception->getFile()), str_replace($fullPath, "[cms_root]", $exception->getMessage()), str_replace($fullPath, "[cms_root]", $exception->getTraceAsString()), $fullPath);
				}
			}
		}else{
			$handle = fopen(storage_path("logs/laravel-console.log"), "w+");
			fputs($handle, $exception->getTraceAsString());
			fclose($handle);
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
		\App::setLocale(strtolower(Toolbox::getBrowserLocale()));
		if (Settings::getActiveInstance()->isDevModeEnabled()) {
			return parent::render($request, $exception);
		} else {
			if ($this->isHttpException($exception)) {
				$exception = $this->prepareException($exception); // convert ModelNotFoundException & AuthorizationException to HttpException
			}
			$code = $exception->getCode();
			if ($code === 0) {
				$code = 500;
			}
			switch ($code) {
				case 404:
					return response()->view("errors/404")->setStatusCode(404);
					break;
				case 503:
					return response()->view("errors/503")->setStatusCode(503);
					break;
				case 403:
					return response()->view("errors/403")->setStatusCode(503);
					break;
				default:
					return response()->view("errors/500")->setStatusCode(500);
					break;
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