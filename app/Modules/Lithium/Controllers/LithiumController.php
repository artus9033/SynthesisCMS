<?php

namespace App\Modules\Lithium\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Lithium\Models\TestModel;
use App\SynthesisCMS\API\SynthesisRouter;
use App\SynthesisCMS\API\RequestMethod;
use App\SynthesisCMS\API\ResponseMethod;

class LithiumController extends Controller
{
	function __construct(TestModel $testModel)
	{
		$this->testModel = $testModel;
	}

	public function modelTest()
	{
		return $this->testModel->getAll();
	}
}
