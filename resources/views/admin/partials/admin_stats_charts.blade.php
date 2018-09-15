<script type="text/javascript">
    $('.tooltipped').tooltip();
    window.trans = {
        lineDiagram: [
            "{{ trans('synthesiscms/stats.all_views_amount') }}",
            "{{ trans('synthesiscms/stats.unique_per_route_views_amount') }}",
            "{{ trans('synthesiscms/stats.unique_views_amount') }}",
        ],
    };
    window.stats = {
        diagramLabels: {!! $labelsJson !!},
        diagramValues: {!! $valuesJson !!},
        circleDiagramCount: {!! $circleCount !!},
        circleDiagramLabels: {!! $circleLabelsJson !!},
        circleDiagramValues: {!! $circleValuesJson !!},
    };
</script>

<div class="section col s12 l7">
	<span class="card-panel row col s12 flow-text">
		<span>
			{!! trans('synthesiscms/stats.tooltip_dashboard_time_period_traffic_chart',
			['periodically' => $uniqueVisitsPerTimePeriodChartPeriodWord,
			'start' => $uniqueVisitsPerTimePeriodChartPeriodStartDateHumanString,
			'end' => $uniqueVisitsPerTimePeriodChartPeriodEndDateHumanString]) !!}
			</span>
	</span>
	<canvas id="uniqueVisitsPerTimePeriodChartCanvas" class="col s12"></canvas>
</div>
<div class="section col s12 l5">
	<span class="card-panel row col s12 flow-text">
		<span>
			{!! trans('synthesiscms/stats.tooltip_dashboard_todays_traffic_chart') !!}
		</span>
	</span>
	<div class="col s8 offset-s2 m8 offset-m2 l12">
		<canvas id="todaysTrafficChartCanvas" style="padding: unset !important;" class="col s12"></canvas>
	</div>
</div>
<script>
    function adminStatsGetUniqueColorsWrapper(amount) {
        var ret = [];
        var rgbsArray = SynthesisCmsJsUtils.generateUniqueRgbColorsArray(amount);

        for (var i = 0; i <= (amount - 1); i++) {
            ret.push("rgba(" + rgbsArray[i][0] + "," + rgbsArray[i][1] + "," + rgbsArray[i][2] + ",0.7)");
        }

        return ret;
    }

    var mLineDiagramDatasets = new Array();
    var colorsForLineDiagram = adminStatsGetUniqueColorsWrapper(window.stats.diagramValues.length);
    for (var valueSetArray in window.stats.diagramValues) {
        var dataSet = new Array();
        for (var valueSet in window.stats.diagramValues[valueSetArray]) {
            dataSet.push(window.stats.diagramValues[valueSetArray][valueSet]);
        }
        mLineDiagramDatasets.push({
            label: window.trans.lineDiagram[valueSetArray],
            fill: false,
            backgroundColor: colorsForLineDiagram[valueSetArray],
            borderColor: 'rgba(1,1,1,0.4)',
            data: dataSet,
        });
    }

    var adminChartsUpdateTimer = null;
    var adminChartsIsShowingUpdateToast = false;
    var lastAdminChartsDateTime = "{!! \Carbon\Carbon::now()->toDateTimeString() !!}";
    var uniqueVisitsPerTimePeriodChart;
    var todaysTrafficChart;

    $(document).ready(function () {
        var uniqueVisitsPerTimePeriodChartCanvas = $("#uniqueVisitsPerTimePeriodChartCanvas");
        var todaysTrafficChartCanvas = $("#todaysTrafficChartCanvas");

        uniqueVisitsPerTimePeriodChart = new Chart(uniqueVisitsPerTimePeriodChartCanvas, {
            type: 'line',
            data: {
                labels: window.stats.diagramLabels,
                datasets: mLineDiagramDatasets,
            },
            options: {
                responsive: true,
                tooltips: {
                    mode: 'point'
                }
            }
        });
        todaysTrafficChart = new Chart(todaysTrafficChartCanvas, {
            data: {
                datasets: [{
                    backgroundColor: adminStatsGetUniqueColorsWrapper(window.stats.circleDiagramCount),
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "rgba(2, 98, 82, 1)",
                    pointHoverBackgroundColor: "rgba(3, 139, 116, 1)",
                    pointHoverBorderColor: "rgba(0, 99, 83, 1)",
                    data: window.stats.circleDiagramValues
                }],
                labels: window.stats.circleDiagramLabels
            },
            type: 'doughnut',
            options: {
                responsive: false,
		legend: {
			display: true,
			labels: {
				usePointStyle: true,
			}
		}
            }
        });

        adminChartsUpdateTimer = setInterval(function () {
            $.ajax(
                {
                    url: "{!! route('admin_stats_charts_check_for_updates') !!}",
                    method: "GET",
                    data: {
                        lastDateTime: lastAdminChartsDateTime
                    },
                    success: function (data) {
                        lastAdminChartsDateTime = data.dateTime;
                        if (data.isExpired) {
                            if (!adminChartsIsShowingUpdateToast) {
                                SynthesisCmsJsUtils.showToastWithButton("{!! trans('synthesiscms/stats.toast_stats_data_changed_please_update') !!}", "{!! trans('synthesiscms/stats.btn_toast_stats_data_changed_please_update_ok') !!}", 12000,
                                    function () {
                                        adminChartsIsShowingUpdateToast = false;
                                    }, function () {
                                        feedSynthesiscmsStatsTrackerChartsView(true);
                                    });
                                adminChartsIsShowingUpdateToast = true;
                            }
                        }
                    },
                    error: function () {
                        SynthesisCmsJsUtils.showToast("{!! trans('synthesiscms/stats.toast_error_updating_stats_data', ['seconds' => 12]) !!}", 6000);
                    }
                }
            );
        }, 12000);
    });
    $(window).resize(function () {
        uniqueVisitsPerTimePeriodChart.render(true);
        uniqueVisitsPerTimePeriodChart.resize();
        uniqueVisitsPerTimePeriodChart.draw();
        todaysTrafficChart.render(true);
        todaysTrafficChart.resize();
        todaysTrafficChart.draw();
    });
</script>
