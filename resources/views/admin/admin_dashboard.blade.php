@extends('layouts.admin')

@section('title')
	{{ trans('synthesiscms/admin.backend')}}
@endsection

@section('head')
	<style>
		#timeUnitWrapper .caret {
			color: {{ $synthesiscmsMainColor }}  !important;
		}

		#timeUnitWrapper .select-dropdown {
			border-bottom-color: {{ $synthesiscmsMainColor }}  !important;
		}
	</style>
@endsection

@section('breadcrumbs')
	<a href="{{ route('admin') }}" class="breadcrumb">{{ trans('synthesiscms/admin.backend') }}</a>
@endsection

@php
	use \Carbon\Carbon;

	$dateFormattedStart = new DateTime(Carbon::now()->subMonths(2)->toDateString());
	$dateFormattedEnd = new DateTime(Carbon::now()->addMonths(2)->toDateString());
@endphp

@section('main')
	<div class="container col s12 row" id="admin-dashboard-container">
		<div>
			<div class="card-content no-padding">
				<div class="card-title center">
					<h4 class="card-panel {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text">
						<i class="material-icons white-text medium left valign" style="line-height: unset !important;">trending_up</i>
						{{ trans('synthesiscms/admin.stats') }}
					</h4>
				</div>
				<div class="row col s12"></div>
				<div class="col s12 row">
					<div class="input-field col s12 m6 l4">
						<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">date_range</i>
						<input class="datepicker" id="timePeriodStart" type="text"
							   value="{{ $dateFormattedStart->format('d F, Y') }}">
						<label for="timePeriodStart">{{ trans('synthesiscms/stats.label_time_period_start_select') }}</label>
					</div>
					<div class="input-field col s12 m6 l4">
						<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">date_range</i>
						<input class="datepicker" id="timePeriodEnd" type="text"
							   value="{{ $dateFormattedEnd->format('d F, Y') }}">
						<label for="timePeriodEnd">{{ trans('synthesiscms/stats.label_time_period_end_select') }}</label>
					</div>
					<div class="input-field col col s12 m12 l4" id="timeUnitWrapper">
						<select id="timeUnit" onchange="feedSynthesiscmsStatsTrackerChartsView(true);">
							<option value="day">{{ ucfirst(trans('synthesiscms/stats.single_word_day')) }}</option>
							<option value="week"
									selected>{{ ucfirst(trans('synthesiscms/stats.single_word_week')) }}</option>
							<option value="month">{{ ucfirst(trans('synthesiscms/stats.single_word_month')) }}</option>
							<option value="year">{{ ucfirst(trans('synthesiscms/stats.single_word_year')) }}</option>
						</select>
						<label>{{ trans('synthesiscms/stats.label_time_period_unit_select') }}</label>
					</div>
				</div>
				<div style="display: none;" id="preloader">
					<div class="preloader-wrapper @if($synthesiscmsClientIsPhone) small @elseif($synthesiscmsClientIsTablet) medium @else big @endif active">
						<div class="spinner-layer spinner-blue">
							<div class="circle-clipper left">
								<div class="circle"></div>
							</div>
							<div class="gap-patch">
								<div class="circle"></div>
							</div>
							<div class="circle-clipper right">
								<div class="circle"></div>
							</div>
						</div>

						<div class="spinner-layer spinner-red">
							<div class="circle-clipper left">
								<div class="circle"></div>
							</div>
							<div class="gap-patch">
								<div class="circle"></div>
							</div>
							<div class="circle-clipper right">
								<div class="circle"></div>
							</div>
						</div>

						<div class="spinner-layer spinner-yellow">
							<div class="circle-clipper left">
								<div class="circle"></div>
							</div>
							<div class="gap-patch">
								<div class="circle"></div>
							</div>
							<div class="circle-clipper right">
								<div class="circle"></div>
							</div>
						</div>

						<div class="spinner-layer spinner-green">
							<div class="circle-clipper left">
								<div class="circle"></div>
							</div>
							<div class="gap-patch">
								<div class="circle"></div>
							</div>
							<div class="circle-clipper right">
								<div class="circle"></div>
							</div>
						</div>
					</div>
				</div>
				<div id="synthesiscms-stats-tracker-view"></div>
				<script>
                    $('#synthesiscms-stats-tracker-view').html($('#preloader').html());
                    function feedSynthesiscmsStatsTrackerChartsView(bShowPreloader = true) {
                        if (bShowPreloader) {
                            $('#synthesiscms-stats-tracker-view').html($('#preloader').html());
                            $('#todaysTrafficChartCanvas').height($('#todaysTrafficChartCanvas').width());
                        }
                        var timePeriodStart = $('#timePeriodStart').val();
                        var timePeriodEnd = $('#timePeriodEnd').val();
                        var timeUnit = $('#timeUnit').val();
                        var routeParams = {
                            timePeriodStart: timePeriodStart,
                            timePeriodEnd: timePeriodEnd,
                            timeUnit: timeUnit
                        }
                        $.get("{!! route('admin_stats_charts') !!}", routeParams).done(function (data) {
                            $('#synthesiscms-stats-tracker-view').html(data);
                        }).fail(function () {
                            SynthesisCmsJsUtils.showToast("{!! trans('synthesiscms/stats.toast_error_loading_stats_retrying_in', ['seconds' => '5']) !!}", 5000);
                            setTimeout(function () {
                                feedSynthesiscmsStatsTrackerChartsView(true);
                            }, 5000);
                        });
                    }
                    $(document).ready(function () {
                        $('#timePeriodStart').pickadate({
                            onClose: function () {
                                feedSynthesiscmsStatsTrackerChartsView(true);
                            },
                            selectMonths: true,
                            selectYears: 100,
                            today: "{{ trans('synthesiscms/stats.btn_date_picker_today') }}",
                            clear: "",
                            close: "{{ trans('synthesiscms/stats.btn_date_picker_ok') }}",
                            closeOnSelect: false,
                        });
                        $('#timePeriodEnd').pickadate({
                            onClose: function () {
                                feedSynthesiscmsStatsTrackerChartsView(true);
                            },
                            selectMonths: true,
                            selectYears: 100,
                            today: "{{ trans('synthesiscms/stats.btn_date_picker_today') }}",
                            clear: "",
                            close: "{{ trans('synthesiscms/stats.btn_date_picker_ok') }}",
                            closeOnSelect: false,
                        });
                        feedSynthesiscmsStatsTrackerChartsView(false);
                    });
				</script>
			</div>
		</div>
	</div>
@endsection
