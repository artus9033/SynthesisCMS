<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 26.03.2017
 * Time: 17:02
 */

namespace App\Extensions;


class ExtensionsCallbacksBridge
{
	/**
	 * Function that executes onAtomDeleted function on every extension that overrides this method
	 * @param $id int id of the atom deleted
	 */
	public static function handleOnAtomDeleted($id){
		// For each of the registered extensions, include their routes and Views
		$extensions = config("synthesiscmsextensions.extensions");

		while (list(,$extension) = each($extensions)) {
			$kpath = 'App\\Extensions\\'.$extension.'\\ExtensionKernel';
			$kernel = new $kpath;
			$kernel->onAtomDeleted($id);
		}
	}

	/**
	 * Function that executes onMoleculeDeleted function on every extension that overrides this method
	 * @param $id int id of the molecule deleted
	 */
	public static function handleOnMoleculeDeleted($id){
		// For each of the registered extensions, include their routes and Views
		$extensions = config("synthesiscmsextensions.extensions");

		while (list(,$extension) = each($extensions)) {
			$kpath = 'App\\Extensions\\'.$extension.'\\ExtensionKernel';
			$kernel = new $kpath;
			$kernel->onMoleculeDeleted($id);
		}
	}

	/**
	 * Function that executes onPageDeleted function on every extension that overrides this method
	 * @param $id int id of the page deleted
	 */
	public static function handleOnPageDeleted($id){
		// For each of the registered extensions, include their routes and Views
		$extensions = config("synthesiscmsextensions.extensions");

		while (list(,$extension) = each($extensions)) {
			$kpath = 'App\\Extensions\\'.$extension.'\\ExtensionKernel';
			$kernel = new $kpath;
			$kernel->onPageDeleted($id);
		}
	}
}