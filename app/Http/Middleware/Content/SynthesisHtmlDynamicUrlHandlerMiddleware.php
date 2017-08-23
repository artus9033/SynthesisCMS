<?php

namespace App\Http\Middleware\Content;

use App\SynthesisCMS\API\Constants;
use Closure;

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

		$content = $response->getContent();

		$regex = '`' . Constants::synthesiscmsUrlMiddlewareHandlerStartTag . '(.*?)' . Constants::synthesiscmsUrlMiddlewareHandlerEndTag . '`';
		$content = preg_replace_callback($regex,
			function ($matches) {
				return url($matches[1]);
			}, $content);

		$response->setContent($content);

		return $response;
	}
}