<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\BackendRequest;
use App\Models\Settings\Settings;
use App\Toolbox;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BackendController extends Controller
{
	public function index()
	{
		if (Auth::check() && Auth::user()->is_admin) {
			return view('admin.admin_dashboard');
		} else {
			return view('auth.error');
		}
	}

	public function settingsGet()
	{
		return view('admin.settings');
	}

	public function settingsPost(BackendRequest $request)
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
		$settings->save();
		return \Redirect::route('settings')->with('messages', array(trans('synthesiscms/settings.msg_saved')));
	}

	public function manageAppletsGet()
	{
		return view('admin.manage_applets');
	}

	public function appletSettingsGet($extension)
	{
		return view('admin.applet_settings')->with(['extension' => $extension]);
	}

	public function appletSettingsPost($extension, BackendRequest $request)
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

	public function feedAdminStatsTrackerChats(\Request $request){
		$uniqueVisitsPerTimePeriodChartPeriodStart = Carbon::now()->subMonths(2);
		$uniqueVisitsPerTimePeriodChartPeriodEnd = Carbon::now()->addMonths(2);

		$uniqueVisitsPerTimePeriodChartPeriodWord = 'TODO';
		$uniqueVisitsPerTimePeriodChartPeriodStartDateString = $uniqueVisitsPerTimePeriodChartPeriodStart->toDateString();
		$uniqueVisitsPerTimePeriodChartPeriodEndDateString = $uniqueVisitsPerTimePeriodChartPeriodEnd->toDateString();

		$uniqueVisitsPerTimePeriodChartPeriodStartDateHumanString = Carbon::parse($uniqueVisitsPerTimePeriodChartPeriodStartDateString)->formatLocalized("%e.%m.%G");
		$uniqueVisitsPerTimePeriodChartPeriodEndDateHumanString = Carbon::parse($uniqueVisitsPerTimePeriodChartPeriodEndDateString)->formatLocalized("%e.%m.%G");

		$start = new DateTime($uniqueVisitsPerTimePeriodChartPeriodStartDateString);
		$end = new DateTime($uniqueVisitsPerTimePeriodChartPeriodEndDateString);
		$interval = DateInterval::createFromDateString('1 month');
		$period = new DatePeriod($start, $interval, $end); // Get a set of months between $start & $end

		$labels = Array();
		$values = Array();

		foreach ($period as $dt) {
			$date = Carbon::parse($dt->format('Y-m-d'));
			array_push($labels, utf8_encode($date->formatLocalized("%B %y")));
			array_push($values, random_int(0, 100));
		}

		$labelsJson = json_encode($labels);
		$valuesJson = json_encode($values);

		$circleLabels = Array();
		$circleValues = Array();
		$circleCount = 0;

		$items = \App\Models\Stats\Tracker::all();

		foreach($items as $item){
			$itemDate = Carbon::parse($item->date)->setTime(0, 0, 0);
			if(Carbon::now()->setTime(0, 0, 0)->equalTo($itemDate)){
				array_push($circleLabels, $item->url);
				array_push($circleValues, $item->hits);
				$circleCount++;
			}
		}

		if($circleCount == 0){
			array_push($circleLabels, trans('synthesiscms/stats.circle_diagram_item_no_registered_visits_today'));
			array_push($circleValues, 1);
		}

		$circleLabelsJson = json_encode($circleLabels);
		$circleValuesJson = json_encode($circleValues);

		return view('partials.admin.admin_stats_charts',
			[
				'circleCount' => $circleCount,
				'circleLabelsJson' => $circleLabelsJson,
				'circleValuesJson' => $circleValuesJson,
				'labelsJson' => $labelsJson,
				'valuesJson' => $valuesJson,
				'uniqueVisitsPerTimePeriodChartPeriodWord' => $uniqueVisitsPerTimePeriodChartPeriodWord,
				'uniqueVisitsPerTimePeriodChartPeriodStartDateHumanString' => $uniqueVisitsPerTimePeriodChartPeriodStartDateHumanString,
				'uniqueVisitsPerTimePeriodChartPeriodEndDateHumanString' => $uniqueVisitsPerTimePeriodChartPeriodEndDateHumanString,
			]);
	}
}
