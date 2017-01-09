<?php

namespace App\Modules\Lithium;

use App\Http\Controllers\Controller;
use App\Modules\Lithium\Models\TestModel;
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
	function __construct( TestModel $testModel )
	{
		$this->testModel = $testModel;
	}

	public function index($page, $slug_parent)
	{
		$router = new SynthesisRouter(\Request::instance(), $slug_parent, $this->getNamespaceName(), 'Lithium');
		$router->registerRoute(RequestMethod::GET, '/', ResponseMethod::VIEW, 'lithium::index');
		$router->registerRoute(RequestMethod::GET, '/controller', ResponseMethod::CONTROLLER, 'LithiumController');
		$router->react();
	}

	public function modelTest()
	{
		return $this->testModel->getAny();
	}
}
