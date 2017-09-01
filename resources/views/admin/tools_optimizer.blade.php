@extends('layouts.admin')

@section('title')
	{{ trans('synthesiscms/admin.tool_optimizer') }}
@endsection

@section('side-nav-active-zero-indexed', 4)

@section('head')
	<style>
		.tabs .tab a {
			color: {{ $synthesiscmsMainColor }} !important;
		}

		.tabs ::-webkit-scrollbar:horizontal {
			display: none !important;
		}
	</style>
@endsection

@section('breadcrumbs')
	<a href="{{ route('admin') }}" class="breadcrumb">{{ trans('synthesiscms/admin.backend') }}</a>
	<a href="{{ route('tools_optimizer') }}"
	   class="breadcrumb">{{ trans('synthesiscms/admin.tool_optimizer') }}</a>
@endsection

@section('main')
	<div>
		<div class="card-content no-padding">
			<div class="card-title col s12 row valign-wrapper">
				<h3 class="{{ $synthesiscmsMainColor }}-text valign-wrapper col s12"><i
							class="material-icons prefix {{ $synthesiscmsMainColor }}-text medium valign">memory</i>&nbsp;{{ trans('synthesiscms/admin.tool_optimizer') }}
				</h3>
			</div>
			<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12 row"></div>
			<script>
                var synthesiscmsOptimizerRunning = false;
                function optimizerRunNow() {
                    if (!synthesiscmsOptimizerRunning) {
                        $('#optimizer-working-indicator').show();
                        $('#optimizer-button').addClass('disabled');
                        $.ajax(
                            {
                                url: {!! json_encode(route("tools_optimizer_execute_post")) !!},
                                method: "POST",
                                headers: {
                                    'X-CSRF-TOKEN': SynthesisCmsJsUtils.getCsrfTokenValue()
                                },
                                data: {
                                    execution_permitted: true
                                },
                                success: function (data) {
                                    $('#optimizer-button').removeClass('disabled');
                                    $('#optimizer-working-indicator').hide();
                                    $("#optimizer-output").html("");
                                    data.output.forEach(function (line, index) {
                                        $("#optimizer-output").append("<p>" + line + "</p>");
                                    });
                                    SynthesisCmsJsUtils.showToast("{!! trans('synthesiscms/tools.toast_optimization_finished') !!}", 4000);
                                    synthesiscmsOptimizerRunning = false;
                                },
                                error: function () {
                                    $('#optimizer-button').removeClass('disabled');
                                    $('#optimizer-working-indicator').hide();
                                    SynthesisCmsJsUtils.showToast("{!! trans('synthesiscms/tools.toast_error_trying_to_run_optimizer') !!}", 4000);
                                    synthesiscmsOptimizerRunning = false;
                                }
                            }
                        );
                        synthesiscmsOptimizerRunning = true;
                    }
                }
			</script>
			<div id="optimizer-button" onclick="optimizerRunNow()"
				 class="{{ $synthesiscmsMainColor }} btn btn-large waves-effect waves-light">
				{!! trans('synthesiscms/tools.btn_optimize_now') !!}
			</div>
			<div class="row">
				<div class="col s12 m12 l10 offset-l1">
					<div class="card blue-grey darken-1">
						<div class="card-content white-text">
							<span class="card-title flow-text bold">
								{!! trans('synthesiscms/tools.header_optimizer_log') !!}
							</span>
							<div class="progress col s12">
								<div id="optimizer-working-indicator" style="display: none;"
									 class="indeterminate"></div>
							</div>
							<p class="flow-text" style="text-align: left !important;" id="optimizer-output">
								{!! trans('synthesiscms/tools.info_optimization_may_take_some_time') !!}
							</p>
						</div>
					</div>
				</div>
			</div>
			<div>
			</div>
		</div>
	</div>
@endsection
