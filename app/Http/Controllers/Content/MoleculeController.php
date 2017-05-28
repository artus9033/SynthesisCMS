<?php

namespace App\Http\Controllers\Content;

use App\Extensions\ExtensionsCallbacksBridge;
use App\Http\Controllers\Controller;
use App\Http\Requests\BackendRequest;
use App\Models\Content\Article;
use App\Models\Content\Molecule;
use App\Toolbox;

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
		return \Redirect::route('manage_molecules')->with('messages', array(trans('synthesiscms/admin.msg_molecule_saved', ['name' => Toolbox::string_truncate($molecule->title, 10)])));
	}

	public function deleteMolecule($id, $articles)
	{
		if($id == 1){
			return \Redirect::back()->with('errors', [trans('synthesiscms/admin.msg_route_cannot_be_deleted')]);
		}else{
			$molecule = Molecule::find($id);
			$name_orig = $molecule->title;
			$name_new = Toolbox::string_truncate($name_orig, 10);
			if ($articles == "true") {
				foreach (Article::where('molecule', $id)->cursor() as $article) {
					$article->delete();
				}
			}else{
				foreach (Article::where('molecule', $id)->cursor() as $article) {
					$article->molecule = 1; // move to the default molecule (ID 1)
					$article->save();
				}
			}
			$molecule->delete();
			ExtensionsCallbacksBridge::handleOnMoleculeDeleted($id);
			return \Redirect::route('manage_molecules')->with('messages', array(trans('synthesiscms/admin.msg_molecule_deleted', ['name' => $name_new])));
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
		return \Redirect::route('manage_molecules')->with('messages', array(trans('synthesiscms/admin.msg_molecule_created', ['name' => $title])));
	}

	public function massDeleteMolecule(BackendRequest $request){
		$moleculesCount = 0;
		$articlesCount = 0;
		$errors = Array();
		$csrf_token = true; // check if it's the csrf token hidden input
		$bool_delete_child_articles = false;
		var_dump($request->all());
		foreach ($request->all() as $key => $val) {
			if($csrf_token){
				$csrf_token = false;
			} else if (starts_with($key, "formMassDeleteChildArticlesCheckbox")) { // check if it's the delete child articles hidden checkbox
				$bool_delete_child_articles = true;
			}else if(starts_with($key, "molecule_checkbox")){
				$mID = intval(str_replace("molecule_checkbox", "", $key));
				if($mID != 1){
					if ($bool_delete_child_articles) {
						foreach (Article::where('molecule', $mID)->cursor() as $article) {
							$article->delete();
							$articlesCount++;
						}
					}else{
						foreach (Article::where('molecule', $mID)->cursor() as $article) {
							$article->molecule = 1; // move to the default molecule (ID 1)
							$article->save();
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
			if ($bool_delete_child_articles) {
				return \Redirect::route('manage_molecules')->with('errors', $errors)->with('messages', array(trans('synthesiscms/admin.msg_molecules_and_child_articles_deleted', ['moleculesCount' => $moleculesCount . ($moleculesCount == 1 ? trans('synthesiscms/helper.space_molecule') : trans('synthesiscms/helper.space_molecules')), 'articlesCount' => $articlesCount . ($articlesCount == 1 ? trans('synthesiscms/helper.space_article') : trans('synthesiscms/helper.space_articles'))])));
			}else{
				return \Redirect::route('manage_molecules')->with('errors', $errors)->with('messages', array(trans('synthesiscms/admin.msg_molecules_deleted', ['count' => $moleculesCount, 'beginning' => $moleculesCount == 1 ? trans('synthesiscms/helper.space_molecule_has') : trans('synthesiscms/helper.space_molecules_have')])));
			}
		}
	}

	public function massCopyMolecule(BackendRequest $request, $childrenArticlesToo)
	{
		$count = 0;
		$csrf_token = true; // check if it's the csrf token hidden input
		foreach ($request->all() as $key => $val) {
			if($csrf_token){
				$csrf_token = false;
			}else if(starts_with($key, "molecule_checkbox")){
				$origin = Molecule::find(intval(str_replace("molecule_checkbox", "", $key)));
				$newMolecule = Molecule::create(['title' => trans("synthesiscms/helper.molecule_copy_prefix") . $origin->title, 'description' => $origin->description, 'molecule' => $origin->molecule, 'image' => $origin->image]);
				if ($childrenArticlesToo == "true") {
					$originArticles = Article::where('molecule', $origin->id)->cursor();
					foreach ($originArticles as $key => $originArticle) {
						Article::create(['title' => $originArticle->title, 'description' => $originArticle->description, 'molecule' => $newMolecule->id, 'image' => $originArticle->image, 'hasImage' => $originArticle->hasImage]);
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
			return \Redirect::route('manage_molecules')->with('messages', array(trans('synthesiscms/admin.msg_molecules_copied', ['count' => $count, 'beginning' => $count == 1 ? trans('synthesiscms/helper.space_molecule_has') : trans('synthesiscms/helper.space_molecules_have')])));
		}
	}
}
