<?php

namespace App\SynthesisCMS\API\Extensions;

use App\Http\Controllers\Controller;

class SynthesisExtension extends Controller
{

	/** !!! Global Extension Functions Beginning !!! **/

	/**
	 * Function called after an article is deleted by the user
	 * @param $id int id of the article
	 **/
	public function onArticleDeleted($id)
	{
	}

	/**
	 * Function called after an articleCategory is deleted by the user
	 * @param $id int id of the articleCategory
	 **/
	public function onArticleCategoryDeleted($id)
	{
	}

	/**
	 * Function called after a route is created
	 * @param $id int parent page id
	 **/
	public function onRouteCreated($id)
	{
	}

	/**
	 * Function called after a route is deleted
	 * @param $id int parent page id
	 **/
	public function onRouteDeleted($id)
	{
	}

	/**
	 * Function called after a route is saved after being edited by the user
	 * @param $id int parent page id
	 **/
	public function onRouteSaved($id)
	{
	}

	/**
	 * Function called by create_route & edit_route views to get extension name; can be anything
	 * @return String extension name
	 **/
	public function getExtensionName()
	{
		return "The extension author has forgotten to implement this ;-)";
	}

	/**
	 * Function called by create_route view to get extension type; can be either 'applet' or 'extension'
	 * a extension can be included in a route while an applet can be only included as a whole-site extension_loaded
	 * but it can be customized in it's settings in edit_applet
	 * @return int extension type
	 **/
	public function getExtensionType()
	{
		return SynthesisExtensionType::Applet;
	}

	/**
	 * Function used by extensionsServiceProvider to register app routes
	 * @param $page \App\Models\Content\Page->id
	 * @param $base_slug string base url slug of the extension's page (route)
	 **/
	public function routes($page, $base_slug)
	{
	}

	/**
	 * Function used to register hooks for positions
	 **/
	public function hookPositions(&$manager)
	{
	}

	/**
	 * Function used to register middleware
	 * @return boolean should execute next middleware
	 **/
	public function registerMiddleware()
	{
		return true;
	}

	/** !!! Global Extension Functions End !!! **/

	/**  !!! Module-Only Extension Functions Beginning !!! **/

	/**
	 * Function used for retrieving all user-exposed routes
	 * @return array(Array($pageTitle, $pageId, $extensionName))
	 * $pageTitle String page title
	 * $pageId int page id
	 * $extensionName String extension name
	 **/
	public function getRoutesAndSubroutes()
	{
		return Array(Array());
	}

	/**
	 * Function used by the route edit app view to render the fields
	 * @param $page \App\Models\Content\Page->id
	 **/
	public function editGet($page)
	{
	}

	/**
	 * Function used by the route edit app view to commit edit
	 * @param $id \App\Models\Content\Page->id
	 * @param $request \Illuminate\Http\Request
	 * TODO: fix the error with incompatible request types somehow
	public function editPost($id, \Request $request)
	{
	}
	 *
	 */

	/**
	 * Function called when a route using this extension is created;
	 * There you can set up a model containing a reference to the parent Page extension
	 * via saving the 'id' param
	 * @param $id \App\Models\Content\Page->id
	 **/
	public function create($id)
	{
	}

	/** !!! Module-Only Extension Functions End !!! **/

	/** !!! Applet-Only Extension Functions Beginning !!! **/

	/**
	 * Function called when an applet's settings page is opened;
	 * There you can add your applet's settings UI
	 **/
	public function settingsGet()
	{
	}

	/**
	 * Function called when an applet's settings are updated;
	 * There you can add your applet's settings UI
	 * @param $request \Request the request
	 * @param &$errors_array_ptr array& a pointer to the errors array
	 * TODO: fix the error with incompatible request types somehow
	public function settingsPost(\Request $request, &$errors_array_ptr)
	{
	}
	 *
	 **/

	/** !!! Applet-Only Extension Functions End !!! **/

}
