<?php

namespace App\Http\Controllers\Content;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContentEditorRequest;
use App\Http\Requests\ContentManagerRequest;
use App\Models\Content\Article;
use App\Models\Content\Tag;
use App\SynthesisCMS\API\ExtensionsCallbacksBridge;
use App\Toolbox;

class ArticleController extends Controller
{

    public function createArticleGet(ContentEditorRequest $request)
    {
        return view('admin.create_article');
    }

    public function createArticlePost(ContentEditorRequest $request)
    {
        if (!Toolbox::isEmptyString($request->get('title'))) {
            $uid = \Auth::id();
            if (is_null($uid)) {
                $uid = 1;
            }
            $article = Article::create(
                [
                    'title' => $request->get('title'),
                    'description' => $request->get('desc'),
                    'articleCategory' => $request->get('articleCategory'),
                    'hasImage' => ($request->get('hasImage') == 'on'),
                    'image' => $request->get('image'),
                    'cardSize' => Article::getCardSizeFromNumber(intval($request->get('cardSize'))),
                    'publishedBy' => $uid,
                ]
            );
            $articleTagsRawBase64 = $request->get('articleTags');
            $tagsDetached = false;
            if (strlen($articleTagsRawBase64)) {
                foreach (explode(";", $articleTagsRawBase64) as $val) {
                    $val = base64_decode($val);
                    if (strlen($val)) {
                        if (!$tagsDetached) {
                            $article->tags()->detach();
                            $tagsDetached = true;
                        }
                        $tag = Tag::firstOrCreate(['name' => $val]);
                        $article->tags()->attach($tag->id);
                    }
                }
            }
            $name_new = Toolbox::string_truncate($article->title, 15);
            return \Redirect::route('manage_articles')->with('messages', array(trans('synthesiscms/admin.msg_article_created', ['name' => $name_new])));
        } else {
            return \Redirect::to(\Request::path())->with('errors', [trans('synthesiscms/article.err_no_title')]);
        }
    }

    public function manageArticlesGet(ContentEditorRequest $request)
    {
        return view('admin.manage_articles');
    }

    public function editArticleGet($id, ContentEditorRequest $request)
    {
        if (!Article::where(['id' => $id])->exists()) {
            return \Redirect::route('manage_articles')->with('errors', [trans('synthesiscms/article.err_article_does_not_exist')]);
        }
        $article = Article::find($id);
        return view('admin.edit_article', ['article' => $article]);
    }

    public function editArticlePost($id, ContentEditorRequest $request)
    {
        if (!Article::where(['id' => $id])->exists()) {
            return \Redirect::route('manage_articles')->with('errors', [trans('synthesiscms/article.err_article_does_not_exist')]);
        }
        if (!Toolbox::isEmptyString($request->get('title'))) {
            $article = Article::find($id);
            $article->title = $request->get('title');
            $article->description = $request->get('desc');
            $article->articleCategory = $request->get('articleCategory');
            $article->hasImage = ($request->get('hasImage') == 'on');
            $article->cardSize = Article::getCardSizeFromNumber(intval($request->get('cardSize')));
            $article->image = $request->get('image');
            $articleTagsRawBase64 = $request->get('articleTags');
            $tagsDetached = false;
            if (strlen($articleTagsRawBase64)) {
                foreach (explode(";", $articleTagsRawBase64) as $val) {
                    $val = base64_decode($val);
                    if (strlen($val)) {
                        if (!$tagsDetached) {
                            $article->tags()->detach();
                            $tagsDetached = true;
                        }
                        $tag = Tag::firstOrCreate(['name' => $val]);
                        $article->tags()->attach($tag->id);
                    }
                }
            }
            $article->save();
            return \Redirect::route('manage_articles')->with('messages', array(trans('synthesiscms/admin.msg_article_saved', ['name' => Toolbox::string_truncate($article->title, 15)])));
        } else {
            return \Redirect::to(\Request::path())->with('errors', [trans('synthesiscms/article.err_no_title')]);
        }
    }

    public function deleteArticle($id, ContentManagerRequest $request)
    {
        if (!Article::where(['id' => $id])->exists()) {
            return \Redirect::route('manage_articles')->with('errors', [trans('synthesiscms/article.err_article_does_not_exist')]);
        }
        $article = Article::find($id);
        $name_orig = $article->title;
        $name_new = Toolbox::string_truncate($name_orig, 15);
        $article->delete();
        ExtensionsCallbacksBridge::handleOnArticleDeleted($id);
        return \Redirect::route('manage_articles')->with('messages', array(trans('synthesiscms/admin.msg_article_deleted', ['name' => $name_new])));
    }

    public function massDeleteArticle(ContentEditorRequest $request)
    {
        $count = 0;
        $csrf_token = true; // check if it's the csrf token hidden input
        foreach ($request->all() as $key => $val) {
            if ($csrf_token) {
                $csrf_token = false;
            } else if (Str::startsWith($key, "article_checkbox")) {
                if (Article::where(['id' => intval(str_replace("article_checkbox", "", $key))])->exists()) {
                    Article::find(intval(str_replace("article_checkbox", "", $key)))->delete();
                    $count++;
                }
            }
        }
        if ($count == 0) {
            $errors = array();
            array_push($errors, trans('synthesiscms/admin.err_no_articles_selected'));
            return \Redirect::route('manage_articles')->with('errors', $errors);
        } else {
            return \Redirect::route('manage_articles')->with('messages', array(trans('synthesiscms/admin.msg_articles_deleted', ['count' => $count, 'beginning' => $count == 1 ? trans('synthesiscms/helper.article_has') : trans('synthesiscms/helper.articles_have')])));
        }
    }

    public function massCopyArticle(ContentEditorRequest $request)
    {
        $count = 0;
        $csrf_token = true; // check if it's the csrf token hidden input
        foreach ($request->all() as $key => $val) {
            if ($csrf_token) {
                $csrf_token = false;
            } else if (Str::startsWith($key, "article_checkbox")) {
                if (Article::where(['id' => intval(str_replace("article_checkbox", "", $key))])->exists()) {
                    $origin = Article::find(intval(str_replace("article_checkbox", "", $key)));
                    $clone = $origin->replicate();
                    $clone->title = trans("synthesiscms/helper.article_copy_prefix") . $clone->title;
                    $clone->push();
                    $count++;
                }
            }
        }
        if ($count == 0) {
            $errors = array();
            array_push($errors, trans('synthesiscms/admin.err_no_articles_selected'));
            return \Redirect::route('manage_articles')->with('errors', $errors);
        } else {
            return \Redirect::route('manage_articles')->with('messages', array(trans('synthesiscms/admin.msg_articles_copied', ['count' => $count, 'beginning' => $count == 1 ? trans('synthesiscms/helper.article_has') : trans('synthesiscms/helper.articles_have')])));
        }
    }

    public function massMoveArticle(ContentEditorRequest $request, $articleCategoryId)
    {
        $count = 0;
        $csrf_token = true; // check if it's the csrf token hidden input
        foreach ($request->all() as $key => $val) {
            if ($csrf_token) {
                $csrf_token = false;
            } else {
                if (Article::where(['id' => intval(str_replace("article_checkbox", "", $key))])->exists()) {
                    $article = Article::find(intval(str_replace("article_checkbox", "", $key)));
                    $article->articleCategory = $articleCategoryId;
                    $article->save();
                    $count++;
                }
            }
        }
        if ($count == 0) {
            $errors = array();
            array_push($errors, trans('synthesiscms/admin.err_no_articles_selected'));
            return \Redirect::route('manage_articles')->with('errors', $errors);
        } else {
            return \Redirect::route('manage_articles')->with('messages', array(trans('synthesiscms/admin.msg_articles_moved', ['count' => $count, 'beginning' => $count == 1 ? trans('synthesiscms/helper.article_has') : trans('synthesiscms/helper.articles_have'), 'articleCategory' => $articleCategoryId])));
        }
    }
}
