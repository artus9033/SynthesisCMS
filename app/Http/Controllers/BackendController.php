<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BackendRequest;
use App\User;
use App\Page;
use App\Molecule;
use App\Atom;
use App\Toolbox;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;

class BackendController extends Controller
{

	public function index()
	{
		if(Auth::check() && Auth::user()->is_admin){
			return view('admin.admin');
		}else{
			return view('auth.error');
		}
	}

	public function manageUsersGet()
	{
		return view('admin.manage_users');
	}

	public function manageUsersPost(BackendRequest $request)
	{
		$passwd = $request->get('newpassword');
		$passwd2 = $request->get('newpassword2');
		$passwd_old = $request->get('oldpassword');
		$errors = array();
		$err = false;

		if($passwd != $passwd2){
			$err = true;
			array_push($errors, trans('synthesiscms/auth.err_passwords_differ'));
		}

		if(!($passwd != "" && strlen($passwd) >= 6)){
			$err = true;
			array_push($errors, trans('synthesiscms/auth.err_password_too_short'));
		}

		if(\Hash::check($passwd_old, Auth::user()->getAuthPassword())){
			Auth::user()->password = \Hash::make($passwd);
		}else{
			$err = true;
			array_push($errors, trans('synthesiscms/auth.err_password_original_bad'));
		}

		if($err){
			return \Redirect::route('profile')->with('errors', $errors);
		}else{
			Auth::user()->save();
			return \Redirect::route('profile')->with('message', trans('synthesiscms/auth.msg_changed_passwd'));
		}
	}

	public function privileges($id){
		$uname = User::select('name')->where('id', $id)->first()['name'];
		$privs = User::select('is_admin')->where('id', $id)->first()['is_admin'] == true;
		return view('admin.change_user_privileges', ['priv' => $privs, 'uid' => $id, 'uname' => $uname]);
	}

	public function privileges_change($id, BackendRequest $request){
		if($id == Auth::user()->id){
			return view('admin.change_user_privileges')->with('errors', trans("admin.err_cant_edit_self_privileges"));
		}
		$is_admin_new = $request->input("is_admin") === 'true'? true : false;
		$usr = User::find($id);
		$usr->is_admin = $is_admin_new;
		$usr->save();
		return \Redirect::route('manage_users')->with('message', trans('synthesiscms/admin.msg_user_privileges_successfully_changed', ['name' => $usr->name]));
	}

	public function manageRoutesGet()
	{
		return view('admin.manage_routes');
	}

	public function editRouteGet($id){
		$page = Page::find($id);
		return view('admin.edit_route', ['page' => $page]);
	}

	public function editRoutePost($id, BackendRequest $request)
	{
		$slug = $request->get('slug');
		$title = $request->get('title');
		$header = $request->get('header');
		$errors = array();
		$err = false;

		if(strlen($slug) == 0 || strlen(trim($slug)) == 0){
			$err = true;
			array_push($errors, trans("synthesiscms/admin.err_slug_cannot_be_empty"));
		}

		if(strlen($title) == 0 || strlen(trim($title)) == 0){
			$err = true;
			array_push($errors, trans("synthesiscms/admin.err_title_cannot_be_empty"));
		}

		if(strlen($header) == 0 || strlen(trim($header)) == 0){
			$err = true;
			array_push($errors, trans("synthesiscms/admin.err_header_cannot_be_empty"));
		}

		if(!$err){
			Toolbox::chkRoute($slug);
		}

		if($err){
			return \Redirect::to(\Request::path())->with('errors', $errors);
		}else{
			$page = Page::find($id);
			$page->slug = $slug;
			$page->page_title = $title;
			$page->page_header = $header;
			$page->save();
			return \Redirect::route("manage_routes")->with('message', trans('synthesiscms/admin.msg_route_saved', ['route' => $page->slug]));
		}
	}

	public function deleteRoute($id){
		$page = Page::find($id);
		$route = $page->slug;
		$page->delete();
		return \Redirect::back()->with('message', trans('synthesiscms/admin.msg_route_deleted', ['route' => $route]));
	}

	public function createRouteGet()
	{
		return view('admin.create_route');
	}

	public function createRoutePost(BackendRequest $request)
	{
		$route = $request->get('route');
		$module = $request->get('module');
		$route = str_replace("\\", "/", $route);

		Toolbox::chkRoute($route);

		$page = Page::create(['slug' => $route, 'module' => $module]);

		$kpath = 'App\\Modules\\'.$module.'\\ModuleKernel';
		$kernel = new $kpath;
		$kernel->create($page->id);

		return \Redirect::route('manage_routes_edit', ['id' => $page->id])->with('message', trans('synthesiscms/admin.msg_route_created', ['route' => $route]));
	}

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
		echo $moleculesCount;
		if($moleculesCount == 0){
			array_push($errors, trans('synthesiscms/admin.err_no_molecules_selected'));
			return \Redirect::route('manage_molecules')->with('errors', $errors);
		}else{
			if($bool_delete_child_atoms){
				return \Redirect::route('manage_molecules')->with('errors', $errors)->with('message', trans('synthesiscms/admin.msg_molecules_and_child_atoms_deleted', ['moleculesCount' => $moleculesCount, 'atomsCount' => $atomsCount]));
			}else{
				return \Redirect::route('manage_molecules')->with('errors', $errors)->with('message', trans('synthesiscms/admin.msg_molecules_deleted', ['count' => $moleculesCount, 'beginning' => $moleculesCount == 1 ? "molecule has" : "molecules have"]));
			}
		}
	}

	public function massCopyMolecule(BackendRequest $request){
		$count = 0;
		$csrf_token = true; // check if it's the csrf token hidden input
		foreach ($request->all() as $key => $val) {
			if($csrf_token){
				$csrf_token = false;
			}else if(starts_with($key, "molecule_checkbox")){
				$origin = Molecule::find(intval(str_replace("molecule_checkbox", "", $key)));
				Molecule::create(['title' => trans("synthesiscms/helper.molecule_copy_prefix") . $origin->title, 'description' => $origin->description, 'molecule' => $origin->molecule, 'image' => $origin->image, 'imageSourceType' => $origin->imageSourceType]);
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

	public function createAtomGet()
	{
		return view('admin.create_atom');
	}

	public function createAtomPost(BackendRequest $request)
	{
		$title = $request->get('title');
		$desc = $request->get('description');
		$atom = Atom::create(['title' => $title, 'description' => $desc, 'molecule' => $request->get('molecule')]);
		$name_new = Toolbox::string_truncate($title, 10);
		return \Redirect::route('manage_atoms')->with('message', trans('synthesiscms/admin.msg_atom_created', ['name' => $title]));
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
		$atom = Atom::find($id);
		$atom->title = $request->get('title');
		$atom->description = $request->get('desc');
		$atom->molecule = $request->get('molecule');
		$atom->save();
		return \Redirect::route('manage_atoms')->with('message', trans('synthesiscms/admin.msg_atom_saved', ['name' => Toolbox::string_truncate($atom->title, 10)]));
	}

	public function deleteAtom($id){
		$atom = Atom::find($id);
		$name_orig = $atom->title;
		$name_new = Toolbox::string_truncate($name_orig, 10);
		$atom->delete();
		return \Redirect::route('manage_atoms')->with('message', trans('synthesiscms/admin.msg_atom_deleted', ['name' => $name_new]));
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
			return \Redirect::route('manage_atoms')->with('message', trans('synthesiscms/admin.msg_atoms_deleted', ['count' => $count, 'beginning' => $count == 1 ? "atom has" : "atoms have"]));
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
				Atom::create(['title' => trans("synthesiscms/helper.atom_copy_prefix") . $origin->title, 'description' => $origin->description, 'molecule' => $origin->molecule, 'image' => $origin->image, 'imageSourceType' => $origin->imageSourceType]);
				$count++;
			}
		}
		if($count == 0){
			$errors = Array();
			array_push($errors, trans('synthesiscms/admin.err_no_atoms_selected'));
			return \Redirect::route('manage_atoms')->with('errors', $errors);
		}else{
			return \Redirect::route('manage_atoms')->with('message', trans('synthesiscms/admin.msg_atoms_copied', ['count' => $count, 'beginning' => $count == 1 ? "atom has" : "atoms have"]));
		}
	}
}
