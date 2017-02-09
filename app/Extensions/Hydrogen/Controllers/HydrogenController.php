<?php

namespace App\Extensions\Hydrogen\Controllers;

use App\Http\Controllers\Controller;
use App\Extensions\Hydrogen\Models\HydrogenExtension;
use App\SynthesisCMS\API\SynthesisExtension;
use App\Models\Content\Molecule;
use App\Models\Content\Atom;

class HydrogenController extends Controller
{
	public function index($currentPage, $page, $kernel, $base_slug)
	{
		$atomsKey = HydrogenExtension::where('id', $page->id)->first()->molecule;
		if($currentPage > Atom::where('molecule', $atomsKey)->count()){
			return \App::abort(404);
		}else{
			return \View::make('Hydrogen::index')->with(['currentPage' => $currentPage, 'atomsKey' => $atomsKey, 'kernel' => $kernel, 'page' => $page, 'extensionCallback' => $this, 'base_slug' => $base_slug]);
		}
	}

	public function atom($id, $kernel, $page, $base_slug){
		$atom = Atom::where('id', $id)->first();
		if($atom == null){
			return \View::make('errors.cms')->with(['error' => trans("Hydrogen::messages.err_atom_not_found"), 'help' => trans("Hydrogen::messages.err_atom_not_found_help")]);
		}else{
			return \View::make('Hydrogen::atom')->with(['atom' => $atom, 'kernel' => $kernel, 'page' => $page, 'extensionCallback' => $this, 'base_slug' => $base_slug]);
		}
	}
}
