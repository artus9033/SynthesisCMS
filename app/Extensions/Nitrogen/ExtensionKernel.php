<?php

namespace App\Extensions\Nitrogen;

use App\Http\Controllers\Controller;
use App\Extensions\Nitrogen\Models\NitrogenExtension;
use App\Extensions\Nitrogen\Models\NitrogenItem;
use App\Extensions\Nitrogen\Controllers\NitrogenController;
use App\Extensions\Nitrogen\NitrogenItemType;
use App\Extensions\Nitrogen\NitrogenItemCategory;
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
	public function settingsPositionUp(BackendRequest $request, $id){
		if(NitrogenItem::where(['id' => $id])->count() == 0){
			if(NitrogenItem::where(['id' => NitrogenItem::where(['id' => $id])->first()->before])->count() == 0){
				return \Redirect::route("applet_settings", [ 'extension' => 'Nitrogen' ])->with('errors', array(trans('Nitrogen::messages.err_item_doesnt_exist')));
			}
		}
		$item = NitrogenItem::where(['slider' => NitrogenItem::where(['id' => $id])->first()->slider, 'id' => $id])->first();
		$slider = $item->slider;
		$item_before_id = $item->before;
		if(NitrogenItem::where(['slider' => $slider, 'id' => $item_before_id])->count() != 0){
			$before = NitrogenItem::where(['slider' => $slider, 'id' => $item_before_id])->first();
			$before_id = $before->id;
			$before_before_id = $before->before;
		}else{
			return \Redirect::route("applet_settings", [ 'extension' => 'Nitrogen' ])->with('errors', array(trans('Nitrogen::messages.err_item_cannot_be_moved')));
		}
		if(NitrogenItem::where(['slider' => $slider, 'before' => $item->id])->count() != 0){
			$child_item = NitrogenItem::where(['slider' => $slider, 'before' => $item->id])->first();
			$child_item->before = $before_id;
			$child_item->save();
		}
		$item->before = $before_before_id;
		$before->before = $id;
		$item->save();
		$before->save();
		return \Redirect::route("applet_settings", [ 'extension' => 'Nitrogen' ])->with('messages', array(trans('Nitrogen::messages.msg_item_moved')));
	}

	public function settingsPositionDown(BackendRequest $request, $id){
		if(NitrogenItem::where(['slider' => $this->findOrCreate()->id, 'id' => $id])->count() == 0){
			if(NitrogenItem::where(['slider' => $this->findOrCreate()->id, 'before' => $id])->count() == 0){
				return \Redirect::route("applet_settings", [ 'extension' => 'Nitrogen' ])->with('errors', array(trans('Nitrogen::messages.err_item_doesnt_exist')));
			}
		}
		$item = NitrogenItem::where(['slider' => $this->findOrCreate()->id, 'id' => $id])->first();
		if(NitrogenItem::where(['slider' => $this->findOrCreate()->id, 'id' => $item->before])->count() != 0){
			$before = NitrogenItem::where(['slider' => $this->findOrCreate()->id, 'id' => $item->before])->first();
			$before_id = $before->id;
		}else{
			$before_id = 0;
		}
		if(NitrogenItem::where(['slider' => $this->findOrCreate()->id, 'before' => $id])->count() != 0){
			$child_item = NitrogenItem::where(['slider' => $this->findOrCreate()->id, 'before' => $id])->first();
			$child_item->before = $before_id;
			$child_item->save();
			$child_item_id = $child_item->id;
			if(NitrogenItem::where(['slider' => $this->findOrCreate()->id, 'before' => $child_item_id])->count() != 0){
				$child_item2 = NitrogenItem::where(['slider' => $this->findOrCreate()->id, 'before' => $child_item_id])->first();
				$child_item2->before = $id;
				$child_item2->save();
			}
		}else{
			return \Redirect::route("applet_settings", [ 'extension' => 'Nitrogen' ])->with('errors', array(trans('Nitrogen::messages.err_item_cannot_be_moved')));
		}
		$item->before = $child_item_id;
		$item->save();
		return \Redirect::route("applet_settings", [ 'extension' => 'Nitrogen' ])->with('messages', array(trans('Nitrogen::messages.msg_item_moved')));
	}

	public function settingsDeletePosition(BackendRequest $request, $id){
		$item = NitrogenItem::where(['id' => $id])->first();
		$after_query = NitrogenItem::where(['slider' => $item->slider, 'before' => $item->id]);
		if($after_query->count()){
			$after = $after_query->first();
			$after->before = $item->before;
			$after->save();
		}
		$slider = $this->findOrCreate()->id;
		$children = NitrogenItem::where(['slider' => $slider, 'before' => $id])->get();
		foreach($children as $child){
			$child->delete();
		}
		$item->delete();
		return \Redirect::route("applet_settings", [ 'extension' => 'Nitrogen' ])->with('messages', array(trans('Nitrogen::messages.msg_item_deleted')));
	}

	public function settingsEditPositionPost(BackendRequest $request, $id){
		$title = $request->get('title');
		$content = $request->get('content');
		$type_raw = $request->get('type');
		switch($type_raw){
			case "single":
			$type = NitrogenItemType::FtpSingleImage;
			break;
			case "folder":
			$type = NitrogenItemType::FtpFolder;
			break;
		}
		$hasButton = $request->has('hasButton');
		$buttonText = $request->get('button_text');
		$buttonLink = $request->get('button_link');
		$buttonWavesColor = $request->get('button_waves_color');
		$buttonColor = $request->get('button_color');
		$buttonClass = $request->get('button_class');
		$errors = array();
		$err = false;

		$query = NitrogenItem::where(['id' => $id]);

		if($query->count() == 0){
			return \Redirect::route("applet_settings", [ 'extension' => 'Nitrogen' ])->with('errors', array(trans('Nitrogen::messages.err_item_doesnt_exist')));
		}

		if(strlen($title) == 0 || strlen(trim($title)) == 0){
			$err = true;
			array_push($errors, trans("Nitrogen::messages.err_title_cannot_be_empty"));
		}

		if($err){
			return \Redirect::to(\Request::path())->with('errors', $errors);
		}else{
			$item = $query->first();
			$item->title = $title;
			$item->content = $content;
			$item->type = $type;
			$item->hasButton = $hasButton;
			$item->buttonText = $buttonText;
			$item->buttonLink = $buttonLink;
			$item->buttonWavesColor = $buttonWavesColor;
			$item->buttonColor = $buttonColor;
			$item->buttonClass = $buttonClass;
			$item->save();
			return \Redirect::route("applet_settings", [ 'extension' => 'Nitrogen' ])->with('messages', array(trans('Nitrogen::messages.msg_item_saved')));
		}
	}

	public function settingsEditPositionGet($id){
		$query = NitrogenItem::where(['id' => $id]);
		if($query->count() == 0){
			return \Redirect::route("applet_settings", [ 'extension' => 'Nitrogen' ])->with('errors', array(trans('Nitrogen::messages.err_item_doesnt_exist')));
		}else{
			return view("Nitrogen::partials/edit_item")->with(['model' => $this->findOrCreate(), 'kernel' => $this, 'item' => $query->first()]);
		}
	}

	public function settingsCreatePositionPost(BackendRequest $request){
		$title = $request->get('title');
		$content = $request->get('content');
		$type_raw = $request->get('type');
		switch($type_raw){
			case "single":
			$type = NitrogenItemType::FtpSingleImage;
			break;
			case "folder":
			$type = NitrogenItemType::FtpFolder;
			break;
		}
		$hasButton = $request->has('hasButton');
		$buttonText = $request->get('button_text');
		$buttonLink = $request->get('button_link');
		$buttonWavesColor = $request->get('button_waves_color');
		$buttonColor = $request->get('button_color');
		$buttonClass = $request->get('button_class');
		$errors = array();
		$err = false;

		if(strlen($title) == 0 || strlen(trim($title)) == 0){
			$err = true;
			array_push($errors, trans("Nitrogen::messages.err_title_cannot_be_empty"));
		}

		if($err){
			return \Redirect::to(\Request::path())->with('errors', $errors);
		}else{
			$parent_id = 0;
			if(NitrogenItem::where(['slider' => $this->findOrCreate()->id, 'before' => $parent_id])->count()){
				$items_raw = NitrogenItem::where('slider', $this->findOrCreate()->id);
				$items_count = $items_raw->count();
				$posctr = 0;
				for( $id = $parent_id; $posctr < $items_count; $posctr++){
					$before = NitrogenItem::where(['slider' => $this->findOrCreate()->id, 'before' => $id])->first()->id;
					$id = $before;
				}
			}else{
				$before = $parent_id;
			}
			$created = NitrogenItem::create(['buttonText' => $buttonText, 'buttonLink' => $buttonLink, 'buttonWavesColor' => $buttonWavesColor, 'buttonColor' => $buttonColor, 'buttonClass' => $buttonClass, 'type' => $type, 'hasButton' => $hasButton, 'title' => $title, 'content' => $content, 'before' => $before, 'slider' => $this->findOrCreate()->id]);
			$created->parentOf = $created->id + 1;
			$created->save();
			return \Redirect::route("applet_settings", [ 'extension' => 'Nitrogen' ])->with('messages', array(trans('Nitrogen::messages.msg_item_added')));
		}
	}

	public function settingsCreatePositionGet(){
		return view("Nitrogen::partials/create_item")->with(['model' => $this->findOrCreate(), 'kernel' => $this]);
	}

	public function settingsGet(){
		return view('Nitrogen::partials/settings')->with(['model' => $this->findOrCreate()]);
	}

	public function settingsPost(BackendRequest $request, &$errors_array_ptr){
		$model = $this->findOrCreate();
		$model->enabled = $request->get('enabled') == "on";
		$model->save();
		$count = 0;
		foreach ($request->all() as $key => $val) {
			if(starts_with($key, "item_checkbox")){
				$item = NitrogenItem::where(['id' => intval(str_replace("item_checkbox", "", $key))])->first();
				$after_query = NitrogenItem::where(['slider' => $item->slider, 'before' => $item->id]);
				if($after_query->count()){
					$after = $after_query->first();
					$after->before = $item->before;
					$after->save();
				}
				$slider = $this->findOrCreate()->id;
				$children = NitrogenItem::where(['slider' => $slider, 'before' => $item->id])->get();
				foreach($children as $child){
					$child->delete();
				}
				$item->delete();
				$count++;
			}
		}
		if($count == 0){
			array_push($errors_array_ptr, trans('Nitrogen::messages.err_no_items_selected'));
		}
	}

	public function getExtensionName(){
		return trans('Nitrogen::nitrogen.name');
	}

	public function getExtensionType(){
		return SynthesisExtensionType::Applet;
	}

	public function showSlider($slug){
		return view('Nitrogen::index')->with(['kernel' => $this, 'slug' => $slug, 'model' => $this->findOrCreate()]);
	}

	public function getSliderItems($slug){
		$out = "";
		$model = $this->findOrCreate();
		if($model->hasButton){
			$out .= "<div class='carousel-fixed-item center'>
			<a href='$model->buttonLink' class='btn waves-effect waves-$model->buttonWavesColor $model->buttonColor $model->buttonClass'>$model->buttonText</a>
			</div>";
		}
		foreach(NitrogenItem::all() as $item){
			$out .= "<div class='carousel-item'>
			<h2>$item->title</h2>
			<p class='white-text'>$item->content</p>
			</div>";
		}
		return $out;
	}

	public function hookPositions(&$manager){
		$manager->addStandard(SynthesisPositions::BelowMenu, $this, 'showSlider');
	}

	public function findOrCreate(){
		$model = NitrogenExtension::find(1);
		if(!$model){
			$model = NitrogenExtension::create();
			return $this->findOrCreate();
		}else{
			return $model;
		}
	}
}
