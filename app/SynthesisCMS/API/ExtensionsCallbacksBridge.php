<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 26.03.2017
 * Time: 17:02
 */

namespace App\SynthesisCMS\API;

class ExtensionsCallbacksBridge
{
	/**
	 * Function that executes onArticleDeleted function on every extension that overrides this method
	 * @param $id int id of the article deleted
	 */
	public static function handleOnArticleDeleted($id)
	{
		$extensions = \App\Models\Settings\Settings::getActiveInstance()->getInstalledExtensions();

		while (list(, $extension) = each($extensions)) {
			$kpath = 'App\\Extensions\\' . $extension . '\\ExtensionKernel';
			$kernel = new $kpath;
			$kernel->onArticleDeleted($id);
		}
	}

	/**
	 * Function that executes onArticleCategoryDeleted function on every extension that overrides this method
	 * @param $id int id of the articleCategory deleted
	 */
	public static function handleOnArticleCategoryDeleted($id)
	{
		$extensions = \App\Models\Settings\Settings::getActiveInstance()->getInstalledExtensions();

		while (list(, $extension) = each($extensions)) {
			$kpath = 'App\\Extensions\\' . $extension . '\\ExtensionKernel';
			$kernel = new $kpath;
			$kernel->onArticleCategoryDeleted($id);
		}
	}

	/**
 * Function that executes onRouteDeleted function on every extension that overrides this method
 * @param $id int id of the page deleted
 */
	public static function handleOnRouteDeleted($id)
	{
		$extensions = \App\Models\Settings\Settings::getActiveInstance()->getInstalledExtensions();

		while (list(, $extension) = each($extensions)) {
			$kpath = 'App\\Extensions\\' . $extension . '\\ExtensionKernel';
			$kernel = new $kpath;
			$kernel->onRouteDeleted($id);
		}
	}

	/**
 * Function that executes onRouteCreated function on every extension that overrides this method
 * @param $id int id of the page created
 */
	public static function handleOnRouteCreated($id)
	{
		$extensions = \App\Models\Settings\Settings::getActiveInstance()->getInstalledExtensions();

		while (list(, $extension) = each($extensions)) {
			$kpath = 'App\\Extensions\\' . $extension . '\\ExtensionKernel';
			$kernel = new $kpath;
			$kernel->onRouteCreated($id);
		}
	}

	/**
	 * Function that executes onRouteSaved function on every extension that overrides this method
	 * @param $id int id of the page saved
	 */
	public static function handleOnRouteSaved($id)
	{
		$extensions = \App\Models\Settings\Settings::getActiveInstance()->getInstalledExtensions();

		while (list(, $extension) = each($extensions)) {
			$kpath = 'App\\Extensions\\' . $extension . '\\ExtensionKernel';
			$kernel = new $kpath;
			$kernel->onRouteSaved($id);
		}
	}
}
