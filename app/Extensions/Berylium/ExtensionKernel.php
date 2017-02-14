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
	public function settingsCreatePositionPost(BackendRequest $request){
		$title = $request->get('title');
		$category = $request->get('category');
		$type = $request->get('type');
		$link = $request->get('link');
		$errors = array();
		$err = false;

		if(strlen($title) == 0 || strlen(trim($title)) == 0){
			$err = true;
			array_push($errors, trans("berylium::messages.err_title_cannot_be_empty"));
		}

		if($err){
			return \Redirect::to(\Request::path())->with('errors', $errors);
		}else{
			//TODO: add parent choosing
			BeryliumItem::create(['type' => $type, 'category' => $category, 'title' => $title, 'href' => $link, 'parent' => 0, 'menu' => $this->findOrCreate()->id]);

			return \Redirect::route("manage_routes")->with('message', trans('synthesiscms/admin.msg_route_saved', ['route' => $page->slug]));
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
			return BeryliumExtension::create();
		}else{
			return $model;
		}
	}
}
