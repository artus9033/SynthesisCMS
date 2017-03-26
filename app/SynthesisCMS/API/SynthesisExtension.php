<?php

namespace App\SynthesisCMS\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BackendRequest;

class SynthesisExtension extends Controller
{

	/** !!! Global Extension Functions Beginning !!! **/

	/**
	 * Function called after an atom is deleted by the user
	 * @param $id int id of the atom
	 * @return nothing
	 **/
	public function onAtomDeleted($id){}

	/**
	 * Function called after a molecule is deleted by the user
	 * @param $id int id of the molecule
	 * @return nothing
	 **/
	public function onMoleculeDeleted($id){}

	/**
	 * Function called after a route using this extension is deleted;
	 * There you can destroy any extension models saved earlier
	 * @param $id \App\Page->id (parent page id)
	 * @return nothing
	 **/
	public function onPageDeleted($id){}

	/**
	* Function called by create_route & edit_route views to get extension name; can be anything
	* @return String extension name
	**/
     public function getExtensionName(){}

	/**
	* Function called by create_route view to get extension type; can be either 'applet' or 'extension'
	* a extension can be included in a route while an applet can be only included as a whole-site extension_loaded
	* but it can be customized in it's settings in edit_applet
	* @return SynthesisExtensionType::const extension type
	**/
     public function getExtensionType(){}

	/**
	* Function used by extensionsServiceProvider to register app routes
	* @param $page \App\Page->id
	* @param $base_slug base url slug of the extension's page (route)
	* @return nothing
	**/
     public function routes($page, $base_slug){}

	/**
	* Function used to register hooks for positions
	* @return nothing
	**/
	public function hookPositions(&$manager){}

	/**
	* Function used to register middleware
	* @return boolean should execute next middleware
	**/
	public function registerMiddleware(){
		return true;
	}

	/** !!! Global Extension Functions End !!! **/

	/**  !!! Module-Only Extension Functions Beginning !!! **/

	/**
	* Function used by the route edit app view to render the fields
	* @param $page \App\Page->id
	* @return nothing
	**/
	public function editGet($page)
	{}

	/**
	* Function used by the route edit app view to commit edit
	* @param $id \App\Page->id
	* @param $request Form Request
	* @return nothing
	**/
	public function editPost($id, $request)
	{}

	/**
	* Function called when a route using this extension is created;
	* There you can set up a model containing a reference to the parent Page extension
	* via saving the 'id' param
	* @param $id \App\Page->id
	* @return nothing
	**/
	public function create($id){}

	/** !!! Module-Only Extension Functions End !!! **/

	/** !!! Applet-Only Extension Functions Beginning !!! **/

	/**
	* Function called when an applet's settings page is opened;
	* There you can add your applet's settings UI
	* @return nothing
	**/
	public function settingsGet(){}

	/**
	* Function called when an applet's settings are updated;
	* There you can add your applet's settings UI
	* @param $request Request the request
	* @param &$errors_array_ptr Pointer(Array) a pointer to the errors array
	* @return nothing
	**/
	public function settingsPost(BackendRequest $request, &$errors_array_ptr){}

	/** !!! Applet-Only Extension Functions End !!! **/

}
