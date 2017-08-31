<?php

namespace App\Extensions\Hydrogen\Controllers;

use App\Extensions\Hydrogen\Models\HydrogenExtension;
use App\Http\Controllers\Controller;
use App\Models\Content\Article;

class HydrogenController extends Controller
{
	public function index($currentPage, $page, $kernel, $base_slug)
	{
		$articlesKey = HydrogenExtension::where('id', $page->id)->first()->articleCategory;
		if ($currentPage > Article::where('articleCategory', $articlesKey)->count() && Article::where('articleCategory', $articlesKey)->count()) {
			abort(404);
		} else {
			$extension_instance = \App\Extensions\Hydrogen\Models\HydrogenExtension::find($page->id);
			return \View::make('Hydrogen::index')->with(['currentPage' => $currentPage, 'articlesKey' => $articlesKey, 'kernel' => $kernel, 'page' => $page, 'extensionCallback' => $this, 'base_slug' => $base_slug, 'extension_instance' => $extension_instance]);
		}
	}

	public function article($id, $kernel, $page, $base_slug)
	{
		$article = Article::where('id', $id)->first();
		if ($article == null) {
			return \View::make('errors.cms')->with(['error' => trans("Hydrogen::messages.err_article_not_found"), 'help' => trans("Hydrogen::messages.err_article_not_found_help")]);
		} else {
			$extension_instance = \App\Extensions\Hydrogen\Models\HydrogenExtension::find($page->id);
			return \View::make('Hydrogen::article')->with(['article' => $article, 'kernel' => $kernel, 'page' => $page, 'extensionCallback' => $this, 'base_slug' => $base_slug, 'extension_instance' => $extension_instance]);
		}
	}
}
