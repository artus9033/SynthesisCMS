<?php

namespace App\Http\Controllers\Content;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BackendRequest;
use App\Models\Auth\User;
use App\Models\Content\Page;
use App\Models\Content\Molecule;
use App\Models\Content\Atom;
use App\Toolbox;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;

class RouteController extends Controller
{
	public function checkRoute(BackendRequest $request){
		//TODO: Add possibility for each extension to check for the form if it's properly filled before saving
		$routes = \Route::getRoutes();
		$request2 = Request::create($request->get('route'));
		if($request->has('source')){
			if($request->get('source') == $request->get('route')){
				return array('text' => trans('synthesiscms/helper.route_free'), 'color' => 'green', 'valid' => true);
			}
		}
		try {
			$routes->match($request2);
			return array('text' => trans('synthesiscms/helper.route_occupied'), 'color' => 'red', 'valid' => false);
		}
		catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e){
			return array('text' => trans('synthesiscms/helper.route_free'), 'color' => 'green', 'valid' => true);
		}
	}

	public function manageRoutesGet()
	{
		return view('admin.manage_routes');
	}

	public function editRouteGet($id){
		$page = Page::find($id);
		return view('admin.edit_route', ['page' => $page]);
	}

	public function editRoutePost($id, BackendRequest $request)
	{
		$slug = $request->get('slug');
		$title = $request->get('title');
		$header = $request->get('header');
		$errors = array();
		$err = false;

		if(strlen($slug) == 0 || strlen(trim($slug)) == 0){
			$err = true;
			array_push($errors, trans("synthesiscms/admin.err_slug_cannot_be_empty"));
		}

		if(strlen($title) == 0 || strlen(trim($title)) == 0){
			$err = true;
			array_push($errors, trans("synthesiscms/admin.err_title_cannot_be_empty"));
		}

		if(strlen($header) == 0 || strlen(trim($header)) == 0){
			$err = true;
			array_push($errors, trans("synthesiscms/admin.err_header_cannot_be_empty"));
		}

		if(!$err){
			Toolbox::chkRoute($slug);
		}

		if($err){
			return \Redirect::to(\Request::path())->with('errors', $errors);
		}else{
			$page = Page::find($id);
			$page->slug = $slug;
			$page->page_title = $title;
			$page->page_header = $header;
			$page->save();

			$kpath = 'App\\Extensions\\'.$page->extension.'\\ExtensionKernel';
			$kernel = new $kpath;
			$kernel->editPost($page->id, $request);

			return \Redirect::route("manage_routes")->with('messages', array(trans('synthesiscms/admin.msg_route_saved', ['route' => $page->slug])));
		}
	}

	public function deleteRoute($id){
		$page = Page::find($id);
		$route = $page->slug;
		$page->delete();

		$kpath = 'App\\Extensions\\'.$page->extension.'\\ExtensionKernel';
		$kernel = new $kpath;
		$kernel->delete($page->id);

		return \Redirect::route('manage_routes')->with('messages', array(trans('synthesiscms/admin.msg_route_deleted', ['route' => $route])));
	}

	public function createRouteGet()
	{
		return view('admin.create_route');
	}

	public function createRoutePost(BackendRequest $request)
	{
		$route = $request->get('route');
		$extension = $request->get('extension');

		$errors = array();
		$err = false;

		if(strlen($route) == 0 || strlen(trim($route)) == 0){
			$err = true;
			array_push($errors, trans("synthesiscms/admin.err_slug_cannot_be_empty"));
		}

		if($err){
			return \Redirect::route('manage_routes_edit', ['id' => $page->id])->with('errors', $errors);
		}else{

			Toolbox::chkRoute($route);

			$page = Page::create(['slug' => $route, 'extension' => $extension]);

			$kpath = 'App\\Extensions\\'.$extension.'\\ExtensionKernel';
			$kernel = new $kpath;
			$kernel->create($page->id);

			return \Redirect::route('manage_routes_edit', ['id' => $page->id])->with(['messages', array(trans('synthesiscms/admin.msg_route_created', ['route' => $route])), 'toasts' => [trans('synthesiscms/admin.msg_now_edit_route')]]);
		}
	}
}
