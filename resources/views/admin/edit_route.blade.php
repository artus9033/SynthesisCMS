@extends('layouts.admin')

@section('title')
	{{ trans('synthesiscms/admin.edit_route', ['route' => $page->slug]) }}
@endsection

@section('side-nav-active-zero-indexed', 2)

@section('breadcrumbs')
	<a href="{{ route('admin') }}" class="breadcrumb">{{ trans('synthesiscms/admin.backend') }}</a>
	<a href="{{ route('manage_routes') }}" class="breadcrumb">{{ trans('synthesiscms/admin.manage_routes') }}</a>
	<a class="breadcrumb">{{ trans('synthesiscms/admin.edit_route', ['route' => $page->slug]) }}</a>
@endsection

@section('main')
	<style>
		label {
			text-align: left !important;
		}
	</style>
	<div id="modalDelete{{ $page->id }}" class="modal">
		<div class="modal-content">
			<h3>{{ trans('synthesiscms/admin.modal_delete_route_header') }}</h3>
			<div class="row col s12">
				<div class="divider red col s10 offset-s1" style="height: 2px;"></div>
			</div>
			<h5>{{ trans('synthesiscms/admin.modal_delete_route_content', ['route' => $page->slug]) }}</h5>
			<h5 class="red-text darken-1">
				<strong>{{ trans('synthesiscms/admin.modal_delete_route_content_2') }}</strong></h5>
		</div>
		<div class="modal-footer">
			<a style="margin-right: 9%;" onclick="$('#modalDelete').modal('close');"
			   class="modal-action modal-close waves-effect waves-green btn-flat right">{{ trans('synthesiscms/admin.modal_delete_route_btn_no') }}</a>
			<a style="margin-left: 9%;" href="{{ route('manage_routes_delete', ['id' => $page->id]) }}"
			   class="modal-action red white-text modal-close waves-effect waves-light btn-flat left">{{ trans('synthesiscms/admin.modal_delete_route_btn_yes') }}</a>
		</div>
	</div>
	<div>
		<div class="card-content no-padding">
			<div class="card-title col s12 row valign-wrapper">
				<h3 class="{{ $synthesiscmsMainColor }}-text valign-wrapper col s8"><i
							class="material-icons prefix {{ $synthesiscmsMainColor }}-text medium valign">create</i>&nbsp;{{ trans('synthesiscms/admin.edit_route', ['route' => $page->slug]) }}
				</h3>
				<div class="col s4 valign row">
					<a class="col s12 btn-large {{ $synthesiscmsMainColor }} waves-effect waves-light"
					   href="{{ url($page->slug) }}" target="_blank"
					   class="btn-large {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} waves-effect waves-light hoverable">
						<i class="material-icons white-text left"
								style="line-height: unset !important; font-size: 1.8rem;">open_in_new</i>{{ trans('synthesiscms/admin.view_route') }}
					</a>
				</div>
			</div>
			<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12"></div>
			<div class="col s12 row"></div>
			<div class="row">
				<form id="edit" role="form" method="post" action="">
					{{ csrf_field() }}
					<div class="card-panel col s8 offset-s2 z-depth-2 center {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text">
						<h5>{{ trans('synthesiscms/extensions.edit_main') }}</h5>
					</div>
					<div class="input-field col s6">
						<input value="{{ $page->slug }}" id="slug" name="slug" type="text">
						<label for="slug">{{ trans('synthesiscms/extensions.slug') }}</label>
					</div>
					<div class="input-field col s6">
						<input value="{{ $page->page_title }}" id="title" name="title" type="text">
						<label for="title">{{ trans('synthesiscms/extensions.title') }}</label>
					</div>
					<div class="col s12 row">
						<div style="display: none;" class="progress" id="slug-progress">
							<div class="indeterminate"></div>
						</div>
						<div style="display: none; height: auto;" id="slug-status"
							 class="card-panel col s6 offset-s3 green white-text center hoverable">
							<h5 id="slug-text" class="center white-text"></h5>
						</div>
					</div>
					<script>
                        ajaxRequests = [];
                        formValid = false;
                        $('#slug').bind('input', function () {
                            $('#slug-progress').css("display", "inline-block");
                            $('#slug-status').css("display", "none");
                            $('input[id=slug]').val($('input[id=slug]').val().replace("\\", "/"));
                            if (!$('input[id=slug]').val().startsWith("/")) {
                                $('input[id=slug]').val("/" + $('input[id=slug]').val());
                            }
                            $.each(ajaxRequests, function (index, request) {
                                request.abort();
                            });
                            function process(data) {
                                $('#slug-progress').css("display", "none");
                                $("#slug-text").html(data['text']);
                                $('#slug-status').removeClass();
                                $('#slug-status').addClass('card-panel');
                                $('#slug-status').addClass('col s12');
                                $('#slug-status').addClass(data['color']);
                                $('#slug-status').css("display", "inline-block");
                                $('input[id=slug]').removeClass('valid');
                                $('input[id=slug]').removeClass('invalid');
                                if (data['valid']) {
                                    $('input[id=slug]').addClass('valid');
                                    formValid = true;
                                } else {
                                    $('input[id=slug]').addClass('invalid');
                                    formValid = false;
                                }
                            }

                            function makeAjaxRouteCheck() {
                                ajaxReq = $.ajax({
                                    url: "{{ route('synthesis_route_check') }}",
                                    type: "post",
                                    data: {
                                        'route': $('input[id=route]').val(),
                                        '_token': $('input[name=_token]').val()
                                    },
                                    success: function (data) {
                                        ajaxRequests.shift();
                                        process(data);
                                    },
                                    error: function (data) {
                                        ajaxRequests.shift();
                                        if (data['statusText'] == 'Method Not Allowed') {
                                            //Method Not Allowed (error 405) means that the route
                                            //is occupied, but not on the GET method, so we treat
                                            //it as free
                                            arr = [];
                                            arr['color'] = "green";
                                            arr['valid'] = true;
                                            arr['text'] = {!! json_encode(trans('synthesiscms/helper.route_free')) !!};
                                            process(arr);
                                        }
                                        var retryDelay = 2000;
                                        if (data['statusText'] != 'abort' && data['statusText'] != 'Method Not Allowed') {
                                            console.warn("SynthesisCMS route availability check error: `" + data + "`. Retrying in " + retryDelay + "ms.");
                                        }
                                        setTimeout(makeAjaxRouteCheck, retryDelay);
                                    }
                                });
                                ajaxRequests.push(ajaxReq);
                            }

                            makeAjaxRouteCheck();
                        });
                        $("form").submit(function (e) {
                            if (ajaxRequests.length > 0) {
                                Materialize.toast({!! json_encode(trans('synthesiscms/admin.msg_create_route_wait_for_end_of_check')) !!}, 3500);
                                e.preventDefault();
                            }
                            if (!formValid) {
                                Materialize.toast({!! json_encode(trans('synthesiscms/admin.msg_choose_another_route_because_selected_is_occupied')) !!}, 3500);
                                e.preventDefault();
                            }
                        });
					</script>
					<div class="row col s12 container">
						<label for="header">{{ trans('synthesiscms/extensions.header') }}</label>
						<textarea class="editor" id="header" name="header"></textarea>
					</div>
					<script>
                        $(document).ready(function () {
                            $(".editor").trumbowyg('html', {!! json_encode($page->page_header) !!});
                        });
					</script>
					<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12 row"></div>
					<div class="card-panel col s8 offset-s2 z-depth-2 center {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text row">
						<h5>{{ trans('synthesiscms/extensions.edit_specific') }}</h5>
					</div>
					{!! \App::make('App\Extensions\\'.$page->extension.'\ExtensionKernel')->editGet($page) !!}
				</form>
			</div>
		</div>
		<div class="card-action">
			<a onclick="$('#edit').submit()"
			   class="btn-flat waves-effect waves-green {{ $synthesiscmsMainColor }}-text"><i
						class="material-icons {{ $synthesiscmsMainColor }}-text left">save</i>{{ trans('synthesiscms/admin.save_route') }}
			</a>
			<a class="btn-flat waves-effect waves-yellow {{ $synthesiscmsMainColor }}-text"
			   href="{{ route('manage_routes') }}"><i
						class="material-icons {{ $synthesiscmsMainColor }}-text left">cancel</i>{{ trans('synthesiscms/admin.cancel_route') }}
			</a>
			<button class="btn-flat waves-effect waves-red {{ $synthesiscmsMainColor }}-text"
					onclick="$('#modalDelete{{ $page->id }}').modal('open');"><i
						class="material-icons {{ $synthesiscmsMainColor }}-text left">security</i>{{ trans('synthesiscms/admin.delete_route') }}
			</button>
		</div>
	</div>
	<script type="text/javascript">
        $(document).ready(function () {
            $('.modal').modal({
                dismissible: false
            });
            $('#slug').trigger(jQuery.Event('input'));
        });
	</script>
@endsection
