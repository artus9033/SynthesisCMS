<?php

namespace App\Modules\Berylium;

use App\Http\Controllers\Controller;
use App\Modules\Berylium\Models\BeryliumModule;
use App\Modules\Berylium\Controllers\BeryliumController;
use App\SynthesisCMS\API\SynthesisModule;
use App\SynthesisCMS\API\Positions\SynthesisPositions;
use App\SynthesisCMS\API\Positions\SynthesisPositionManager;

/**
 * ModuleKernel
 *
 * Module Kernel to control all the functionality directly
 * related to the Module. This class is required, otherwise any routes
 * using this module will throw an internal CMS error!
 */

class ModuleKernel extends SynthesisModule
{

	public function create($id){
		//$module = LithiumModule::create(['id' => $id]);
	}

	public function delete($id){
		//$module = LithiumModule::where(['id' => $id])->first();
		//$module->delete();
	}

	public function getModuleName(){
		return trans('berylium::berylium.name');
	}

	public function editGet($page)
	{
		return \View::make('berylium::partials/edit')->with(['page' => $page]);
	}

	public function editPost($id, $request)
	{
		$module = LithiumModule::where('id', $id)->first();
		$module->atom = $request->get('berylium-atom');
		$module->save();
	}

	public function showMenu($slug){
		return view('berylium::index');
	}

	public function hookPositions(&$manager){
		$manager->addStandard(SynthesisPositions::BelowMenu, $this, 'showMenu');
	}
}
