@extends('layouts.admin')

@section('title')
	{{ trans('synthesiscms/admin.create_route')}}
@endsection

@section('side-nav-active-zero-indexed', 2)

@section('head')
	<style>
		#route-sel .caret {
			color: {{ $synthesiscmsMainColor }} !important;
		}

		#route-sel .select-dropdown {
			border-bottom-color: {{ $synthesiscmsMainColor }} !important;
		}

		label {
			text-align: left !important;
		}
	</style>
@endsection

@section('breadcrumbs')
	<a href="{{ route('admin') }}" class="breadcrumb">{{ trans('synthesiscms/admin.backend') }}</a>
	<a href="{{ route('manage_routes') }}" class="breadcrumb">{{ trans('synthesiscms/admin.manage_routes') }}</a>
	<a class="breadcrumb">{{ trans('synthesiscms/admin.create_route') }}</a>
@endsection

@section('main')
	<div class="row">
		<div class="card-title col s12">
			<h3 class="{{ $synthesiscmsMainColor }}-text valign-wrapper">
				<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text medium valign">create</i>&nbsp;{{ trans('synthesiscms/admin.create_route') }}
			</h3>
		</div>
		<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12"></div>
		<div class="col s12 row"></div>
		<form class="form col s12" role="form" method="POST" action="">
			{{ csrf_field() }}
			<div class="input-field col s12 tooltipped" id="route-div" data-position="top" data-delay="50"
				 data-tooltip="{{ trans('synthesiscms/admin.create_route_slug_tooltip') }}">
				<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">label_outline</i>
				<input id="route" type="text" name="route">
				<label for="route">{{ trans('synthesiscms/admin.create_route_slug_label') }}</label>
			</div>
			<div>
				<div style="display: none;" class="progress" id="route-progress">
					<div class="indeterminate"></div>
				</div>
				<div style="display: none; height: auto;" id="route-status"
					 class="card-panel col s6 offset-s3 green white-text center hoverable">
					<h5 id="route-text" class="center white-text"></h5>
				</div>
			</div>
			<script>
                ajaxRequests = [];
                formValid = false;
                $('#route').bind('input', function () {
                    $('#route-progress').css("display", "inline-block");
                    $('#route-status').css("display", "none");
                    $('input[id=route]').val($('input[id=route]').val().replace("\\", "/"));
                    if (!$('input[id=route]').val().startsWith("/")) {
                        $('input[id=route]').val("/" + $('input[id=route]').val());
                    }
                    $.each(ajaxRequests, function (index, request) {
                        if(request) {
                            request.abort();
                        }
                        ajaxRequests.splice(index, 1);
                    });
                    function process(data) {
                        $('#route-progress').css("display", "none");
                        $("#route-text").html(data['text']);
                        $('#route-status').removeClass();
                        $('#route-status').addClass('card-panel');
                        $('#route-status').addClass('col s12');
                        $('#route-status').addClass(data['color']);
                        $('#route-status').css("display", "inline-block");
                        $('input[id=route]').removeClass('valid');
                        $('input[id=route]').removeClass('invalid');
                        if (data['valid']) {
                            $('input[id=route]').addClass('valid');
                            formValid = true;
                        } else {
                            $('input[id=route]').addClass('invalid');
                            formValid = false;
                        }
                    }

                    function makeAjaxRouteCheck() {
                        ajaxReq = $.ajax({
                            url: "{{ route('synthesis_route_check') }}",
                            type: "post",
                            data: {'route': $('input[id=route]').val().trim(), '_token': $('input[name=_token]').val()},
                            success: function (data) {
                                ajaxRequests.shift();
                                process(data);
                            },
                            error: function (data) {
                                ajaxRequests.shift();
                                if (data['statusText'] == 'Method Not Allowed') {
                                    // Method Not Allowed (error 405) means that the route
                                    // is occupied, but not on the GET method, so we treat
                                    // it as free
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
                        SynthesisCmsJsUtils.showToast({!! json_encode(trans('synthesiscms/admin.msg_create_route_wait_for_end_of_check')) !!}, 3500);
                        e.preventDefault();
                    }
                    if (!formValid) {
                        SynthesisCmsJsUtils.showToast({!! json_encode(trans('synthesiscms/admin.msg_choose_another_route_because_selected_is_occupied')) !!}, 3500);
                        e.preventDefault();
                    }
                });
			</script>
			<div class="input-field col s8 valign" id="route-sel">
				<select id="extension" name="extension" class="{{ $synthesiscmsMainColor }}-text">
					@php
						$synthesiscmsExtensions = view()->shared("synthesiscmsExtensions");
                        foreach ($synthesiscmsExtensions as $extensionPack) {
                            $kernel = $extensionPack[0];
                            $extensionDirname = $extensionPack[1];
							if($kernel->getExtensionType() == App\SynthesisCMS\API\Extensions\SynthesisExtensionType::Module){
								echo("<option value='" . $extensionDirname . "'>" . $kernel->getExtensionName() . "</option>");
							}
						}
					@endphp
				</select>
				<label>{{ trans('synthesiscms/extensions.choose_extension') }}</label>
			</div>
			<button type="submit"
					class="valign col s4 text-center btn btn-large waves-effect waves-light {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}">
				<i class="material-icons white-text right">send</i>{{ trans('synthesiscms/admin.create_route') }}
			</button>
		</form>
	</div>
@endsection
