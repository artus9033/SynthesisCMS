<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContentEditorRequest;
use App\Http\Requests\ContentManagerRequest;
use App\Models\Content\Page;
use App\SynthesisCMS\API\ExtensionsCallbacksBridge;
use App\Toolbox;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function checkRoute(ContentEditorRequest $request)
    {
        $routePath = trim($request->get('route'));

        if ($request->has('source')) {
            if ($request->get('source') == $routePath) {
                return array('text' => trans('synthesiscms/helper.route_free'), 'color' => 'green', 'valid' => true);
            }
        }

        if ($this->_checkIfRouteOccupied($routePath)) {
            return array('text' => trans('synthesiscms/helper.route_occupied'), 'color' => 'red', 'valid' => false);
        } else {
            return array('text' => trans('synthesiscms/helper.route_free'), 'color' => 'green', 'valid' => true);
        }
    }

    private function _checkIfRouteOccupied($routePath)
    {
        try {
            $routes = \Route::getRoutes();
            $request = Request::create($routePath);

            $routes->match($request);

            return true;
        } catch (\Exception $e) {
            if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                return false;
            } else {
                return true;
            }
        }
    }

    public function manageRoutesGet(ContentManagerRequest $request)
    {
        return view('admin.manage_routes');
    }

    public function editRouteGet($id, ContentManagerRequest $request)
    {
        if (!Page::where(['id' => $id])->exists()) {
            return \Redirect::route('manage_routes')->with('errors', [trans('synthesiscms/page.err_route_does_not_exist')]);
        }
        $page = Page::find($id);
        return view('admin.edit_route', ['page' => $page]);
    }

    public function editRoutePost($id, ContentManagerRequest $request)
    {
        if (!Page::where(['id' => $id])->exists()) {
            return \Redirect::route('manage_routes')->with('errors', [trans('synthesiscms/page.err_route_does_not_exist')]);
        }
        $slug = $request->get('slug');
        $title = $request->get('title');
        $header = $request->get('header');
        $errors = array();
        $err = false;

        if (strlen($slug) == 0 || strlen(trim($slug)) == 0) {
            $err = true;
            array_push($errors, trans("synthesiscms/admin.err_slug_cannot_be_empty"));
        }

        if (strlen($title) == 0 || strlen(trim($title)) == 0) {
            $err = true;
            array_push($errors, trans("synthesiscms/admin.err_title_cannot_be_empty"));
        }

        if (strlen($header) == 0 || strlen(trim($header)) == 0) {
            $err = true;
            array_push($errors, trans("synthesiscms/admin.err_header_cannot_be_empty"));
        }

        if (!$err) {
            $page = Page::find($id);

            Toolbox::chkRoute($slug);

            if ($slug != $page->slug && $this->_checkIfRouteOccupied($slug)) {
                $err = true;
                array_push($errors, trans("synthesiscms/admin.err_route_already_occupied"));
            }
        }

        if ($err) {
            return \Redirect::to(\Request::path())->with('errors', $errors);
        } else {
            $page->slug = $slug;
            $page->page_title = $title;
            $page->page_header = $header;
            $page->save();

            $kpath = 'App\\Extensions\\' . $page->extension . '\\ExtensionKernel';
            $kernel = new $kpath;
            $kernel->editPost($page->id, $request);

            ExtensionsCallbacksBridge::handleOnRouteSaved($page->id);

            return \Redirect::route("manage_routes")->with('messages', array(trans('synthesiscms/admin.msg_route_saved', ['route' => $page->name])));
        }
    }

    public function deleteRoute($id, ContentManagerRequest $request)
    {
        if (!Page::where(['id' => $id])->exists()) {
            return \Redirect::route('manage_routes')->with('errors', [trans('synthesiscms/page.err_route_does_not_exist')]);
        }
        $page = Page::find($id);
        $route = $page->slug;
        $page->delete();

        ExtensionsCallbacksBridge::handleOnRouteDeleted($page->id);

        return \Redirect::route('manage_routes')->with('messages', array(trans('synthesiscms/admin.msg_route_deleted', ['route' => $route])));
    }

    public function createRouteGet(ContentManagerRequest $request)
    {
        return view('admin.create_route');
    }

    public function createRoutePost(ContentManagerRequest $request)
    {
        $route = trim($request->get('route'));
        $extension = $request->get('extension');

        $errors = array();
        $err = false;

        if (strlen($route) == 0 || strlen(trim($route)) == 0) {
            $err = true;
            array_push($errors, trans("synthesiscms/admin.err_slug_cannot_be_empty"));
        }

        if (!$err) {
            Toolbox::chkRoute($route);

            if ($this->_checkIfRouteOccupied($route)) {
                $err = true;
                array_push($errors, trans("synthesiscms/admin.err_route_already_occupied"));
            }
        }

        if ($err) {
            return \Redirect::route('manage_routes')->with('errors', $errors);
        } else {
            $page = Page::create(['slug' => $route, 'extension' => $extension, 'page_title' => 'SynthesisCMS Sample Title', 'page_header' => 'SynthesisCMS Sample Page Header: Lorem ipsum sit dolor amet...']);

            $kpath = 'App\\Extensions\\' . $extension . '\\ExtensionKernel';
            $kernel = new $kpath;
            $kernel->create($page->id);

            ExtensionsCallbacksBridge::handleOnRouteCreated($page->id);

            return \Redirect::route('manage_routes_edit', ['id' => $page->id])->with(['messages', array(trans('synthesiscms/admin.msg_route_created', ['route' => $route])), 'toasts' => [trans('synthesiscms/admin.msg_now_edit_route')]]);
        }
    }
}
