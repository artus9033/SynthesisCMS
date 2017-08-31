<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\BackendRequest;
use App\Http\Requests\ContentEditorRequest;
use App\Http\Requests\SiteManagerRequest;
use App\Models\Settings\Settings;
use App\Models\Stats\StatsTracker;
use App\Models\Stats\StatsTrackerModule;
use App\Toolbox;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BackendController extends Controller
{
	public function index(ContentEditorRequest $request)
	{
		return view('admin.admin_dashboard');
	}

	public function settingsGet(SiteManagerRequest $request)
	{
		return view('admin.settings');
	}

	public function settingsAjaxFaviconConvert(SiteManagerRequest $request)
	{
		if ($request->ajax()) {
			if ($request->hasFile('favicon-file')) {
				$file = $request->file('favicon-file');
				if ($file->isFile()) {
					if (!$file->isExecutable()) {
						if (strstr($file->getClientMimeType(), 'image')) {
							if (strstr($file->getClientOriginalExtension(), 'ico')) {
								move_uploaded_file($file, public_path('favicon.ico'));
							} else {
								$icoLib = new \PHP_ICO($file, array(array(128, 128)));
								$icoLib->save_ico(public_path('favicon.ico'));
							}
							return response()->json(['success' => true]);
						} else {
							return response()->json(['success' => false, 'error' => 'Uploaded data not a valid image']);
						}
					} else {
						return response()->json(['success' => false, 'error' => 'Uploaded an executable file']);
					}
				} else {
					return response()->json(['success' => false, 'error' => 'Uploaded data not a valid file']);
				}
			} else {
				return response()->json(['success' => false, 'error' => 'No favicon file uploaded']);
			}
		} else {
			return response()->json(['success' => false, 'error' => 'Response not JSON']);
		}
	}

	public function settingsPost(SiteManagerRequest $request)
	{
		$settings = Settings::getActiveInstance();
		$settings->home_page = $request->get('home_page');
		$settings->header_title = $request->get('header_title');
		$settings->tab_title = $request->get('tab_title');
		$settings->footer_copyright = $request->get('footer_copyright');
		$settings->footer_more_links_bottom_text = $request->get('footer_more_links_bottom_text');
		$settings->footer_more_links_bottom_href = $request->get('footer_more_links_bottom_href');
		$settings->footer_links_text = $request->get('footer_links_text');
		$settings->footer_links_content = $request->get('footer_links_content');
		$settings->footer_header = $request->get('footer_header');
		$settings->footer_content = $request->get('footer_content');
		$settings->tab_color = $request->get('tab_color');
		$settings->main_color = $request->get('main_color');
		$settings->color_class = $request->get('main_color_class');
		$settings->devModeEnabled = ($request->get('devModeCheckbox') == 'on');
		$settings->logo_background_color = $request->get('logo_background_color');
		$settings->save();
		return \Redirect::route('settings')->with('messages', array(trans('synthesiscms/settings.msg_saved')));
	}

	public function manageAppletsGet(SiteManagerRequest $request)
	{
		return view('admin.manage_applets');
	}

	public function appletSettingsGet($extension, SiteManagerRequest $request)
	{
		return view('admin.applet_settings')->with(['extension' => $extension]);
	}

	public function appletSettingsPost($extension, SiteManagerRequest $request)
	{
		$errors = array();
		$err = false;

		if (!$err) {
			Toolbox::chkRoute($slug);
		}

		if ($err) {
			return \Redirect::to(\Request::path())->with('errors', $extension);
		} else {
			$kpath = 'App\\Extensions\\' . $extension . '\\ExtensionKernel';
			$kernel = new $kpath;
			$errors = Array();
			$messages = Array();
			array_push($messages, trans('synthesiscms/admin.msg_applet_settings_saved', ['applet' => $kernel->getExtensionName()]));
			$kernel->settingsPost($request, $errors, $messages);
			return \Redirect::route("applet_settings", $extension)->with(['messages' => $messages, 'errors' => $errors]);
		}
	}

	public function feedAdminStatsTrackerCharts(ContentEditorRequest $request)
	{
		$periodCyclesLimit = 80; // MAX (in time units) periods to show
		$timeUnitReceived = $request->get('timeUnit');
		switch ($timeUnitReceived) {
			case 'day':
				$timeUnit = 'day';
				$fd = '%d.%m\'';
				$uniqueVisitsPerTimePeriodChartPeriodWord = trans('synthesiscms/stats.single_word_daily');
				break;
			case 'week':
				$timeUnit = 'week';
				$fd = 'WEEK';
				$uniqueVisitsPerTimePeriodChartPeriodWord = trans('synthesiscms/stats.single_word_weekly');
				break;
			case 'month':
				$timeUnit = 'month';
				$fd = '%B ';
				$uniqueVisitsPerTimePeriodChartPeriodWord = trans('synthesiscms/stats.single_word_monthly');
				break;
			case 'year':
				$timeUnit = 'year';
				$fd = '';
				$uniqueVisitsPerTimePeriodChartPeriodWord = trans('synthesiscms/stats.single_word_annually');
				break;
			default:
				$timeUnit = 'month';
				$fd = '%B ';
				$uniqueVisitsPerTimePeriodChartPeriodWord = trans('synthesiscms/stats.single_word_monthly');
				break;
		}

		$uniqueVisitsPerTimePeriodChartPeriodStart = Carbon::createFromFormat('d F, Y', $request->get('timePeriodStart'));
		$uniqueVisitsPerTimePeriodChartPeriodEnd = Carbon::createFromFormat('d F, Y', $request->get('timePeriodEnd'));

		$uniqueVisitsPerTimePeriodChartPeriodStartDateString = $uniqueVisitsPerTimePeriodChartPeriodStart->toDateString();
		$uniqueVisitsPerTimePeriodChartPeriodEndDateString = $uniqueVisitsPerTimePeriodChartPeriodEnd->toDateString();

		$uniqueVisitsPerTimePeriodChartPeriodStartDateHumanString = Carbon::parse($uniqueVisitsPerTimePeriodChartPeriodStartDateString)->formatLocalized("%e.%m.%G");
		$uniqueVisitsPerTimePeriodChartPeriodEndDateHumanString = Carbon::parse($uniqueVisitsPerTimePeriodChartPeriodEndDateString)->formatLocalized("%e.%m.%G");

		$start = new DateTime($uniqueVisitsPerTimePeriodChartPeriodStartDateString);
		$end = new DateTime($uniqueVisitsPerTimePeriodChartPeriodEndDateString);
		$interval = DateInterval::createFromDateString('1 ' . $timeUnit);
		$end = $end->modify('+1 day');
		$period = new DatePeriod($start, $interval, $end); // Get a set of months between $start & $end

		$labelsAll = Array();
		$valuesAll = Array();
		$valuesSemiAll = Array();
		$valuesUnique = Array();

		$items = StatsTracker::all();

		$mLineKey = -1;

		if (iterator_count($period) <= $periodCyclesLimit) {
			foreach ($period as $dt) {
				$ipsTable = Array();
				$mLineKey++;

				$allCt = 0;
				$semiAllCt = 0;
				$uniqueCt = 0;
				$ipsTablePerRoute = Array();


				$date = Carbon::parse($dt->format('Y-m-d'));

				if ($fd == "WEEK") {
					array_push($labelsAll, utf8_encode($date->weekOfMonth . '\'' . $date->formatLocalized("%y")));
				} else {
					array_push($labelsAll, utf8_encode($date->formatLocalized($fd . "%y")));
				}

				foreach ($items as $item) {
					$itemDate = Carbon::parse($item->date)->setTime(0, 0, 0);
					if ($itemDate->between(Carbon::parse($start->format('Y-m-d')), Carbon::parse($end->format('Y-m-d')))) {
						$continue = false;
						if ($timeUnit == 'day') {
							if ($itemDate->isSameDay($date)) {
								$continue = true;
							}
						} else if ($timeUnit == 'week') {
							if ($itemDate->weekOfYear == $date->weekOfYear && $itemDate->year == $date->year) {
								$continue = true;
							}
						} else if ($timeUnit == 'month') {
							if ($itemDate->isSameMonth($date, true)) {
								$continue = true;
							}
						} else {
							if ($itemDate->isSameYear($date)) {
								$continue = true;
							}
						}
						if ($continue) {
							$allCt += $item->hits;
							if (!in_array($item->ip, $ipsTable)) {
								$uniqueCt++;
								array_push($ipsTable, $item->ip);
							}
							if (!array_key_exists($item->url, $ipsTablePerRoute)) {
								$ipsTablePerRoute[$item->url] = Array();
							}
							if (!in_array($item->ip, $ipsTablePerRoute[$item->url])) {
								$semiAllCt++;
								array_push($ipsTablePerRoute[$item->url], $item->ip);
							}
						}
					}
				}
				array_push($valuesAll, $allCt);
				array_push($valuesSemiAll, $semiAllCt);
				array_push($valuesUnique, $uniqueCt);
			}

			$labelsJson = json_encode($labelsAll);
			$valuesJson = json_encode(Array($valuesAll, $valuesSemiAll, $valuesUnique));

			$circleLabels = Array();
			$circleValues = Array();
			$circleCount = 0;

			foreach (StatsTracker::orderBy('hits', 'DESC')->get() as $item) {
				$itemDate = Carbon::parse($item->date)->setTime(0, 0, 0);
				if (Carbon::now()->setTime(0, 0, 0)->equalTo($itemDate)) {
					array_push($circleLabels, $item->url);
					array_push($circleValues, $item->hits);
					$circleCount++;
				}
			}

			if ($circleCount == 0) {
				array_push($circleLabels, trans('synthesiscms/stats.circle_diagram_item_no_registered_visits_today'));
				array_push($circleValues, 1);
			}

			$circleLabelsJson = json_encode($circleLabels);
			$circleValuesJson = json_encode($circleValues);

			return view('admin.partials.admin_stats_charts',
				[
					'circleCount' => $circleCount,
					'circleLabelsJson' => $circleLabelsJson,
					'circleValuesJson' => $circleValuesJson,
					'labelsJson' => $labelsJson,
					'valuesJson' => $valuesJson,
					'uniqueVisitsPerTimePeriodChartPeriodWord' => $uniqueVisitsPerTimePeriodChartPeriodWord,
					'uniqueVisitsPerTimePeriodChartPeriodStartDateHumanString' => $uniqueVisitsPerTimePeriodChartPeriodStartDateHumanString,
					'uniqueVisitsPerTimePeriodChartPeriodEndDateHumanString' => $uniqueVisitsPerTimePeriodChartPeriodEndDateHumanString,
				]
			);
		} else {
			return response(trans('synthesiscms/stats.wow_time_period_too_long_to_be_displayed', ['length' => iterator_count($period), 'max' => $periodCyclesLimit]));
		}
	}

	function checkAdminStatsTrackerChartsUpdates(ContentEditorRequest $request)
	{
		$statsTrackerModuleLastUpdate = Carbon::parse(StatsTrackerModule::getLastUpdateDateTime());
		$requestLastUpdate = Carbon::parse($request->get('lastDateTime'));
		return response()->json(
			[
				'isExpired' => $statsTrackerModuleLastUpdate->greaterThanOrEqualTo($requestLastUpdate),
				'dateTime' => Carbon::now()->toDateTimeString()
			]
		);
	}
}
