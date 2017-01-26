<?php

namespace App\Modules\Hydrogen\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Hydrogen\Models\HydrogenModule;
use App\SynthesisCMS\API\SynthesisRouter;
use App\SynthesisCMS\API\RequestMethod;
use App\SynthesisCMS\API\ResponseMethod;
use App\Molecule;
use App\Atom;

class HydrogenController extends Controller
{
	public function index($page, $kernel)
	{
		return \View::make('hydrogen::index')->with(['atoms' => Atom::where('molecule', HydrogenModule::where('id', $page->id)->first()->molecule)->cursor(), 'kernel' => $kernel, 'page' => $page, 'moduleCallback' => $this]);
	}

	public function atom($id, $kernel, $page){
		return \View::make('hydrogen::atom')->with(['atom' => Atom::where('id', $id)->first(), 'kernel' => $kernel, 'page' => $page, 'moduleCallback' => $this]);
	}
}
