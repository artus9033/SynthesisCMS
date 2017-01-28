<?php

namespace App\SynthesisCMS\API;

use App\Http\Controllers\Controller;

class SynthesisModule extends Controller
{

	/**
	* Function called when a route using this module is created;
	* There you can set up a model containing a reference to the parent Page module
	* via saving the 'id' param
	* @param $id App\Page->id
	* @return nothing
	**/
	public function create($id){}

	/**
	* Function called when a route using this module is deleted;
	* There you can destroy any module models saved earlier
	* @param $id App\Page->id (parent page id)
	* @return nothing
	**/
	public function delete($id){}

	/**
	* Function used by the route edit app view to render the fields
	* @param $page App\Page->id
	* @return nothing
	**/
     public function editGet($page)
     {}

     /**
	* Function used by the route edit app view to commit edit
	* @param $id App\Page->id
	* @param $request Form Request
	* @return nothing
	**/
     public function editPost($id, $request)
     {}

	/**
	* Function called by create_route & edit_route views to get module name; can be anything
	* @return String
	**/
     public function getModuleName(){}

	/**
	* Function used by ModuelesServiceProvider to register app routes
	* @param $page App\Page->id
	* @param $base_slug base url slug of the module's page (route)
	* @return nothing
	**/
     public function routes($page, $base_slug){}
}
