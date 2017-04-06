<?php

namespace App\Http\Controllers\Content;

use App\Extensions\ExtensionsCallbacksBridge;
use App\Http\Controllers\Controller;
use App\Http\Requests\BackendRequest;
use App\Models\Content\Atom;
use App\Toolbox;

class AtomController extends Controller
{
	public function createAtomGet()
	{
		return view('admin.create_atom');
	}

	public function createAtomPost(BackendRequest $request)
	{
		if(!Toolbox::isEmptyString($request->get('title'))){
			$atom = Atom::create(
				['title' => $request->get('title'),
					'description' => $request->get('desc'),
					'molecule' => $request->get('molecule'),
					'hasImage' => ($request->get('hasImage') == 'on'),
					'image' => $request->get('image'),
				]
			);
			$name_new = Toolbox::string_truncate($atom->title, 10);
			return \Redirect::route('manage_atoms')->with('messages', array(trans('synthesiscms/admin.msg_atom_created', ['name' => $atom->title])));
		}else{
			return \Redirect::to(\Request::path())->with('errors', [trans('synthesiscms/atom.err_no_title')]);
		}
	}

	public function manageAtomsGet()
	{
		return view('admin.manage_atoms');
	}

	public function editAtomGet($id){
		$atom = Atom::find($id);
		return view('admin.edit_atom', ['atom' => $atom]);
	}

	public function editAtomPost($id, BackendRequest $request)
	{
		if(!Toolbox::isEmptyString($request->get('title'))){
			$atom = Atom::find($id);
			$atom->title = $request->get('title');
			$atom->description = $request->get('desc');
			$atom->molecule = $request->get('molecule');
			$atom->hasImage = ($request->get('hasImage') == 'on');
			$atom->image = $request->get('image');
			$atom->save();
			return \Redirect::route('manage_atoms')->with('messages', array(trans('synthesiscms/admin.msg_atom_saved', ['name' => Toolbox::string_truncate($atom->title, 10)])));
		}else{
			return \Redirect::to(\Request::path())->with('errors', [trans('synthesiscms/atom.err_no_title')]);
		}
	}

	public function deleteAtom($id){
		$atom = Atom::find($id);
		$name_orig = $atom->title;
		$name_new = Toolbox::string_truncate($name_orig, 10);
		$atom->delete();
		ExtensionsCallbacksBridge::handleOnAtomDeleted($id);
		return \Redirect::route('manage_atoms')->with('messages', array(trans('synthesiscms/admin.msg_atom_deleted', ['name' => $name_new])));
	}

	public function massDeleteAtom(BackendRequest $request){
		$count = 0;
		$csrf_token = true; // check if it's the csrf token hidden input
		foreach ($request->all() as $key => $val) {
			if($csrf_token){
				$csrf_token = false;
			}else if(starts_with($key, "atom_checkbox")){
				Atom::find(intval(str_replace("atom_checkbox", "", $key)))->delete();
				$count++;
			}
		}
		if($count == 0){
			$errors = Array();
			array_push($errors, trans('synthesiscms/admin.err_no_atoms_selected'));
			return \Redirect::route('manage_atoms')->with('errors', $errors);
		}else{
			return \Redirect::route('manage_atoms')->with('messages', array(trans('synthesiscms/admin.msg_atoms_deleted', ['count' => $count, 'beginning' => $count == 1 ? trans('synthesiscms/helper.atom_has') : trans('synthesiscms/helper.atoms_have')])));
		}
	}

	public function massCopyAtom(BackendRequest $request){
		$count = 0;
		$csrf_token = true; // check if it's the csrf token hidden input
		foreach ($request->all() as $key => $val) {
			if($csrf_token){
				$csrf_token = false;
			}else if(starts_with($key, "atom_checkbox")){
				$origin = Atom::find(intval(str_replace("atom_checkbox", "", $key)));
				Atom::create(['title' => trans("synthesiscms/helper.atom_copy_prefix") . $origin->title, 'description' => $origin->description, 'molecule' => $origin->molecule, 'image' => $origin->image, 'hasImage' => $origin->hasImage]);
				$count++;
			}
		}
		if($count == 0){
			$errors = Array();
			array_push($errors, trans('synthesiscms/admin.err_no_atoms_selected'));
			return \Redirect::route('manage_atoms')->with('errors', $errors);
		}else{
			return \Redirect::route('manage_atoms')->with('messages', array(trans('synthesiscms/admin.msg_atoms_copied', ['count' => $count, 'beginning' => $count == 1 ? trans('synthesiscms/helper.atom_has') : trans('synthesiscms/helper.atoms_have')])));
		}
	}

	public function massMoveAtom(BackendRequest $request, $moleculeId){
		$count = 0;
		$csrf_token = true; // check if it's the csrf token hidden input
		foreach ($request->all() as $key => $val) {
			if($csrf_token){
				$csrf_token = false;
			}else{
				$atom = Atom::find(intval(str_replace("atom_checkbox", "", $key)));
				$atom->molecule = $moleculeId;
				$atom->save();
				$count++;
			}
		}
		if($count == 0){
			$errors = Array();
			array_push($errors, trans('synthesiscms/admin.err_no_atoms_selected'));
			return \Redirect::route('manage_atoms')->with('errors', $errors);
		}else{
			return \Redirect::route('manage_atoms')->with('messages', array(trans('synthesiscms/admin.msg_atoms_moved', ['count' => $count, 'beginning' => $count == 1 ? trans('synthesiscms/helper.atom_has') : trans('synthesiscms/helper.atoms_have'), 'molecule' => $moleculeId])));
		}
	}
}
