@extends('layouts.admin')

@section('title')
	{{ trans('synthesiscms/admin.backend')}}
@endsection

@section('breadcrumbs')
	<a href="{{ route('admin') }}" class="breadcrumb">{{ trans('synthesiscms/admin.backend') }}</a>
@endsection

@section('brand-logo')
	{{ trans('synthesiscms/admin.backend') }}
@endsection

@php
	use Carbon\Carbon;

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
@endphp

@section('head')
	<script type="text/javascript" src="{!! asset('js/Chart.js') !!}"></script>
	<script type="text/javascript">
        $('.tooltipped').tooltip();
        var dynamicAdminChartHeight = $("#admin-dashboard-container").innerHeight();
        $(".dynamicHeightAdminChart").height(dynamicAdminChartHeight);
        window.trans = {
            amount_of_views: "{{ trans('synthesiscms/stats.views_amount') }}",
        };
        window.stats = {
            diagramLabels: {!! $labelsJson !!},
            diagramValues: {!! $valuesJson !!},
            circleDiagramCount: {!! $circleCount !!},
            circleDiagramLabels: {!! $circleLabelsJson !!},
            circleDiagramValues: {!! $circleValuesJson !!},
        };
	</script>
	<script type="text/javascript" src="{!! asset('js/admin-stats.js') !!}"></script>
@endsection

@section('main')
	<div class="container col s12 row" id="admin-dashboard-container">
		<div>
			<div class="card-content no-padding">
				<div class="card-title center">
					<h2 class="card-panel {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text"><i
								class="material-icons white-text medium left valign"
								style="line-height: unset !important;">show_chart</i>{{ trans('synthesiscms/admin.stats') }}
					</h2>
				</div>
				<div class="row col s12"></div>
				<div class="section col s12 l7">
					<canvas id="uniqueVisitsPerTimePeriodChartCanvas" class="col s12 dynamicHeightAdminChart tooltipped"
							data-tooltip="{!! trans('synthesiscms/stats.tooltip_dashboard_time_period_traffic_chart',
							['periodically' => $uniqueVisitsPerTimePeriodChartPeriodWord,
							'start' => $uniqueVisitsPerTimePeriodChartPeriodStartDateHumanString,
							'end' => $uniqueVisitsPerTimePeriodChartPeriodEndDateHumanString]) !!}"
							data-position="top" data-delay="50"></canvas>
				</div>
				<div class="section col s12 l5">
					<canvas id="todaysTrafficChartCanvas" class="col s12 dynamicHeightAdminChart tooltipped"
							data-tooltip="{!! trans('synthesiscms/stats.tooltip_dashboard_todays_traffic_chart') !!}"
							data-position="top" data-delay="50"></canvas>
				</div>
			</div>
		</div>
	</div>
@endsection
