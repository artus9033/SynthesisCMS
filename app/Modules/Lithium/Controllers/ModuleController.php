<?php

namespace App\Modules\Lithium\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Lithium\Models\TestModel;
use App\SynthesisCMS\API\SynthesisRouter;
use App\SynthesisCMS\API\RequestMethod;

/**
 * ModuleController
 *
 * Controller to house all the functionality directly
 * related to the Lithium Forms.
 */

class ModuleController extends Controller
{
	function __construct( TestModel $testModel )
	{
		$this->testModel = $testModel;
	}

	public function index($page, $slug)
	{
		$router = new SynthesisRouter(\Request::instance(), $slug, 'Lithium');
		$router->registerRoute(RequestMethod::GET, '/b');
		$router->react();
	}

	public function modelTest()
	{
		return $this->testModel->getAny();
	}
}
