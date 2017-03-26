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
		$extension_instance = LithiumExtension::where('id', $page->id)->first();
		$atom = Atom::where('id', $extension_instance->atom)->first();
		if($atom == null){
			return \View::make('errors.cms')->with(['error' => trans("Lithium::messages.err_atom_not_found"), 'help' => trans("Lithium::messages.err_atom_not_found_help")]);
		}else{
			return \View::make('Lithium::index')->with(['atom' => $atom, 'kernel' => $kernel, 'page' => $page, 'extension_instance' => $extension_instance, 'extensionCallback' => $this, 'base_slug' => $base_slug]);
		}
	}
}
