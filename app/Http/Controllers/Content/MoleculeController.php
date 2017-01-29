<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BackendRequest;
use App\Models\Auth\User;
use App\Models\Content\Page;
use App\Models\Content\Molecule;
use App\Models\Content\Atom;
use App\Toolbox;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;

class MoleculeController extends Controller
{
	public function manageMoleculesGet()
	{
		return view('admin.manage_molecules');
	}

	public function editMoleculeGet($id){
		$molecule = Molecule::find($id);
		return view('admin.edit_molecule', ['molecule' => $molecule]);
	}

	public function editMoleculePost($id, BackendRequest $request)
	{
		$molecule = Molecule::find($id);
		$molecule->title = $request->get('title');
		$molecule->description = $request->get('desc');
		$molecule->save();
		return \Redirect::route('manage_molecules')->with('message', trans('synthesiscms/admin.msg_molecule_saved', ['name' => Toolbox::string_truncate($molecule->title, 10)]));
	}

	public function deleteMolecule($id, $atoms){
		if($id == 1){
			return \Redirect::back()->with('errors', [trans('synthesiscms/admin.msg_route_cannot_be_deleted')]);
		}else{
			$molecule = Molecule::find($id);
			$name_orig = $molecule->title;
			$name_new = Toolbox::string_truncate($name_orig, 10);
			if($atoms == "true"){
				foreach (Atom::where('molecule', $id)->cursor() as $atom) {
					$atom->delete();
				}
			}else{
				foreach (Atom::where('molecule', $id)->cursor() as $atom) {
					$atom->molecule = 1; // move to the default molecule (ID 1)
					$atom->save();
				}
			}
			$molecule->delete();
			return \Redirect::route('manage_molecules')->with('message', trans('synthesiscms/admin.msg_molecule_deleted', ['name' => $name_new]));
		}
	}

	public function createMoleculeGet()
	{
		return view('admin.create_molecule');
	}

	public function createMoleculePost(BackendRequest $request)
	{
		$title = $request->get('title');
		$desc = $request->get('description');
		$molecule = Molecule::create(['title' => $title, 'description' => $desc]);
		$name_new = Toolbox::string_truncate($title, 10);
		return \Redirect::route('manage_molecules')->with('message', trans('synthesiscms/admin.msg_molecule_created', ['name' => $title]));
	}

	public function massDeleteMolecule(BackendRequest $request){
		$moleculesCount = 0;
		$atomsCount = 0;
		$errors = Array();
		$csrf_token = true; // check if it's the csrf token hidden input
		$bool_delete_child_atoms = false;
		var_dump($request->all());
		foreach ($request->all() as $key => $val) {
			if($csrf_token){
				$csrf_token = false;
			}else if(starts_with($key, "formMassDeleteChildAtomsCheckbox")){ // check if it's the delete child atoms hidden checkbox
				$bool_delete_child_atoms = true;
			}else if(starts_with($key, "molecule_checkbox")){
				$mID = intval(str_replace("molecule_checkbox", "", $key));
				if($mID != 1){
					if($bool_delete_child_atoms){
						foreach (Atom::where('molecule', $mID)->cursor() as $atom) {
							$atom->delete();
							$atomsCount++;
						}
					}else{
						foreach (Atom::where('molecule', $mID)->cursor() as $atom) {
							$atom->molecule = 1; // move to the default molecule (ID 1)
							$atom->save();
						}
					}
					Molecule::find($mID)->delete();
					$moleculesCount++;
				}else{
					array_push($errors, trans('synthesiscms/admin.err_cannot_delete_default_molecule'));
				}
			}
		}
		if($moleculesCount == 0){
			array_push($errors, trans('synthesiscms/admin.err_no_molecules_selected'));
			return \Redirect::route('manage_molecules')->with('errors', $errors);
		}else{
			if($bool_delete_child_atoms){
				return \Redirect::route('manage_molecules')->with('errors', $errors)->with('message', trans('synthesiscms/admin.msg_molecules_and_child_atoms_deleted', ['moleculesCount' => $moleculesCount . ($moleculesCount == 1 ? " molecule" : " molecules"), 'atomsCount' => $atomsCount . ($atomsCount == 1 ? " atom" : "atoms")]));
			}else{
				return \Redirect::route('manage_molecules')->with('errors', $errors)->with('message', trans('synthesiscms/admin.msg_molecules_deleted', ['count' => $moleculesCount, 'beginning' => $moleculesCount == 1 ? " molecule has" : " molecules have"]));
			}
		}
	}

	public function massCopyMolecule(BackendRequest $request, $childrenAtomsToo){
		$count = 0;
		$csrf_token = true; // check if it's the csrf token hidden input
		foreach ($request->all() as $key => $val) {
			if($csrf_token){
				$csrf_token = false;
			}else if(starts_with($key, "molecule_checkbox")){
				$origin = Molecule::find(intval(str_replace("molecule_checkbox", "", $key)));
				$newMolecule = Molecule::create(['title' => trans("synthesiscms/helper.molecule_copy_prefix") . $origin->title, 'description' => $origin->description, 'molecule' => $origin->molecule, 'image' => $origin->image, 'imageSourceType' => $origin->imageSourceType]);
				if($childrenAtomsToo == "true"){
					$originAtoms = Atom::where('molecule', $origin->id)->cursor();
					foreach ($originAtoms as $key => $originAtom) {
						Atom::create(['title' => $originAtom->title, 'description' => $originAtom->description, 'molecule' => $newMolecule->id, 'image' => $originAtom->image, 'imageSourceType' => $originAtom->imageSourceType, 'hasImage' => $originAtom->hasImage]);
					}
				}
				$count++;
			}
		}
		if($count == 0){
			$errors = Array();
			array_push($errors, trans('synthesiscms/admin.err_no_molecules_selected'));
			return \Redirect::route('manage_molecules')->with('errors', $errors);
		}else{
			return \Redirect::route('manage_molecules')->with('message', trans('synthesiscms/admin.msg_molecules_copied', ['count' => $count, 'beginning' => $count == 1 ? "molecule has" : "molecules have"]));
		}
	}
}
