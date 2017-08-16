<?php

namespace App\Extensions\Ferrum\Controllers;

use App\Extensions\Ferrum\Models\FerrumExtension;
use App\Http\Controllers\Controller;

class FerrumController extends Controller
{
	public function index($page, $kernel, $base_slug)
	{
		$query = FerrumExtension::where('id', $page->id);
		if (!$query->exists()) {
			return \View::make('errors.cms')->with(['error' => trans("Ferrum::messages.err_form_not_found"), 'help' => trans("Ferrum::messages.err_form_not_found_help")]);
		} else {
			$extension_instance = $query->first();
			$formInJson = $extension_instance->formInJson;
			return \View::make('Ferrum::index')->with(['formInJson' => $formInJson, 'kernel' => $kernel, 'page' => $page, 'extension_instance' => $extension_instance, 'extensionCallback' => $this, 'base_slug' => $base_slug]);
		}
	}

	public function confirm($page, $kernel, $base_slug)
	{
		$query = FerrumExtension::where('id', $page->id);
		if (!$query->exists()) {
			return \View::make('errors.cms')->with(['error' => trans("Ferrum::messages.err_form_not_found"), 'help' => trans("Ferrum::messages.err_form_not_found_help")]);
		} else {
			$extension_instance = $query->first();
			$formInJson = $extension_instance->formInJson;
			return \View::make('Ferrum::application_confirmation')->with(['formInJson' => $formInJson, 'kernel' => $kernel, 'page' => $page, 'extension_instance' => $extension_instance, 'extensionCallback' => $this, 'base_slug' => $base_slug]);
		}
	}

	public function apply($page, $kernel, $base_slug)
	{
		$query = FerrumExtension::where('id', $page->id);
		if (!$query->exists()) {
			return \View::make('errors.cms')->with(['error' => trans("Ferrum::messages.err_form_not_found"), 'help' => trans("Ferrum::messages.err_form_not_found_help")]);
		} else {
			$extension_instance = $query->first();
			$receivedValues = Array();
			$receivedCount = 0;
			foreach (explode(',', \Request::get('ferrum-all-form-ids-jsonified')) as $formId) {
				if (\Request::has('ferrum-input-' . $formId)) {
					$receivedCount++;
					array_push($receivedValues, \Request::get('ferrum-input-' . $formId));
				}
			}
			$expectedValues = Array();
			$expectedCount = 0;
			if (strlen($extension_instance->formInJson) > 0) {
				foreach (json_decode($extension_instance->formInJson) as $node) {
					if ($node->elementType == 'ferrum-text-input-with-hint-element' || $node->elementType == 'ferrum-number-input-with-hint-element') {
						$expectedCount++;
						array_push($expectedValues, $node);
					}
				}
			} else {
				return \View::make('errors.cms')->with(['error' => trans("Ferrum::messages.err_form_problem"), 'help' => trans("Ferrum::messages.err_form_empty")]);
			}
			if ($receivedCount != $expectedCount) {
				return \View::make('errors.cms')->with(['error' => trans("Ferrum::messages.err_form_problem"), 'help' => trans("Ferrum::messages.err_form_not_submitted_properly")]);
			}
			//TODO: add expiration date
			$mixedArray = Array();
			foreach ($expectedValues as $key => $expectedValue) {
				array_push($mixedArray, Array($expectedValue->elementDatabaseFieldName, $receivedValues[$key]));
			}

			if (strlen($extension_instance->applicationsInJson)) {
				$applications = json_decode($extension_instance->applicationsInJson);
			} else {
				$applications = Array();
			}
			foreach ($mixedArray as $itemArray) {
				array_push($applications, $itemArray);
			}

			$extension_instance->applicationsInJson = json_encode($applications);
			$extension_instance->save();

			return redirect($base_slug . '/confirm');
		}
	}
}
