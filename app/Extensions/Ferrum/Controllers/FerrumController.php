<?php

namespace App\Extensions\Ferrum\Controllers;

use App\Extensions\Ferrum\Models\FerrumExtension;
use App\Http\Controllers\Controller;
use App\Toolbox;
use Carbon\Carbon;
use \Mpdf\Mpdf;

class FerrumController extends Controller
{

	public function downloadPdf($page, $kernel, $base_slug)
	{
		$query = FerrumExtension::where('id', $page->id);
		if (!$query->exists()) {
			return \View::make('errors.cms')->with(['error' => trans("Ferrum::messages.err_form_not_found"), 'help' => trans("Ferrum::messages.err_form_not_found_help")]);
		} else {
			$extension_instance = $query->first();
			$datetimeNowFilenameFormatted = Carbon::now()->format('Y-m-d_H_i_s');
			$filename = Toolbox::string_truncate_no_dots($page->page_title, 25) . '_' . trans('Ferrum::ferrum.file_name_part_single_word_applications') . '_' . $datetimeNowFilenameFormatted . '.pdf';
			$fileUri = public_path('tmp/' . $filename);
			$handle = fopen($fileUri, 'w+');

			$applications = json_decode($extension_instance->applicationsInJson);

			$pdf = new Mpdf(['tempDir' => public_path('tmp/')]);
			$pdf->AddPage();

			if (count($applications)) {

				list($allTableHeadings, $allTableRows) = $this->getApplicationsAsTable($applications);

				$A4PaperSheetWidth = 210; // 210mm = 21cm, A4 paper sheet width
				$margin_left = 10; // 10mm = 1cm
				$margin_right = 10; // 10mm = 1cm
				$date_time_spacing = 17; // 17mm = 1.7cm
				$A4PaperSheetWidthWithMargins = ($A4PaperSheetWidth - ($margin_left + $margin_right));

				$pdf->SetLeftMargin($margin_left);
				$pdf->SetRightMargin($margin_right);

				$lineWidth = ($A4PaperSheetWidthWithMargins / count($allTableHeadings));

				$pdf->SetFont('Helvetica', 'B', 20);
				$pdf->Write(0, $page->page_title);
				$pdf->Ln();
				$pdf->SetFont('Helvetica', '', 14);
				$pdf->Write($date_time_spacing, trans('Ferrum::items.word_access_timestamp_pdf', ['datetime' => Carbon::now()->toDateTimeString()]));
				$pdf->Ln($date_time_spacing);

				foreach ($allTableHeadings as $heading) {
					$pdf->SetFont('Helvetica', 'B', 12);
					$pdf->Cell($lineWidth, 12, $heading, 1, 0, 'C');
				}
				$pdf->Ln();

				foreach ($allTableRows as $row) {
					foreach ($row as $cell) {
						$pdf->SetFont('Helvetica', '', 12);
						$pdf->Cell($lineWidth, 12, $cell, 1, 0, 'C');
					}
					$pdf->Ln();
				}
			} else {
				$message = Carbon::now()->toDateTimeString() . " : " . trans('Ferrum::messages.msg_no_applications');
				$pdf->SetFont('Helvetica', 'B', 20);
				$pdf->Write(0, $page->page_title);
				$pdf->Ln();
				$pdf->SetFont('Helvetica', '', 16);
				$pdf->Write(20, $message);
			}

			fputs($handle, $pdf->Output());

			fclose($handle);

			$headers = Array(
				'Content-Type' => 'application/pdf',
			);

			return \Response::file($fileUri, $headers)->deleteFileAfterSend(true);
		}
	}

	public function getApplicationsAsTable($applications)
	{
		$tableHeadings = Array();
		$tableValues = Array();

		$masterKey = -1;

		foreach ($applications as $application) {
			$headingsInsideApplication = Array();
			$valuesInsideApplication = Array();
			foreach ($application as $fieldPacket) {
				array_push($headingsInsideApplication, $fieldPacket[0]);
				array_push($valuesInsideApplication, $fieldPacket[1]);
			}
			$found = false;
			foreach ($tableHeadings as $tableKey => $tableHeading) {
				if (!array_diff($tableHeading, $headingsInsideApplication)) {
					$found = true;
					$masterKey = $tableKey;
				}
			}

			if (!$found) {
				$masterKey += 1;
				$tableHeadings[$masterKey] = $headingsInsideApplication;
			}

			if (!array_key_exists($masterKey, $tableValues)) {
				$tableValues[$masterKey] = Array();
			}
			array_push($tableValues[$masterKey], $valuesInsideApplication);
		}
		$allTableHeadings = Array();
		$allTableRows = Array();

		foreach ($tableHeadings as $firstKey => $tableHeadingPack) {
			foreach ($tableHeadingPack as $secondKey => $tableHeading) {
				array_push($allTableHeadings, $tableHeading);
			}
		}

		foreach ($tableHeadings as $key1 => $heading) {
			foreach ($tableValues[$key1] as $key2 => $valuePack) {
				$row = Array();
				foreach ($allTableHeadings as $doesntMatter) {
					array_push($row, trans('Ferrum::items.word_row_field_empty_compat'));
				}
				foreach ($valuePack as $key3 => $value) {
					$row[($key1 * count($heading)) + $key3] = $value;
				}
				array_push($allTableRows, $row);
			}
		}

		return Array($allTableHeadings, $allTableRows);
	}

	public function downloadCsv($page, $kernel, $base_slug)
	{
		$query = FerrumExtension::where('id', $page->id);
		if (!$query->exists()) {
			return \View::make('errors.cms')->with(['error' => trans("Ferrum::messages.err_form_not_found"), 'help' => trans("Ferrum::messages.err_form_not_found_help")]);
		} else {
			$extension_instance = $query->first();
			$datetimeNowFilenameFormatted = Carbon::now()->format('Y-m-d_H_i_s');
			$filename = Toolbox::string_truncate_no_dots($page->page_title, 25) . '_' . trans('Ferrum::ferrum.file_name_part_single_word_applications') . '_' . $datetimeNowFilenameFormatted . '.csv';
			$fileUri = public_path('tmp/' . $filename);
			$handle = fopen($fileUri, 'w+');

			fputs($handle, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF))); //Add BOM for the user program to recognize UTF-8 encoding

			$applications = json_decode($extension_instance->applicationsInJson);

			if (count($applications)) {

				list($allTableHeadings, $allTableRows) = $this->getApplicationsAsTable($applications);

				fputcsv($handle, Array($page->page_title));

				fputcsv($handle, Array(trans('Ferrum::items.word_access_timestamp_pdf', ['datetime' => Carbon::now()->toDateTimeString()])));

				fputcsv($handle, Array(''));

				fputcsv($handle, $allTableHeadings);

				foreach ($allTableRows as $row) {
					fputcsv($handle, $row);
				}
			} else {
				fputcsv($handle, Array(trans('Ferrum::items.word_access_timestamp_pdf', ['datetime' => Carbon::now()->toDateTimeString()]) . " : " . trans('Ferrum::messages.msg_no_applications')));
			}

			fclose($handle);

			$headers = Array(
				'Content-Type' => 'text/csv',
			);

			return \Response::download($fileUri, $filename, $headers)->deleteFileAfterSend(true);
		}
	}

	public function index($page, $kernel, $base_slug)
	{
		$query = FerrumExtension::where('id', $page->id);
		if (!$query->exists()) {
			return \View::make('errors.cms')->with(['error' => trans("Ferrum::messages.err_form_not_found"), 'help' => trans("Ferrum::messages.err_form_not_found_help")]);
		} else {
			$extension_instance = $query->first();
			$formInJson = $extension_instance->formInJson;
			if ($this->isFormActive($extension_instance)) {
				return \View::make('Ferrum::index')->with(['formInJson' => $formInJson, 'kernel' => $kernel, 'page' => $page, 'extension_instance' => $extension_instance, 'extensionCallback' => $this, 'base_slug' => $base_slug]);
			} else {
				return \View::make('Ferrum::applications_closed')->with(['formInJson' => $formInJson, 'kernel' => $kernel, 'page' => $page, 'extension_instance' => $extension_instance, 'extensionCallback' => $this, 'base_slug' => $base_slug]);
			}
		}
	}

	public function isFormActive($ferrum_instance)
	{
		return Carbon::parse($ferrum_instance->applicationsCloseDateTime)->isFuture();
	}

	public function confirm($page, $kernel, $base_slug)
	{
		if (\Session::get('ferrumCanConfirmApplication', false) === false) {
			abort(404);
		} else {
			\Session::forget('ferrumCanConfirmApplication');
		}
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
			if ($this->isFormActive($extension_instance)) {
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
				if ($receivedCount == 0) {
					return \View::make('errors.cms')->with(['error' => trans("Ferrum::messages.err_form_problem"), 'help' => trans("Ferrum::messages.err_form_empty")]);
				}
				if ($receivedCount != $expectedCount) {
					return \View::make('errors.cms')->with(['error' => trans("Ferrum::messages.err_form_problem"), 'help' => trans("Ferrum::messages.err_form_not_submitted_properly")]);
				}

				$mixedArray = Array();
				foreach ($expectedValues as $key => $expectedValue) {
					array_push($mixedArray, Array($expectedValue->elementDatabaseFieldName, $receivedValues[$key]));
				}

				if (strlen($extension_instance->applicationsInJson)) {
					$applications = json_decode($extension_instance->applicationsInJson);
				} else {
					$applications = Array();
				}

				$allFields = Array();

				foreach ($mixedArray as $itemArray) {
					array_push($allFields, $itemArray);
				}

				array_push($applications, $mixedArray);

				$extension_instance->applicationsInJson = json_encode($applications);
				$extension_instance->save();

				\Session::put('ferrumCanConfirmApplication', true);

				return redirect($base_slug . '/confirm');
			} else {
				return \View::make('Ferrum::applications_closed')->with(['kernel' => $kernel, 'page' => $page, 'extension_instance' => $extension_instance, 'extensionCallback' => $this, 'base_slug' => $base_slug]);
			}
		}
	}
}
