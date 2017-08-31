<?php

namespace App\Extensions\Boron;

use App\Extensions\Boron\Models\BoronExtension;
use App\Http\Requests\SiteManagerRequest;
use App\SynthesisCMS\API\Positions\SynthesisPositions;
use App\SynthesisCMS\API\Extensions\SynthesisExtension;
use App\SynthesisCMS\API\Extensions\SynthesisExtensionType;

/**
 * ExtensionKernel
 *
 * Extension Kernel to control all the functionality directly
 * related to the Extension. This class is required, otherwise any routes
 * using this extension will throw an internal CMS error!
 */
class ExtensionKernel extends SynthesisExtension
{

	public function settingsGet()
	{
		return view('Boron::partials/settings')->with(['model' => $this->findOrCreate()]);
	}

	public function findOrCreate()
	{
		$model = BoronExtension::find(1);
		if (!$model) {
			$model = BoronExtension::create(['enabled' => true, 'url' => 'https://www.facebook.com/LaravelCommunity', 'facebookAppId' => 'Enter Your Key Here']);
			return $this->findOrCreate();
		} else {
			return $model;
		}
	}

	public function settingsPost(SiteManagerRequest $request, &$errors_array_ptr)
	{
		$model = $this->findOrCreate();
		$model->enabled = $request->get('enabled') == "on";
		$model->url = $request->get('url');
		$model->facebookAppId = $request->get('facebookAppId');
		$model->save();
	}

	public function getExtensionName()
	{
		return trans('Boron::boron.name');
	}

	public function getExtensionType()
	{
		return SynthesisExtensionType::Applet;
	}

	public function showSlideout($slug)
	{
		return view('Boron::index')->with(['slug' => $slug, 'model' => $this->findOrCreate()]);
	}

	public function hookPositions(&$manager)
	{
		$manager->addStandard(SynthesisPositions::OverContent, $this, 'showSlideout');
	}
}
