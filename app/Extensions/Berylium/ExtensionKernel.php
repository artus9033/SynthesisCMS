<?php

namespace App\Extensions\Berylium;

use App\Http\Controllers\Controller;
use App\Extensions\Berylium\Models\BeryliumExtension;
use App\Extensions\Berylium\Controllers\BeryliumController;
use App\SynthesisCMS\API\SynthesisExtension;
use App\SynthesisCMS\API\Positions\SynthesisPositions;
use App\SynthesisCMS\API\Positions\SynthesisPositionManager;
use App\SynthesisCMS\API\SynthesisExtensionType;

/**
 * ExtensionKernel
 *
 * Extension Kernel to control all the functionality directly
 * related to the Extension. This class is required, otherwise any routes
 * using this extension will throw an internal CMS error!
 */

class ExtensionKernel extends SynthesisExtension
{

	public function create($id){
		//$extension = BeryliumExtension::create(['id' => $id]);
	}

	public function delete($id){
		//$extension = BeryliumExtension::where(['id' => $id])->first();
		//$extension->delete();
	}

	public function getExtensionName(){
		return trans('berylium::berylium.name');
	}

	public function getExtensionType(){
		return SynthesisExtensionType::Applet;
	}

	public function editGet($page)
	{
		return \View::make('berylium::partials/edit')->with(['page' => $page]);
	}

	public function editPost($id, $request)
	{
		$extension = BeryliumExtension::where('id', $id)->first();
		$extension->atom = $request->get('berylium-atom');
		$extension->save();
	}

	public function showMenu($slug){
		return view('berylium::index')->with('slug', $slug);
	}

	public function showMenuMobileButton($slug){
		return view('berylium::mobile_button')->with('slug', $slug);
	}

	public function hookPositions(&$manager){
		$manager->addStandard(SynthesisPositions::BelowMenu, $this, 'showMenu');
		$manager->addStandard(SynthesisPositions::BeforeSiteName, $this, 'showMenuMobileButton');
	}
}
