<?php

namespace App\Modules\Hydrogen;

use App\Http\Controllers\Controller;
use App\Modules\Hydrogen\Models\HydrogenModule;
use App\SynthesisCMS\API\SynthesisRouter;
use App\SynthesisCMS\API\RequestMethod;
use App\SynthesisCMS\API\ResponseMethod;

/**
 * ModuleKernel
 *
 * Module Kernel to control all the functionality directly
 * related to the Module. This class is required, otherwise any routes
 * using this module will throw an internal CMS error!
 */

class ModuleKernel extends Controller
{

	public function create($id){
		$module = HydrogenModule::create(['molecule' => $id]);
		echo($id);
	}

	public function index($page, $slug_parent)
	{
		$router = new SynthesisRouter(\Request::instance(), $slug_parent, $this, 'Hydrogen');
		$router->registerRoute(RequestMethod::GET, '/', ResponseMethod::CONTROLLER, 'Controllers\HydrogenController@index', ['page' => $page]);
		$router->react();
	}

	public function edit($page)
	{
		return \View::make('hydrogen::partials/edit')->with(['page' => $page]);
	}
}
