<?php

namespace App\Modules\Hydrogen\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Hydrogen\Models\HydrogenModule;
use App\SynthesisCMS\API\SynthesisRouter;
use App\SynthesisCMS\API\RequestMethod;
use App\SynthesisCMS\API\ResponseMethod;
use App\Molecule;

class HydrogenController extends Controller
{
	public function index($page)
	{
		return \View::make('hydrogen::index')->with(['atoms' => Molecule::all(), 'page' => $page]);
	}
}
