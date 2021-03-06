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
	<div id="modalDevModeEnableWarning" class="modal modal-fixed-footer">
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
										<i class="material-icons">color_lens</i>&nbsp;{{ trans('synthesiscms/settings.tab_appearance') }}
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
							<div class="row"></div>
							<div style="margin-bottom: 15px;" class="col s12 row">
								<span>
									{{ trans('synthesiscms/settings.switch_show_login_register_buttons') }}
								</span>
								<div class="switch col s12">
									<label>
										<input @if($synthesiscmsShowLoginRegisterButtons) checked="checked" @endif name="show_login_register_buttons" type="checkbox">
										<span class="lever"></span>
									</label>
								</div>
							</div>
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
							<div class="row col s12">
								<label for="footer_links_content">{{ trans('synthesiscms/settings.footer_links_content') }}</label>
								<textarea class="editor" id="footer_links_content"
										  name="footer_links_content"></textarea>
							</div>

							<style>
								.trumbowyg-editor {
									cursor: default;
								}
							</style>

							<script>
								$(function(){
									// for footer background preview purposes
									$(".trumbowyg-editor").addClass("{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}");
								});
							</script>
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
								<div class="input-field col s10">
									<i class="material-icons prefix">colorize</i>
									<input value="{{ $synthesiscmsLogoBackgroundColor }}" id="logo_background_color"
										   name="logo_background_color"
										   type="text">
									<label for="logo_background_color">{{ trans('synthesiscms/settings.logo_background_color') }}</label>
								</div>
								<div class="col s2" style="height: 60px;">
									<div id="logo_background_color_probe"
										 style="background-color: {{ $synthesiscmsLogoBackgroundColor }}; width: 100%; height: 100%; box-shadow: 0 4px 5px 0 rgba(0, 0, 0, 0.14), 0 1px 10px 0 rgba(0, 0, 0, 0.12), 0 2px 4px -1px rgba(0, 0, 0, 0.3);"></div>
								</div>
								<div class="col s12 row">
									<span>
										{{ trans('synthesiscms/settings.switch_show_image_big_banner') }}
									</span>
									<div class="switch">
										<label>
											<input @if($synthesiscmsShowImageBigBanner) checked="checked" @endif name="show_image_big_banner" type="checkbox">
											<span class="lever"></span>
										</label>
									</div>
								</div>
								<div class="progress col s12">
									<div id="settings_favicon_upload_loading" style="display: none;"
										 class="indeterminate"></div>
								</div>
								<div class="file-field input-field col s12 row tooltipped" data-position="top"
									 data-delay="50"
									 data-tooltip="{{ trans('synthesiscms/settings.favicon_upload_tooltip') }}">
									<div class="btn col s12 m4 l2{{ $synthesiscmsMainColor }}">
										<i class="material-icons white-text">image</i>
										<input type="file" id="settings_favicon_fileinput">
									</div>
									<div class="row col s12 hide-on-med-and-up"></div>
									<div class="file-path-wrapper hide-on-small-only m8 l10">
										<input class="file-path validate" type="text"
											   placeholder="{{ trans('synthesiscms/settings.favicon_upload') }}">
									</div>
									<a class="btn {{ $synthesiscmsMainColor }} col s12 waves-effect waves-light"
									   onclick="settingsUploadFavicon()">{{ trans('synthesiscms/settings.favicon_upload') }}</a>
								</div>
								<script>
                                    $('#main_color').bind('input', function () {
                                        var mainColorProbe = $("#main_color_probe");
                                        mainColorProbe.removeClass();
                                        mainColorProbe.addClass($(this).val());
                                    });
                                    $('#tab_color').bind('input', function () {
                                        $("#tab_color_probe").css('background-color', $(this).val());
                                    });
                                    $('#logo_background_color').bind('input', function () {
                                        $("#logo_background_color_probe").css('background-color', $(this).val());
                                    });
                                    function settingsUploadFavicon() {
                                        $('#settings_favicon_upload_loading').show();
                                        var formData = new FormData();
                                        formData.append('favicon-file', $("#settings_favicon_fileinput")[0].files[0]);
                                        $.ajax({
                                            url: {!! json_encode(route('settings_favicon_post')) !!},
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                            type: 'POST',
                                            data: formData,
                                            async: true,
                                            cache: false,
                                            contentType: false,
                                            enctype: 'multipart/form-data',
                                            processData: false,
                                            success: function (response) {
                                                $('#settings_favicon_upload_loading').hide();
                                                if (response.success) {
                                                    SynthesisCmsJsUtils.showToast("{{ trans('synthesiscms/settings.toast_favicon_upload_success') }}");
                                                } else {
                                                    SynthesisCmsJsUtils.showToast("{{ trans('synthesiscms/settings.toast_favicon_upload_error') }}" + response.error);
                                                }
                                            },
                                            error: function (response) {
                                                $('#settings_favicon_upload_loading').hide();
                                                SynthesisCmsJsUtils.showToast("{{ trans('synthesiscms/settings.toast_favicon_upload_error') }}" + response.error);
                                            }
                                        });
                                    }
								</script>
							</div>
						</div>
						<div id="settings-advanced" class="col s12">
							<div class="col s12">
								<span>
									{{ trans('synthesiscms/settings.site_enabled') }}
								</span>
								<div class="switch">
									<label>
										<input @if($synthesiscmsSiteEnabled) checked="checked" @endif name="site_enabled" type="checkbox">
										<span class="lever"></span>
									</label>
								</div>
							</div>
							<div style="margin-top: 25px;" class="col s12">
								<span>
									{{ trans('synthesiscms/settings.force_https') }}
								</span>
								<div class="switch">
									<label>
										<input @if($synthesiscmsForceHttps) checked="checked" @endif name="force_https" type="checkbox">
										<span class="lever"></span>
									</label>
								</div>
							</div>
							<div style="margin-top: 25px;" class="col s12">
								<p class="center">
									<label>
										<input class="filled-in" type="checkbox" id="devModeCheckbox"
											name="devModeCheckbox"
											@if(\App\Models\Settings\Settings::getActiveInstance()->isDevModeEnabled()) checked="checked" @endif>
										<span class="grey-text text-darken-3">
											{!! trans('synthesiscms/settings.dev_mode_checkbox_text') !!}
										</span>
									</label>
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
									if ($('#devModeCheckbox').prop("checked")) {
										if (!synthesiscmsSettingsCanToggleDevMode) {
											event.preventDefault();
											$('#modalDevModeEnableWarning').modal('open');
										}
									}
								});
								$(document).ready(function () {
									$('#modalDevModeEnableWarning').modal();
								});
							</script>
						</div>
					</div>
					<script>
                        $(document).ready(function () {
                            $(".editor").trumbowyg('html', {!! json_encode($synthesiscmsFooterLinksContent) !!});
                        });
					</script>
				</form>
			</div>
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
