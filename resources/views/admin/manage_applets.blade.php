@extends('layouts.admin')

@section('title')
	{{ trans('synthesiscms/admin.manage_applets')}}
@endsection

@section('side-nav-active', 'manage_applets')

@section('breadcrumbs')
	<a href="{{ url('/admin') }}" class="breadcrumb">{{ trans('synthesiscms/admin.backend') }}</a>
	<a href="{{ url('/admin/manage_applets') }}" class="breadcrumb">{{ trans('synthesiscms/admin.manage_applets') }}</a>
@endsection

@section('head')
	<script>
	function loadIframeContents(extension, newItem){
		var activeItem = $(".active-applet");
		if(!$(newItem).hasClass("active-applet")){
			$(newItem).addClass("white-text");
			$(newItem).addClass("active-applet");
			$(newItem).addClass({!! json_encode(" active-applet white-text waves-effect waves-light " . $synthesiscmsMainColor) !!});
			activeItem.removeClass("active-applet");
			activeItem.removeClass("white-text");
			activeItem.removeClass({!! json_encode($synthesiscmsMainColor) !!});
			activeItem.addClass({!! json_encode(" " . $synthesiscmsMainColor . "-text waves-effect waves-" . $synthesiscmsMainColor) !!})
		}
		$('#loader-div').css('display', 'inline-block');
		$('#settings-view').attr('src', "{{ url('/admin/manage_applets') }}/" + extension);
	}
	</script>
@endsection

@section('main')
	<div>
		<div class="card-content">
			<div class="card-title col s12">
				<h3 class="{{ $synthesiscmsMainColor }}-text valign-wrapper"><i class="material-icons prefix {{ $synthesiscmsMainColor }}-text medium valign">extension</i>&nbsp;{{ trans('synthesiscms/admin.manage_applets') }}</h3>
			</div>
			<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12"></div>
			<div class="col s12 row"></div>
			<div class="col s3">
				<ul class="collection with-header">
					<li class="collection-header teal-text">
						<h4>
							{{ trans('synthesiscms/admin.applets') }}
						</h4>
					</li>
					@php
					$ct = 0;
					$extensions = config("synthesiscmsextensions.extensions");
					@endphp
					@foreach ($extensions as $extension)
						@php
						$kpath = 'App\\Extensions\\' . $extension . '\\ExtensionKernel';
						$kernel = new $kpath;
						$class = "applet";
						$class2 = " " . $synthesiscmsMainColor . "-text waves-effect waves-" . $synthesiscmsMainColor;
						@endphp
						@if($kernel->getExtensionType() == App\SynthesisCMS\API\SynthesisExtensionType::Applet)
							@php
							if($ct == 0){
								$firstExt = $extension;
								$class .= " active-applet white-text waves-effect waves-light " . $synthesiscmsMainColor;
								$class2 = "";
							}
							$ct++;
							@endphp
							<div onclick="loadIframeContents('{{ $extension }}', this);" class="card-panel {{ $class }} {{ $class2 }}">{{ $kernel->getExtensionName() }}</div>
						@endif
					@endforeach
					@if ($ct == 0)
						<li class="collection-item"><div class="col s12 center">{{ trans('synthesiscms/admin.msg_no_applets') }}</div></li>
					@endif
				</ul>
			</div>
			<div class="col s9">
				@if(isset($firstExt))
					<div class="progress">
						<div id="loader-div" class="indeterminate"></div>
					</div>
					<iframe onchange="this.style.height = 3 * this.contentWindow.document.body.scrollHeight + 'px'" onload="resizeIframeBasedOnContents(this); $('#loader-div').css('display', 'none');" class="col s12" height="900px" frameBorder="0" id="settings-view" src="{{ url('/admin/manage_applets') }}/{{ $firstExt }}"></iframe>
				@else
					@include('partials/error', ['error' => trans('synthesiscms/admin.msg_no_applets')])
				@endif
			</div>
		</div>




















	</div>
@endsection
