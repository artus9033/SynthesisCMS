@extends('layouts.admin')

@section('title')
	{{ trans('synthesiscms/admin.settings') }}
@endsection

@section('side-nav-active-zero-indexed', 3)

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
	<a href="{{ route('settings') }}" class="breadcrumb">{{ trans('synthesiscms/admin.settings') }}</a>
@endsection

@section('main')
	<style>
		label {
			text-align: left !important;
		}
	</style>
	<div id="modalDevModeEnableWarning" class="modal">
		<div class="modal-content">
			<h3>{{ trans('synthesiscms/settings.dev_mode_checkbox_warning_modal_title') }}</h3>
			<div class="row col s12">
				<div class="divider red col s10 offset-s1" style="height: 2px;"></div>
			</div>
			<h5>{{ trans('synthesiscms/settings.dev_mode_checkbox_warning_modal_text') }}</h5>
			<h5 class="red-text darken-1">
				<strong>{{ trans('synthesiscms/settings.dev_mode_checkbox_warning_modal_text_2') }}</strong>
			</h5>
			<div class="col s12 divider row red"></div>
			<h5 class="red-text darken-1">
				<strong>{{ trans('synthesiscms/settings.dev_mode_checkbox_warning_modal_text_3') }}</strong>
			</h5>
		</div>
		<div class="modal-footer">
			<a style="margin-right: 9%;" onclick="$('#modalDevModeEnableWarning').modal('close');"
			   class="modal-action modal-close waves-effect waves-green btn-flat right">{{ trans('synthesiscms/settings.dev_mode_checkbox_warning_modal_btn_no') }}</a>
			<a style="margin-left: 9%;"
			   onclick="synthesiscmsSettingsEnableDevModeFromModal();"
			   class="modal-action red white-text modal-close waves-effect waves-light btn-flat left">{{ trans('synthesiscms/settings.dev_mode_checkbox_warning_modal_btn_yes') }}</a>
		</div>
	</div>
	<div>
		<div class="card-content no-padding">
			<div class="card-title col s12 row valign-wrapper">
				<h3 class="{{ $synthesiscmsMainColor }}-text valign-wrapper col s12"><i
							class="material-icons prefix {{ $synthesiscmsMainColor }}-text medium valign">settings</i>&nbsp;{{ trans('synthesiscms/admin.settings') }}
				</h3>
			</div>
			<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12"></div>
			<div class="col s12 row"></div>
			<div>
				<form id="edit" role="form" method="post" action="">
					{{ csrf_field() }}
					<div class="row">
						<div class="col s12">
							<ul style="overflow-x: hidden;" class="tabs z-depth-2">
								<li class="tab">
									<a class="active waves-effect" href="#settings-main">
										<i class="material-icons">format_paint</i>&nbsp;{{ trans('synthesiscms/settings.tab_main') }}
									</a>
								</li>
								<li class="tab">
									<a class="waves-effect" href="#settings-footer-body">
										<i class="material-icons">border_horizontal</i>&nbsp;{{ trans('synthesiscms/settings.tab_footer_body') }}
									</a>
								</li>
								<li class="tab">
									<a class="waves-effect" href="#settings-footer-bottom">
										<i class="material-icons">border_bottom</i>&nbsp;{{ trans('synthesiscms/settings.tab_footer_bottom') }}
									</a>
								</li>
								<li class="tab">
									<a class="waves-effect" href="#settings-colors">
										<i class="material-icons">color_lens</i>&nbsp;{{ trans('synthesiscms/settings.tab_colors') }}
									</a>
								</li>
								<li class="tab">
									<a class="waves-effect" href="#settings-advanced">
										<i class="material-icons">developer_board</i>&nbsp;{{ trans('synthesiscms/settings.tab_advanced') }}
									</a>
								</li>
							</ul>
						</div>
						<div class="row col s12"></div>
						<div id="settings-main" class="col s12">
							<div>
								<div class="input-field col s12">
									<i class="material-icons prefix">title</i>
									<input value="{{ $synthesiscmsHeaderTitle }}" id="header_title" name="header_title"
										   type="text">
									<label for="header_title">{{ trans('synthesiscms/settings.header_title') }}</label>
								</div>
							</div>
							<div>
								<div class="input-field col s12">
									<i class="material-icons prefix">subtitles</i>
									<input value="{{ $synthesiscmsTabTitle }}" id="tab_title" name="tab_title"
										   type="text">
									<label for="tab_title">{{ trans('synthesiscms/settings.tab_title') }}</label>
								</div>
							</div>
							<div>
								<div class="input-field col s12">
									<i class="material-icons prefix">home</i>
									<input value="{{ $synthesiscmsHomePage }}" id="home_page" name="home_page"
										   type="text">
									<label for="home_page">{{ trans('synthesiscms/settings.home_page_button_link') }}</label>
								</div>
							</div>
						</div>
						<div id="settings-footer-body" class="col s12">
							<div>
								<div class="input-field col s12 l6">
									<i class="material-icons prefix">title</i>
									<input value="{{ $synthesiscmsFooterHeader }}" id="footer_header"
										   name="footer_header" type="text">
									<label for="footer_header">{{ trans('synthesiscms/settings.footer_header') }}</label>
								</div>
							</div>
							<div>
								<div class="input-field col s12 l6">
									<i class="material-icons prefix">subtitles</i>
									<input value="{{ $synthesiscmsFooterContent }}" id="footer_content"
										   name="footer_content" type="text">
									<label for="footer_content">{{ trans('synthesiscms/settings.footer_content') }}</label>
								</div>
							</div>
							<div>
								<div class="input-field col s12 l6">
									<i class="material-icons prefix">line_style</i>
									<input value="{{ $synthesiscmsFooterLinksText }}" id="footer_links_text"
										   name="footer_links_text" type="text">
									<label for="footer_links_text">{{ trans('synthesiscms/settings.footer_links_text') }}</label>
								</div>
							</div>
							<div class="row col s12 container">
								<label for="footer_links_content">{{ trans('synthesiscms/settings.footer_links_content') }}</label>
								<textarea class="editor" id="footer_links_content"
										  name="footer_links_content"></textarea>
							</div>
							<style>
								.trumbowyg-editor {
									background-color: grey;
									cursor: default;
								}
							</style>
						</div>
						<div id="settings-footer-bottom" class="col s12">
							<div>
								<div class="input-field col s12 l6">
									<i class="material-icons prefix">copyright</i>
									<input value="{{ $synthesiscmsFooterCopyright }}" id="footer_copyright"
										   name="footer_copyright" type="text">
									<label for="footer_copyright">{{ trans('synthesiscms/settings.footer_copyright') }}</label>
								</div>
							</div>
							<div>
								<div class="input-field col s12 l6">
									<i class="material-icons prefix">title</i>
									<input value="{{ $synthesiscmsFooterMoreLinksBottomText }}"
										   id="footer_more_links_bottom_text" name="footer_more_links_bottom_text"
										   type="text">
									<label for="footer_more_links_bottom_text">{{ trans('synthesiscms/settings.footer_more_links_bottom_text') }}</label>
								</div>
							</div>
							<div>
								<div class="input-field col s12 l6">
									<i class="material-icons prefix">open_in_new</i>
									<input value="{{ $synthesiscmsFooterMoreLinksBottomHref }}"
										   id="footer_more_links_bottom_href" name="footer_more_links_bottom_href"
										   type="text">
									<label for="footer_more_links_bottom_href">{{ trans('synthesiscms/settings.footer_more_links_bottom_href') }}</label>
								</div>
							</div>
						</div>
						<div id="settings-colors" class="col s12">
							<div>
								<div class="input-field col s10">
									<i class="material-icons prefix">format_color_text</i>
									<input value="{{ $synthesiscmsTabColor }}" id="tab_color" name="tab_color"
										   type="text">
									<label for="tab_color">{{ trans('synthesiscms/settings.tab_color') }}</label>
								</div>
								<div class="col s2" style="height: 60px;">
									<div id="tab_color_probe"
										 style="background-color: {{ $synthesiscmsTabColor }}; width: 100%; height: 100%; box-shadow: 0 4px 5px 0 rgba(0, 0, 0, 0.14), 0 1px 10px 0 rgba(0, 0, 0, 0.12), 0 2px 4px -1px rgba(0, 0, 0, 0.3);"></div>
								</div>
								<div class="input-field col s10 tooltipped" data-position="top" data-delay="50"
									 data-tooltip="{{ trans('synthesiscms/settings.tooltip_main_color') }}">
									<i class="material-icons prefix">format_color_fill</i>
									<input value="{{ $synthesiscmsMainColor }}" id="main_color" name="main_color"
										   type="text">
									<label for="main_color">{{ trans('synthesiscms/settings.main_color') }}</label>
								</div>
								<div class="col s2" style="height: 60px;">
									<div class="{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}"
										 id="main_color_probe"
										 style="width: 100%; height: 100%; box-shadow: 0 4px 5px 0 rgba(0, 0, 0, 0.14), 0 1px 10px 0 rgba(0, 0, 0, 0.12), 0 2px 4px -1px rgba(0, 0, 0, 0.3);"></div>
								</div>
								<div class="input-field col s12">
									<i class="material-icons prefix">format_color_fill</i>
									<input value="{{ $synthesiscmsMainColorClass }}" id="main_color_class"
										   name="main_color_class" type="text">
									<label for="main_color_class">{{ trans('synthesiscms/settings.main_color_class') }}</label>
								</div>
								<script>
                                    $('#main_color').bind('input', function () {
                                        $("#main_color_probe").removeClass();
                                        $("#main_color_probe").addClass($(this).val());
                                    });
                                    $('#tab_color').bind('input', function () {
                                        $("#tab_color_probe").css('background-color', $(this).val());
                                    });
								</script>
							</div>
						</div>
						<div id="settings-advanced" class="col s12">
							<div>
								<div class="col s12 tooltipped" data-position="top" data-delay="50"
									 data-tooltip="Zaznacz to pole i w poniższym polu wpisz adres przystanku, jeśli dojeżdżasz autobusem">
									<p class="col s6 offset-s3">
										<input class="filled-in" type="checkbox" id="devModeCheckbox"
											   name="devModeCheckbox">
										<label for="devModeCheckbox" class="teal-text"></label>
									</p>
								</div>
								<script>
                                    var synthesiscmsSettingsCanToggleDevMode = false;
                                    function synthesiscmsSettingsEnableDevModeFromModal() {
                                        $('#modalDevModeEnableWarning').modal('close');
                                        synthesiscmsSettingsCanToggleDevMode = true;
                                        $('#devModeCheckbox').click();
                                        synthesiscmsSettingsCanToggleDevMode = false;
                                    }
                                    $('#devModeCheckbox').click(function (event) {
                                        if (!synthesiscmsSettingsCanToggleDevMode) {
                                            event.preventDefault();
                                            $('#modalDevModeEnableWarning').modal('open');
                                        }
                                    });
                                    $(document).ready(function () {
                                        $('#modalDevModeEnableWarning').modal();
                                    });
								</script>
							</div>
						</div>
					</div>
					<script>
                        $(document).ready(function () {
                            $(".editor").trumbowyg('html', {!! json_encode($synthesiscmsFooterLinksContent) !!});
                        });
					</script>
			</div>
			</form>
		</div>
		<div class="card-action">
			<a onclick="$('#edit').submit()"
			   class="btn-flat waves-effect waves-green {{ $synthesiscmsMainColor }}-text"><i
						class="material-icons {{ $synthesiscmsMainColor }}-text left">save</i>{{ trans('synthesiscms/admin.save_settings') }}
			</a>
			<a class="btn-flat waves-effect waves-yellow {{ $synthesiscmsMainColor }}-text"
			   href="{{ URL::previous() }}"><i
						class="material-icons {{ $synthesiscmsMainColor }}-text left">cancel</i>{{ trans('synthesiscms/admin.cancel_settings') }}
			</a>
		</div>
	</div>
@endsection
