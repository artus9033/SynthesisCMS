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
	public function settingsGet(){
		return view('berylium::partials/settings')->with(['model' => $this->findOrCreate()]);
	}

	public function settingsPost(BackendRequest $request){

	}

	public function getExtensionName(){
		return trans('berylium::berylium.name');
	}

	public function getExtensionType(){
		return SynthesisExtensionType::Applet;
	}

	public function showMenu($slug){
		return view('berylium::index')->with(['slug' => $slug, 'model' => $this->findOrCreate()]);
	}

	public function showMenuMobileButton($slug){
		return view('berylium::mobile_button')->with('slug', $slug);
	}

	public function getMobileMenuItems(){
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

	public function getDesktopMenuItems(){
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

	public function getGeneralMenuItems(){
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
		$manager->addCustom('berylium', 'mobile-menu', $this, 'getMobileMenuItems()');
		$manager->addCustom('berylium', 'desktop-menu', $this, 'getDesktopMenuItems()');
		$manager->addCustom('berylium', 'menu', $this, 'getGeneralMenuItems()');
	}

	public function findOrCreate(){
		$model = BeryliumExtension::find(1);
		if(!$model){
			BeryliumExtension::create();
		}else{
			return $model;
		}
	}
}
