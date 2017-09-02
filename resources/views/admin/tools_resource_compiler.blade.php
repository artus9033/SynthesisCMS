@extends('layouts.admin')

@section('title')
	{{ trans('synthesiscms/admin.tool_resources_compiler') }}
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
	<a href="{{ route('tools_resources_compiler') }}"
	   class="breadcrumb">{{ trans('synthesiscms/admin.tool_resources_compiler') }}</a>
@endsection

@section('main')
	<div>
		<div class="card-content no-padding">
			<div class="card-title col s12 row valign-wrapper">
				<h3 class="{{ $synthesiscmsMainColor }}-text valign-wrapper col s12"><i
							class="material-icons prefix {{ $synthesiscmsMainColor }}-text medium valign">brush</i>&nbsp;{{ trans('synthesiscms/admin.tool_resources_compiler') }}
				</h3>
			</div>
			<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12 row"></div>
			<script>
                var synthesiscmsResourcesCompilerRunning = false;
                function compilerRunNow(targetFunctionUrl) {
                    if (!synthesiscmsResourcesCompilerRunning) {
                        $('#compiler-working-indicator').show();
                        $('#compiler-button').addClass('disabled');
                        $('#compiler-node-sass-button').addClass('disabled');
                        $('#compiler-npm-install-button').addClass('disabled');
                        $('#compiler-delete-node-modules-button').addClass('disabled');
                        $.ajax(
                            {
                                url: targetFunctionUrl,
                                method: "POST",
                                headers: {
                                    'X-CSRF-TOKEN': SynthesisCmsJsUtils.getCsrfTokenValue()
                                },
                                data: {
                                    execution_permitted: true
                                },
                                success: function (data) {
                                    $('#compiler-button').removeClass('disabled');
                                    $('#compiler-node-sass-button').removeClass('disabled');
                                    $('#compiler-npm-install-button').removeClass('disabled');
                                    $('#compiler-delete-node-modules-button').removeClass('disabled');
                                    $('#compiler-working-indicator').hide();
                                    $("#compiler-output").html("");
                                    data.output.forEach(function (line, index) {
                                        $("#compiler-output").append("<p>" + line + "</p>");
                                    });
                                    SynthesisCmsJsUtils.showToast("{!! trans('synthesiscms/tools.toast_compilation_finished') !!}", 4000);
                                    synthesiscmsResourcesCompilerRunning = false;
                                },
                                error: function () {
                                    $('#compiler-button').removeClass('disabled');
                                    $('#compiler-node-sass-button').removeClass('disabled');
                                    $('#compiler-npm-install-button').removeClass('disabled');
                                    $('#compiler-delete-node-modules-button').removeClass('disabled');
                                    $('#compiler-working-indicator').hide();
                                    SynthesisCmsJsUtils.showToast("{!! trans('synthesiscms/tools.toast_error_trying_to_run_compiler') !!}", 4000);
                                    synthesiscmsResourcesCompilerRunning = false;
                                }
                            }
                        );
                        synthesiscmsResourcesCompilerRunning = true;
                    }
                }
			</script>
			<div id="compiler-button" onclick="compilerRunNow('{!! route("tools_resources_compiler_execute_post") !!}')"
				 class="{{ $synthesiscmsMainColor }} btn btn-large waves-effect waves-light row">
				{!! trans('synthesiscms/tools.btn_compile_now') !!}
			</div>
			<div id="compiler-node-sass-button" onclick="compilerRunNow('{!! route("tools_resources_compiler_rebuild_node_sass_post") !!}')"
				 class="{{ $synthesiscmsMainColor }} btn btn-large waves-effect waves-light tooltipped row" data-position="top" data-delay="50" data-tooltip="{!! trans('synthesiscms/tools.tooltip_btn_rebuild_node_sass_now') !!}">
				{!! trans('synthesiscms/tools.btn_rebuild_node_sass_now') !!}
			</div>
			<div id="compiler-npm-install-button" onclick="compilerRunNow('{!! route("tools_resources_compiler_npm_install_post") !!}')"
				 class="{{ $synthesiscmsMainColor }} btn btn-large waves-effect waves-light tooltipped row" data-position="top" data-delay="50" data-tooltip="{!! trans('synthesiscms/tools.tooltip_btn_npm_install') !!}">
				{!! trans('synthesiscms/tools.btn_npm_install_now') !!}
			</div>
			<div id="compiler-delete-node-modules-button" onclick="compilerRunNow('{!! route("tools_resources_compiler_node_modules_delete_post") !!}')"
				 class="{{ $synthesiscmsMainColor }} btn btn-large waves-effect waves-light tooltipped row" data-position="top" data-delay="50" data-tooltip="{!! trans('synthesiscms/tools.tooltip_btn_delete_node_modules_now') !!}">
				{!! trans('synthesiscms/tools.btn_delete_node_modules_now') !!}
			</div>
			<div class="row">
				<div class="col s12 m12 l10 offset-l1">
					<div class="card blue-grey darken-1">
						<div class="card-content white-text">
							<span class="card-title flow-text bold">
								{!! trans('synthesiscms/tools.header_compiler_log') !!}
							</span>
							<div class="progress col s12">
								<div id="compiler-working-indicator" style="display: none;"
									 class="indeterminate"></div>
							</div>
							<p class="flow-text" style="text-align: left !important;" id="compiler-output">
								{!! trans('synthesiscms/tools.info_compilation_may_take_some_time') !!}
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
