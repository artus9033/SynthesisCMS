<?php

namespace App\Http\Controllers\Content;

use App\Extensions\ExtensionsCallbacksBridge;
use App\Http\Controllers\Controller;
use App\Http\Requests\BackendRequest;
use App\Models\Content\Article;
use App\Models\Content\ArticleCategory;
use App\Toolbox;

class ArticleCategoryController extends Controller
{
	public function manageArticleCategoriesGet()
	{
		return view('admin.manage_article_categories');
	}

	public function editArticleCategoryGet($id)
	{
		$articleCategory = ArticleCategory::find($id);
		return view('admin.edit_article_category', ['articleCategory' => $articleCategory]);
	}

	public function editArticleCategoryPost($id, BackendRequest $request)
	{
		$articleCategory = ArticleCategory::find($id);
		$articleCategory->title = $request->get('title');
		$articleCategory->description = $request->get('desc');
		$articleCategory->save();
		return \Redirect::route('manage_article_categories')->with('messages', array(trans('synthesiscms/admin.msg_article_category_saved', ['name' => Toolbox::string_truncate($articleCategory->title, 10)])));
	}

	public function deleteArticleCategory($id, $articles)
	{
		if ($id == 1) {
			return \Redirect::back()->with('errors', [trans('synthesiscms/admin.msg_route_cannot_be_deleted')]);
		} else {
			$articleCategory = ArticleCategory::find($id);
			$name_orig = $articleCategory->title;
			$name_new = Toolbox::string_truncate($name_orig, 10);
			if ($articles == "true") {
				foreach (Article::where('articleCategory', $id)->cursor() as $article) {
					$article->delete();
				}
			} else {
				foreach (Article::where('articleCategory', $id)->cursor() as $article) {
					$article->articleCategory = 1; // move to the default articleCategory (ID 1)
					$article->save();
				}
			}
			$articleCategory->delete();
			ExtensionsCallbacksBridge::handleOnArticleCategoryDeleted($id);
			return \Redirect::route('manage_article_categories')->with('messages', array(trans('synthesiscms/admin.msg_article_category_deleted', ['name' => $name_new])));
		}
	}

	public function createArticleCategoryGet()
	{
		return view('admin.create_article_category');
	}

	public function createArticleCategoryPost(BackendRequest $request)
	{
		$title = $request->get('title');
		$desc = $request->get('description');
		$articleCategory = ArticleCategory::create(['title' => $title, 'description' => $desc]);
		$name_new = Toolbox::string_truncate($title, 10);
		return \Redirect::route('manage_article_categories')->with('messages', array(trans('synthesiscms/admin.msg_article_category_created', ['name' => $title])));
	}

	public function massDeleteArticleCategory(BackendRequest $request)
	{
		$articleCategoriesCount = 0;
		$articlesCount = 0;
		$errors = Array();
		$csrf_token = true; // check if it's the csrf token hidden input
		$bool_delete_child_articles = false;
		var_dump($request->all());
		foreach ($request->all() as $key => $val) {
			if ($csrf_token) {
				$csrf_token = false;
			} else if (starts_with($key, "formMassDeleteChildArticlesCheckbox")) { // check if it's the delete child articles hidden checkbox
				$bool_delete_child_articles = true;
			} else if (starts_with($key, "articleCategory_checkbox")) {
				$mID = intval(str_replace("articleCategory_checkbox", "", $key));
				if ($mID != 1) {
					if ($bool_delete_child_articles) {
						foreach (Article::where('articleCategory', $mID)->cursor() as $article) {
							$article->delete();
							$articlesCount++;
						}
					} else {
						foreach (Article::where('articleCategory', $mID)->cursor() as $article) {
							$article->articleCategory = 1; // move to the default articleCategory (ID 1)
							$article->save();
						}
					}
					ArticleCategory::find($mID)->delete();
					$articleCategoriesCount++;
				} else {
					array_push($errors, trans('synthesiscms/admin.err_cannot_delete_default_article_category'));
				}
			}
		}
		if ($articleCategoriesCount == 0) {
			array_push($errors, trans('synthesiscms/admin.err_no_article_categories_selected'));
			return \Redirect::route('manage_article_categories')->with('errors', $errors);
		} else {
			if ($bool_delete_child_articles) {
				return \Redirect::route('manage_article_categories')->with('errors', $errors)->with('messages', array(trans('synthesiscms/admin.msg_article_categories_and_child_articles_deleted', ['articleCategoriesCount' => $articleCategoriesCount . ($articleCategoriesCount == 1 ? trans('synthesiscms/helper.space_article_category') : trans('synthesiscms/helper.space_article_categories')), 'articlesCount' => $articlesCount . ($articlesCount == 1 ? trans('synthesiscms/helper.space_article') : trans('synthesiscms/helper.space_articles'))])));
			} else {
				return \Redirect::route('manage_article_categories')->with('errors', $errors)->with('messages', array(trans('synthesiscms/admin.msg_article_categories_deleted', ['count' => $articleCategoriesCount, 'beginning' => $articleCategoriesCount == 1 ? trans('synthesiscms/helper.space_article_category_has') : trans('synthesiscms/helper.space_article_categories_have')])));
			}
		}
	}

	public function massCopyArticleCategory(BackendRequest $request, $childrenArticlesToo)
	{
		$count = 0;
		$csrf_token = true; // check if it's the csrf token hidden input
		foreach ($request->all() as $key => $val) {
			if ($csrf_token) {
				$csrf_token = false;
			} else if (starts_with($key, "articleCategory_checkbox")) {
				$origin = ArticleCategory::find(intval(str_replace("articleCategory_checkbox", "", $key)));
				$newArticleCategory = ArticleCategory::create(['title' => trans("synthesiscms/helper.articleCategory_copy_prefix") . $origin->title, 'description' => $origin->description, 'articleCategory' => $origin->articleCategory, 'image' => $origin->image]);
				if ($childrenArticlesToo == "true") {
					$originArticles = Article::where('articleCategory', $origin->id)->cursor();
					foreach ($originArticles as $key => $originArticle) {
						Article::create(['title' => $originArticle->title, 'description' => $originArticle->description, 'articleCategory' => $newArticleCategory->id, 'image' => $originArticle->image, 'hasImage' => $originArticle->hasImage]);
					}
				}
				$count++;
			}
		}
		if ($count == 0) {
			$errors = Array();
			array_push($errors, trans('synthesiscms/admin.err_no_article_categories_selected'));
			return \Redirect::route('manage_article_categories')->with('errors', $errors);
		} else {
			return \Redirect::route('manage_article_categories')->with('messages', array(trans('synthesiscms/admin.msg_article_categories_copied', ['count' => $count, 'beginning' => $count == 1 ? trans('synthesiscms/helper.space_article_category_has') : trans('synthesiscms/helper.space_article_categories_have')])));
		}
	}
}
