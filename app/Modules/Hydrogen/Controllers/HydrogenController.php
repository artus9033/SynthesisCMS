<?php

namespace App\Modules\Hydrogen\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Hydrogen\Models\HydrogenModule;
use App\SynthesisCMS\API\SynthesisModule;
use App\Models\Content\Molecule;
use App\Models\Content\Atom;

class HydrogenController extends Controller
{
	public function index($page, $kernel, $base_slug)
	{
		return \View::make('hydrogen::index')->with(['atoms' => Atom::where('molecule', HydrogenModule::where('id', $page->id)->first()->molecule)->get(), 'kernel' => $kernel, 'page' => $page, 'moduleCallback' => $this, 'base_slug' => $base_slug]);
	}

	public function atom($id, $kernel, $page, $base_slug){
		$atom = Atom::where('id', $id)->first();
		if($atom == null){
			return \View::make('errors.cms')->with(['error' => trans("hydrogen::messages.err_atom_not_found"), 'help' => trans("hydrogen::messages.err_atom_not_found_help")]);
		}else{
			return \View::make('hydrogen::atom')->with(['atom' => $atom, 'kernel' => $kernel, 'page' => $page, 'moduleCallback' => $this, 'base_slug' => $base_slug]);
		}
	}
}
