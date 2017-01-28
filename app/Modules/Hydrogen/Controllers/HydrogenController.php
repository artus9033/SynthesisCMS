<?php

namespace App\Modules\Hydrogen\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Hydrogen\Models\HydrogenModule;
use App\SynthesisCMS\API\SynthesisModule;
use App\Molecule;
use App\Atom;

class HydrogenController extends Controller
{
	public function index($page, $kernel, $base_slug)
	{
		return \View::make('hydrogen::index')->with(['atoms' => Atom::where('molecule', HydrogenModule::where('id', $page->id)->first()->molecule)->cursor(), 'kernel' => $kernel, 'page' => $page, 'moduleCallback' => $this, 'base_slug' => $base_slug]);
	}

	public function atom($id, $kernel, $page, $base_slug){
		return \View::make('hydrogen::atom')->with(['atom' => Atom::where('id', $id)->first(), 'kernel' => $kernel, 'page' => $page, 'moduleCallback' => $this, 'base_slug' => $base_slug]);
	}
}
