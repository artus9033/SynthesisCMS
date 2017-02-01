<?php

namespace App\Extensions\Lithium\Controllers;

use App\Http\Controllers\Controller;
use App\Extensions\Lithium\Models\LithiumExtension;
use App\SynthesisCMS\API\SynthesisExtension;
use App\Models\Content\Molecule;
use App\Models\Content\Atom;

class LithiumController extends Controller
{
	public function index($page, $kernel, $base_slug)
	{
		$atom = Atom::where('id', LithiumExtension::where('id', $page->id)->first()->atom)->first();
		if($atom == null){
			return \View::make('errors.cms')->with(['error' => trans("lithium::messages.err_atom_not_found"), 'help' => trans("lithium::messages.err_atom_not_found_help")]);
		}else{
			return \View::make('lithium::index')->with(['atom' => $atom, 'kernel' => $kernel, 'page' => $page, 'extensionCallback' => $this, 'base_slug' => $base_slug]);
		}
	}
}
