<?php

namespace App\Http\Middleware\Content;

use App\SynthesisCMS\API\Constants;
use Closure;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SynthesisHtmlDynamicUrlHandlerMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$response = $next($request);
		if(get_class($response) !== BinaryFileResponse::class) {
			$content = $response->getContent();

			$regex = '`' . Constants::synthesiscmsUrlMiddlewareHandlerStartTag . '(.*?)' . Constants::synthesiscmsUrlMiddlewareHandlerEndTag . '`';
			$content = preg_replace_callback($regex,
				function ($matches) {
					return url($matches[1]);
				}, $content);

			$response->setContent($content);
		}

		return $response;
	}
}