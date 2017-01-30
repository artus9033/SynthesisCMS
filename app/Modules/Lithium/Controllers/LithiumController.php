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
		$atom = Atom::where('id', LithiumModule::where('id', $page->id)->first()->atom)->first();
		if($atom == null){
			return \View::make('errors.cms')->with(['error' => trans("lithium::messages.err_atom_not_found"), 'help' => trans("lithium::messages.err_atom_not_found_help")]);
		}else{
			return \View::make('lithium::index')->with(['atom' => $atom, 'kernel' => $kernel, 'page' => $page, 'moduleCallback' => $this, 'base_slug' => $base_slug]);
		}
	}
}
