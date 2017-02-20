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
use App\Models\Settings\Settings;
use App\Models\Content\Atom;
use App\Models\Content\Molecule;

/**
* ExtensionKernel
*
* Extension Kernel to control all the functionality directly
* related to the Extension. This class is required, otherwise any routes
* using this extension will throw an internal CMS error!
*/

class ExtensionKernel extends SynthesisExtension
{
	//TODO: IMPLEMENT EDITING AND CREATING WITH DIFFERENT SOURCES (BOTH FORMS & QUERIES TO EDIT!!!)
	public function settingsPositionUp(BackendRequest $request, $id){
		if(BeryliumItem::where(['id' => $id])->count() == 0){
			if(BeryliumItem::where(['id' => BeryliumItem::where(['id' => $id])->first()->before])->count() == 0){
				return \Redirect::route("applet_settings", [ 'extension' => 'Berylium' ])->with('errors', array(trans('Berylium::messages.err_item_doesnt_exist')));
			}
		}
		$item = BeryliumItem::where(['menu' => BeryliumItem::where(['id' => $id])->first()->menu, 'id' => $id])->first();
		$menu = $item->menu;
		$item_before_id = $item->before;
		if(BeryliumItem::where(['menu' => $menu, 'id' => $item_before_id])->count() != 0){
			$before = BeryliumItem::where(['menu' => $menu, 'id' => $item_before_id])->first();
			$before_id = $before->id;
			$before_before_id = $before->before;
		}else{
			return \Redirect::route("applet_settings", [ 'extension' => 'Berylium' ])->with('errors', array(trans('Berylium::messages.err_item_cannot_be_moved')));
		}
		if(BeryliumItem::where(['menu' => $menu, 'before' => $item->id])->count() != 0){
			$child_item = BeryliumItem::where(['menu' => $menu, 'before' => $item->id])->first();
			$child_item->before = $before_id;
			$child_item->save();
		}
		$item->before = $before_before_id;
		$before->before = $id;
		$item->save();
		$before->save();
		return \Redirect::route("applet_settings", [ 'extension' => 'Berylium' ])->with('messages', array(trans('Berylium::messages.msg_item_moved')));
	}

	public function settingsPositionDown(BackendRequest $request, $id){
		if(BeryliumItem::where(['menu' => $this->findOrCreate()->id, 'id' => $id])->count() == 0){
			if(BeryliumItem::where(['menu' => $this->findOrCreate()->id, 'before' => $id])->count() == 0){
				return \Redirect::route("applet_settings", [ 'extension' => 'Berylium' ])->with('errors', array(trans('Berylium::messages.err_item_doesnt_exist')));
			}
		}
		$item = BeryliumItem::where(['menu' => $this->findOrCreate()->id, 'id' => $id])->first();
		if(BeryliumItem::where(['menu' => $this->findOrCreate()->id, 'id' => $item->before])->count() != 0){
			$before = BeryliumItem::where(['menu' => $this->findOrCreate()->id, 'id' => $item->before])->first();
			$before_id = $before->id;
		}else{
			$before_id = 0;
		}
		if(BeryliumItem::where(['menu' => $this->findOrCreate()->id, 'before' => $id])->count() != 0){
			$child_item = BeryliumItem::where(['menu' => $this->findOrCreate()->id, 'before' => $id])->first();
			$child_item->before = $before_id;
			$child_item->save();
			$child_item_id = $child_item->id;
			if(BeryliumItem::where(['menu' => $this->findOrCreate()->id, 'before' => $child_item_id])->count() != 0){
				$child_item2 = BeryliumItem::where(['menu' => $this->findOrCreate()->id, 'before' => $child_item_id])->first();
				$child_item2->before = $id;
				$child_item2->save();
			}
		}else{
			return \Redirect::route("applet_settings", [ 'extension' => 'Berylium' ])->with('errors', array(trans('Berylium::messages.err_item_cannot_be_moved')));
		}
		$item->before = $child_item_id;
		$item->save();
		return \Redirect::route("applet_settings", [ 'extension' => 'Berylium' ])->with('messages', array(trans('Berylium::messages.msg_item_moved')));
	}

	public function settingsDeletePosition(BackendRequest $request, $id){
		$item = BeryliumItem::where(['id' => $id])->first();
		$after_query = BeryliumItem::where(['menu' => $item->menu, 'before' => $item->id]);
		if($after_query->count()){
			$after = $after_query->first();
			$after->before = $item->before;
			$after->save();
		}
		$menu = $item->parentOf;
		$children = BeryliumItem::where(['menu' => $menu, 'before' => $id])->get();
		foreach($children as $child){
			$child->delete();
		}
		$item->delete();
		return \Redirect::route("applet_settings", [ 'extension' => 'Berylium' ])->with('messages', array(trans('Berylium::messages.msg_item_deleted')));
	}

	public function settingsEditPositionPost(BackendRequest $request, $id){
		$title = $request->get('title');
		$category = $request->get('category');
		$type = $request->get('type');
		switch($type){
			case 1:
			$data = $request->get('link');
			break;
			case 2:
			$data = $request->get('atom');
			break;
			case 3:
			$data = $request->get('molecule');
			break;
			case 4:
			$data = "";
			break;
		}
		$errors = array();
		$err = false;

		$query = BeryliumItem::where(['id' => $id]);

		if($query->count() == 0){
			return \Redirect::route("applet_settings", [ 'extension' => 'Berylium' ])->with('errors', array(trans('Berylium::messages.err_item_doesnt_exist')));
		}

		if(strlen($title) == 0 || strlen(trim($title)) == 0){
			$err = true;
			array_push($errors, trans("Berylium::messages.err_title_cannot_be_empty"));
		}

		if($err){
			return \Redirect::to(\Request::path())->with('errors', $errors);
		}else{
			$item = $query->first();
			$item->title = $title;
			$item->category = $category;
			$item->type = $type;
			$item->data = $data;
			$item->save();
			return \Redirect::route("applet_settings", [ 'extension' => 'Berylium' ])->with('messages', array(trans('Berylium::messages.msg_item_saved')));
		}
	}

	public function settingsEditPositionGet($id){
		$query = BeryliumItem::where(['id' => $id]);
		if($query->count() == 0){
			return \Redirect::route("applet_settings", [ 'extension' => 'Berylium' ])->with('errors', array(trans('Berylium::messages.err_item_doesnt_exist')));
		}else{
			return view("Berylium::partials/edit_item")->with(['model' => $this->findOrCreate(), 'kernel' => $this, 'item' => $query->first()]);
		}
	}

	public function settingsCreatePositionPost(BackendRequest $request){
		$title = $request->get('title');
		$category = $request->get('category');
		$type = $request->get('type');
		switch($type){
			case 1:
			$data = $request->get('link');
			break;
			case 2:
			$data = $request->get('page');
			break;
			case 3:
			$data = "";
			break;
		}
		$menu_and_id = $request->get('parent');
		list($menu, $parent_id) = explode(";", $menu_and_id);
		$errors = array();
		$err = false;

		if(strlen($title) == 0 || strlen(trim($title)) == 0){
			$err = true;
			array_push($errors, trans("Berylium::messages.err_title_cannot_be_empty"));
		}

		if($err){
			return \Redirect::to(\Request::path())->with('errors', $errors);
		}else{
			if(BeryliumItem::where(['menu' => $menu, 'before' => $parent_id])->count()){
				$items_raw = BeryliumItem::where('menu', $menu);
				$items_count = $items_raw->count();
				$posctr = 0;
				for( $id = $parent_id; $posctr < $items_count; $posctr++){
					$before = BeryliumItem::where(['menu' => $menu, 'before' => $id])->first()->id;
					$id = $before;
				}
			}else{
				$before = $parent_id;
			}
			$created = BeryliumItem::create(['type' => $type, 'category' => $category, 'title' => $title, 'data' => $data, 'before' => $before, 'menu' => $menu]);
			$created->parentOf = $created->id + 1;
			$created->save();
			return \Redirect::route("applet_settings", [ 'extension' => 'Berylium' ])->with('messages', array(trans('Berylium::messages.msg_item_added')));
		}
	}

	public function settingsCreatePositionGet(){
		return view("Berylium::partials/create_item")->with(['model' => $this->findOrCreate(), 'kernel' => $this]);
	}

	public function settingsGet(){
		return view('Berylium::partials/settings')->with(['model' => $this->findOrCreate()]);
	}

	public function settingsPost(BackendRequest $request, &$errors_array_ptr){
		$model = $this->findOrCreate();
		$model->enabled = $request->get('enabled') == "on";
		$model->save();
		$count = 0;
		foreach ($request->all() as $key => $val) {
			if(starts_with($key, "item_checkbox")){
				$item = BeryliumItem::where(['id' => intval(str_replace("item_checkbox", "", $key))])->first();
				$after_query = BeryliumItem::where(['menu' => $item->menu, 'before' => $item->id]);
				if($after_query->count()){
					$after = $after_query->first();
					$after->before = $item->before;
					$after->save();
				}
				$menu = $item->parentOf;
				$children = BeryliumItem::where(['menu' => $menu, 'before' => $item->id])->get();
				foreach($children as $child){
					$child->delete();
				}
				$item->delete();
				$count++;
			}
		}
		if($count == 0){
			array_push($errors_array_ptr, trans('Berylium::messages.err_no_items_selected'));
			//TODO: fix this not being shown
		}else{
			//TODO: fix this not being shown
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

	public function returnItem($item, $url){
		$synthesiscmsMainColor = Settings::getFromActive('tab_color');
		switch($item->type){
			case BeryliumItemType::Page:
			$href = "todo: implement self";
			$out = "<a href='$href'>" . $item->title . "</a>";
			break;

			case BeryliumItemType::Link:
			$href = $item->data;
			$out = "<a href='$href'>" . $item->title . "</a>";
			break;

			case BeryliumItemType::Placeholder:
			$href = $url;
			$out = "<a>" . $item->title . "</a>";
			break;
		}
		if($href == $url){
			$active = " active ";
		}else{
			$active = "";
		}
		return ['data' => $out, 'active' => $active];
	}

	public function getMobileMenuItems($slug){
		$out = "";
		foreach(BeryliumItem::where('category', BeryliumItemCategory::Mobile)->cursor() as $item){
			$itemdata = $this->returnItem($item, $slug);
			$active = $itemdata['active'];
			$out .= "<li class='$active'>" . $itemdata['data'] . "</li>";
		}
		return $out;
	}

	public function getDesktopMenuItems($slug){
		$out = "";
		$synthesiscmsMainColor = Settings::getFromActive('tab_color');
		foreach(BeryliumItem::where('category', BeryliumItemCategory::Desktop)->cursor() as $item){
			$itemdata = $this->returnItem($item, $slug);
			$active = $itemdata['active'];
			$out .= "<li class='$active'>" . $itemdata['data'] . "</li>";
		}
		return $out;
	}

	public function getGeneralMenuItems($slug, $menuType){
		$out = "";
		$synthesiscmsMainColor = Settings::getFromActive('main_color');
		switch($menuType){
			case 'mobile':
			$li_class = "col s12 waves-effect waves-$synthesiscmsMainColor";
			break;
			case 'desktop':
			$li_class = "";
			break;
		}
		foreach(BeryliumItem::where('category', BeryliumItemCategory::General)->cursor() as $item){
			$itemdata = $this->returnItem($item, $slug);
			$active = $itemdata['active'];
			$out .= "<li class='$active $li_class'>" . $itemdata['data'] . "</li>";
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
