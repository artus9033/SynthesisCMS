<?php

namespace App\Http\Controllers\Content;

use App\Extensions\ExtensionsCallbacksBridge;
use App\Http\Controllers\Controller;
use App\Http\Requests\BackendRequest;
use App\Models\Content\Article;
use App\Toolbox;

class ArticleController extends Controller
{
	public function createArticleGet()
	{
		return view('admin.create_article');
	}

	public function createArticlePost(BackendRequest $request)
	{
		if (!Toolbox::isEmptyString($request->get('title'))) {
			$article = Article::create(
				['title' => $request->get('title'),
					'description' => $request->get('desc'),
					'articleCategory' => $request->get('articleCategory'),
					'hasImage' => ($request->get('hasImage') == 'on'),
					'image' => $request->get('image'),
					'cardSize' => Article::getCardSizeFromNumber(intval($request->get('cardSize')))
				]
			);
			$name_new = Toolbox::string_truncate($article->title, 10);
			return \Redirect::route('manage_articles')->with('messages', array(trans('synthesiscms/admin.msg_article_created', ['name' => $name_new])));
		} else {
			return \Redirect::to(\Request::path())->with('errors', [trans('synthesiscms/article.err_no_title')]);
		}
	}

	public function manageArticlesGet()
	{
		return view('admin.manage_articles');
	}

	public function editArticleGet($id)
	{
		$article = Article::find($id);
		return view('admin.edit_article', ['article' => $article]);
	}

	public function editArticlePost($id, BackendRequest $request)
	{
		if (!Toolbox::isEmptyString($request->get('title'))) {
			$article = Article::find($id);
			$article->title = $request->get('title');
			$article->description = $request->get('desc');
			$article->articleCategory = $request->get('articleCategory');
			$article->hasImage = ($request->get('hasImage') == 'on');
			$article->cardSize = Article::getCardSizeFromNumber(intval($request->get('cardSize')));
			$article->image = $request->get('image');
			$article->save();
			return \Redirect::route('manage_articles')->with('messages', array(trans('synthesiscms/admin.msg_article_saved', ['name' => Toolbox::string_truncate($article->title, 10)])));
		} else {
			return \Redirect::to(\Request::path())->with('errors', [trans('synthesiscms/article.err_no_title')]);
		}
	}

	public function deleteArticle($id)
	{
		$article = Article::find($id);
		$name_orig = $article->title;
		$name_new = Toolbox::string_truncate($name_orig, 10);
		$article->delete();
		ExtensionsCallbacksBridge::handleOnArticleDeleted($id);
		return \Redirect::route('manage_articles')->with('messages', array(trans('synthesiscms/admin.msg_article_deleted', ['name' => $name_new])));
	}

	public function massDeleteArticle(BackendRequest $request)
	{
		$count = 0;
		$csrf_token = true; // check if it's the csrf token hidden input
		foreach ($request->all() as $key => $val) {
			if ($csrf_token) {
				$csrf_token = false;
			} else if (starts_with($key, "article_checkbox")) {
				Article::find(intval(str_replace("article_checkbox", "", $key)))->delete();
				$count++;
			}
		}
		if ($count == 0) {
			$errors = Array();
			array_push($errors, trans('synthesiscms/admin.err_no_articles_selected'));
			return \Redirect::route('manage_articles')->with('errors', $errors);
		} else {
			return \Redirect::route('manage_articles')->with('messages', array(trans('synthesiscms/admin.msg_articles_deleted', ['count' => $count, 'beginning' => $count == 1 ? trans('synthesiscms/helper.article_has') : trans('synthesiscms/helper.articles_have')])));
		}
	}

	public function massCopyArticle(BackendRequest $request)
	{
		$count = 0;
		$csrf_token = true; // check if it's the csrf token hidden input
		foreach ($request->all() as $key => $val) {
			if ($csrf_token) {
				$csrf_token = false;
			} else if (starts_with($key, "article_checkbox")) {
				$origin = Article::find(intval(str_replace("article_checkbox", "", $key)));
				Article::create(['title' => trans("synthesiscms/helper.article_copy_prefix") . $origin->title, 'description' => $origin->description, 'articleCategory' => $origin->articleCategory, 'image' => $origin->image, 'hasImage' => $origin->hasImage]);
				$count++;
			}
		}
		if ($count == 0) {
			$errors = Array();
			array_push($errors, trans('synthesiscms/admin.err_no_articles_selected'));
			return \Redirect::route('manage_articles')->with('errors', $errors);
		} else {
			return \Redirect::route('manage_articles')->with('messages', array(trans('synthesiscms/admin.msg_articles_copied', ['count' => $count, 'beginning' => $count == 1 ? trans('synthesiscms/helper.article_has') : trans('synthesiscms/helper.articles_have')])));
		}
	}

	public function massMoveArticle(BackendRequest $request, $articleCategoryId)
	{
		$count = 0;
		$csrf_token = true; // check if it's the csrf token hidden input
		foreach ($request->all() as $key => $val) {
			if ($csrf_token) {
				$csrf_token = false;
			} else {
				$article = Article::find(intval(str_replace("article_checkbox", "", $key)));
				$article->articleCategory = $articleCategoryId;
				$article->save();
				$count++;
			}
		}
		if ($count == 0) {
			$errors = Array();
			array_push($errors, trans('synthesiscms/admin.err_no_articles_selected'));
			return \Redirect::route('manage_articles')->with('errors', $errors);
		} else {
			return \Redirect::route('manage_articles')->with('messages', array(trans('synthesiscms/admin.msg_articles_moved', ['count' => $count, 'beginning' => $count == 1 ? trans('synthesiscms/helper.article_has') : trans('synthesiscms/helper.articles_have'), 'articleCategory' => $articleCategoryId])));
		}
	}
}
