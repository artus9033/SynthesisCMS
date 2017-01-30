<?php

namespace App\Modules\Lithium\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Lithium\Models\LithiumModule;
use App\SynthesisCMS\API\SynthesisModule;
use App\Models\Content\Molecule;
use App\Models\Content\Atom;

class LithiumController extends Controller
{
	public function index($page, $kernel, $base_slug)
	{
		return \View::make('lithium::index')->with(['atoms' => Atom::where('molecule', LithiumModule::where('id', $page->id)->first()->molecule)->get(), 'kernel' => $kernel, 'page' => $page, 'moduleCallback' => $this, 'base_slug' => $base_slug]);
	}

	public function atom($id, $kernel, $page, $base_slug){
		return \View::make('lithium::atom')->with(['atom' => Atom::where('id', $id)->first(), 'kernel' => $kernel, 'page' => $page, 'moduleCallback' => $this, 'base_slug' => $base_slug]);
	}
}
