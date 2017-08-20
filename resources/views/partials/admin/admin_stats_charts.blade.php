<script type="text/javascript" src="{!! asset('js/Chart.js') !!}"></script>
<script type="text/javascript">
    $('.tooltipped').tooltip();
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
<div class="section col s12 l7">
	<canvas id="uniqueVisitsPerTimePeriodChartCanvas" class="col s12 tooltipped"
			data-tooltip="{!! trans('synthesiscms/stats.tooltip_dashboard_time_period_traffic_chart',
				['periodically' => $uniqueVisitsPerTimePeriodChartPeriodWord,
				'start' => $uniqueVisitsPerTimePeriodChartPeriodStartDateHumanString,
				'end' => $uniqueVisitsPerTimePeriodChartPeriodEndDateHumanString]) !!}"
			data-position="top" data-delay="50"></canvas>
</div>
<div class="section col s12 l5">
	<canvas id="todaysTrafficChartCanvas" class="col s12 tooltipped"
			data-tooltip="{!! trans('synthesiscms/stats.tooltip_dashboard_todays_traffic_chart') !!}"
			data-position="top" data-delay="50"></canvas>
</div>