<?php

namespace App\Extensions\Lithium\Controllers;

use App\Extensions\Lithium\Models\LithiumExtension;
use App\Http\Controllers\Controller;
use App\Models\Content\Article;

class LithiumController extends Controller
{
	public function index($page, $kernel, $base_slug)
	{
		$extension_instance = LithiumExtension::where('id', $page->id)->first();
		$article = Article::where('id', $extension_instance->article)->first();
		if ($article == null) {
			return \View::make('errors.cms')->with(['error' => trans("Lithium::messages.err_article_not_found"), 'help' => trans("Lithium::messages.err_article_not_found_help")]);
		} else {
			return \View::make('Lithium::index')->with(['article' => $article, 'kernel' => $kernel, 'page' => $page, 'extension_instance' => $extension_instance, 'extensionCallback' => $this, 'base_slug' => $base_slug]);
		}
	}
}
