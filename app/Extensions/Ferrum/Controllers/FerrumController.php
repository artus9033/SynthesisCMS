<?php

namespace App\Extensions\Ferrum\Controllers;

use App\Extensions\Ferrum\Models\FerrumExtension;
use App\Http\Controllers\Controller;

class FerrumController extends Controller
{
	public function index($page, $kernel, $base_slug)
	{
		$extension_instance = FerrumExtension::where('id', $page->id)->first();
		$formInJson = $extension_instance->formInJson;
		if ($formInJson == null) {
			return \View::make('errors.cms')->with(['error' => trans("Ferrum::messages.err_form_not_found"), 'help' => trans("Ferrum::messages.err_form_not_found_help")]);
		} else {
			return \View::make('Ferrum::index')->with(['formInJson' => $formInJson, 'kernel' => $kernel, 'page' => $page, 'extension_instance' => $extension_instance, 'extensionCallback' => $this, 'base_slug' => $base_slug]);
		}
	}
}
