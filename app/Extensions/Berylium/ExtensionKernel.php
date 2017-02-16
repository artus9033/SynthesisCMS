<?php

namespace App\Extensions\Berylium;

use App\Http\Controllers\Controller;
use App\Extensions\Berylium\Models\BeryliumExtension;
use App\Extensions\Berylium\Models\BeryliumItem;
use App\Extensions\Berylium\Controllers\BeryliumController;
use App\Extensions\Berylium\BeryliumItemType;
use App\Extensions\Berylium\BeryliumItemCategory;
use App\SynthesisCMS\API\SynthesisExtension;
use App\SynthesisCMS\API\Positions\SynthesisPositions;
use App\SynthesisCMS\API\Positions\SynthesisPositionManager;
use App\SynthesisCMS\API\SynthesisExtensionType;
use App\Http\Requests\BackendRequest;

/**
* ExtensionKernel
*
* Extension Kernel to control all the functionality directly
* related to the Extension. This class is required, otherwise any routes
* using this extension will throw an internal CMS error!
*/

class ExtensionKernel extends SynthesisExtension
{
	public function settingsPositionUp(BackendRequest $request, $id){
		if(BeryliumItem::where(['menu' => $this->findOrCreate()->id, 'id' => $id])->count() == 0){
			return \Redirect::route("applet_settings", [ 'extension' => 'Berylium' ])->with('errors', array(trans('Berylium::messages.err_item_doesnt_exist')));
		}
		$has_children = false;
		$item = BeryliumItem::where(['menu' => $this->findOrCreate()->id, 'id' => $id])->first();
		$item_before_id = $item->before;
		$item_id = $item->id;
		if(BeryliumItem::where(['menu' => $this->findOrCreate()->id, 'id' => $item_before_id])->count() != 0){
			$before = BeryliumItem::where(['menu' => $this->findOrCreate()->id, 'id' => $item_before_id])->first();
			$before_id = $before->id;
			$before_before_id = $before->before;
		}else{
			return \Redirect::route("applet_settings", [ 'extension' => 'Berylium' ])->with('errors', array(trans('Berylium::messages.err_item_cannot_be_moved')));
		}
		if(BeryliumItem::where(['menu' => $this->findOrCreate()->id, 'before' => $item->id])->count() != 0){
			$has_children = true;
			$child_item = BeryliumItem::where(['menu' => $this->findOrCreate()->id, 'before' => $item->id])->first();
			$child_item->before = $before_id;
			$child_item->save();
		}
		$item->before = $before_before_id;
		$before->before = $item_id;
		$item->save();
		$before->save();
		return \Redirect::route("applet_settings", [ 'extension' => 'Berylium' ])->with('message', trans('Berylium::messages.msg_item_moved'));
	}

	public function settingsPositionDown(BackendRequest $request, $id){
		if(BeryliumItem::where(['menu' => $this->findOrCreate()->id, 'id' => $id])->count() == 0){
			return \Redirect::route("applet_settings", [ 'extension' => 'Berylium' ])->with('errors', array(trans('Berylium::messages.err_item_doesnt_exist')));
		}
		$has_children = false;
		$item = BeryliumItem::where(['menu' => $this->findOrCreate()->id, 'id' => $id])->first();
		$item_before_id = $item->before;
		$item_id = $item->id;
		if(BeryliumItem::where(['menu' => $this->findOrCreate()->id, 'id' => $item_before_id])->count() != 0){
			$before = BeryliumItem::where(['menu' => $this->findOrCreate()->id, 'id' => $item_before_id])->first();
			$before_id = $before->id;
			$before_before_id = $before->before;
		}else{
			return \Redirect::route("applet_settings", [ 'extension' => 'Berylium' ])->with('errors', array(trans('Berylium::messages.err_item_cannot_be_moved')));
		}
		if(BeryliumItem::where(['menu' => $this->findOrCreate()->id, 'before' => $item->id])->count() != 0){
			$has_children = true;
			$child_item = BeryliumItem::where(['menu' => $this->findOrCreate()->id, 'before' => $item->id])->first();
			$child_item->before = $before_id;
			$child_item->save();
		}
		$item->before = $before_before_id;
		$before->before = $item_id;
		$item->save();
		$before->save();
		return \Redirect::route("applet_settings", [ 'extension' => 'Berylium' ])->with('message', trans('Berylium::messages.msg_item_moved'));
	}

	public function settingsDeletePosition(BackendRequest $request, $id){
		$item = BeryliumItem::where(['menu' => $this->findOrCreate()->id, 'id' => $id]);
		$item->delete();
		return \Redirect::route("applet_settings", [ 'extension' => 'Berylium' ])->with('message', trans('Berylium::messages.msg_item_deleted'));
	}

	public function settingsCreatePositionPost(BackendRequest $request){
		$title = $request->get('title');
		$category = $request->get('category');
		$type = $request->get('type');
		$link = $request->get('link');
		$errors = array();
		$err = false;

		if(strlen($title) == 0 || strlen(trim($title)) == 0){
			$err = true;
			array_push($errors, trans("Berylium::messages.err_title_cannot_be_empty"));
		}

		if($err){
			return \Redirect::to(\Request::path())->with('errors', $errors);
		}else{
			if(BeryliumItem::where(['menu' => $this->findOrCreate()->id])->count()){
				$items_raw = BeryliumItem::where('menu', $this->findOrCreate()->id);
				$items_count = $items_raw->count();
				$posctr = 0;
				for($id = 0; $posctr < $items_count; $posctr++){
					$before = BeryliumItem::where(['menu' => $this->findOrCreate()->id, 'before' => $id])->first()->id;
					$id = $before;
				}
			}else{
				$before = 0;
			}
			BeryliumItem::create(['type' => $type, 'category' => $category, 'title' => $title, 'href' => $link, 'parent' => 0, 'before' => $before, 'menu' => $this->findOrCreate()->id]);
			return \Redirect::route("applet_settings", [ 'extension' => 'Berylium' ])->with('message', trans('Berylium::messages.msg_item_added'));
		}
	}

	public function settingsCreatePositionGet(){
		return view("Berylium::partials/create_item")->with(['model' => $this->findOrCreate(), 'kernel' => $this]);
	}

	public function settingsGet(){
		return view('Berylium::partials/settings')->with(['model' => $this->findOrCreate()]);
	}

	public function settingsPost(BackendRequest $request){
		$model = $this->findOrCreate();
		$model->enabled = $request->get('enabled') == "on";
		$model->save();
		$count = 0;
		foreach ($request->all() as $key => $val) {
			if(starts_with($key, "item_checkbox")){
				BeryliumItem::where(['menu' => $this->findOrCreate()->id, 'id' => intval(str_replace("item_checkbox", "", $key))])->delete();
				$count++;
			}
		}
		if($count == 0){
			$errors = Array();
			array_push($errors, trans('Berylium::messages.err_no_items_selected'));
			\Session::put('errors', $errors); //TODO: fix this not being shown
		}else{
			\Session::put('message', trans('Berylium::messages.msg_items_deleted')); //TODO: fix this not being shown
		}
	}

	public function getExtensionName(){
		return trans('Berylium::berylium.name');
	}

	public function getExtensionType(){
		return SynthesisExtensionType::Applet;
	}

	public function showMenu($slug){
		return view('Berylium::index')->with(['slug' => $slug, 'model' => $this->findOrCreate()]);
	}

	public function showMenuMobileButton($slug){
		return view('Berylium::mobile_button')->with('slug', $slug);
	}

	public function getMobileMenuItems($slug){
		$out = "";
		foreach(BeryliumItem::where('category', BeryliumItemCategory::Mobile)->cursor() as $item){
			switch($item->type){
				case BeryliumItemType::Atom:
				$out .= "<li><a href='" . $item->href . "'>" . $item->title . "</a></li>";
				break;

				case BeryliumItemType::Molecule:
				$out .= "<li><a href='" . $item->href . "'>" . $item->title . "</a></li>";
				break;

				case BeryliumItemType::Link:
				$out .= "<li><a href='" . $item->href . "'>" . $item->title . "</a></li>";
				break;

				case BeryliumItemType::Placeholder:
				$out .= "<li><span>" . $item->title . "</span></li>";
				break;
			}
		}
		return $out;
	}

	public function getDesktopMenuItems($slug){
		$out = "";
		foreach(BeryliumItem::where('category', BeryliumItemCategory::Desktop)->cursor() as $item){
			switch($item->type){
				case BeryliumItemType::Atom:
				$out .= "<li><a href='" . $item->href . "'>" . $item->title . "</a></li>";
				break;

				case BeryliumItemType::Molecule:
				$out .= "<li><a href='" . $item->href . "'>" . $item->title . "</a></li>";
				break;

				case BeryliumItemType::Link:
				$out .= "<li><a href='" . $item->href . "'>" . $item->title . "</a></li>";
				break;

				case BeryliumItemType::Placeholder:
				$out .= "<li><span>" . $item->title . "</span></li>";
				break;
			}
		}
		return $out;
	}

	public function getGeneralMenuItems($slug){
		$out = "";
		foreach(BeryliumItem::where('category', BeryliumItemCategory::General)->cursor() as $item){
			switch($item->type){
				case BeryliumItemType::Atom:
				$out .= "<li><a href='" . $item->href . "'>" . $item->title . "</a></li>";
				break;

				case BeryliumItemType::Molecule:
				$out .= "<li><a href='" . $item->href . "'>" . $item->title . "</a></li>";
				break;

				case BeryliumItemType::Link:
				$out .= "<li><a href='" . $item->href . "'>" . $item->title . "</a></li>";
				break;

				case BeryliumItemType::Placeholder:
				$out .= "<li><span>" . $item->title . "</span></li>";
				break;
			}
		}
		return $out;
	}

	public function hookPositions(&$manager){
		$manager->addStandard(SynthesisPositions::BelowMenu, $this, 'showMenu');
		$manager->addStandard(SynthesisPositions::BeforeSiteName, $this, 'showMenuMobileButton');
		$manager->addCustom('berylium', 'mobile-menu', $this, 'getMobileMenuItems');
		$manager->addCustom('berylium', 'desktop-menu', $this, 'getDesktopMenuItems');
		$manager->addCustom('berylium', 'menu', $this, 'getGeneralMenuItems');
	}

	public function findOrCreate(){
		$model = BeryliumExtension::find(1);
		if(!$model){
			$model = BeryliumExtension::create();
			return $this->findOrCreate();
		}else{
			return $model;
		}
	}
}
