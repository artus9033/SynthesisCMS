@extends('layouts.admin')

@section('title')
	{{ trans('synthesiscms/admin.manage_applets')}}
@endsection

@section('side-nav-active', 'manage_applets')

@section('breadcrumbs')
	<a href="{{ url('/admin') }}" class="breadcrumb">{{ trans('synthesiscms/admin.backend') }}</a>
	<a href="{{ url('/admin/manage_applets') }}" class="breadcrumb">{{ trans('synthesiscms/admin.manage_applets') }}</a>
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
					$firstExt = trans('synthesiscms/admin.msg_no_applets');
					$class = "applet";
					$class2 = " white-text waves-effect waves-" . $synthesiscmsMainColor;
					@endphp
					@if($kernel->getExtensionType() == App\SynthesisCMS\API\SynthesisExtensionType::Applet)
						@php
						if($ct == 0){
							$firstExt = $extension;
							$class .= " white-text waves-effect waves-light " . $synthesiscmsMainColor;
							$class2 = "";
						}
						$ct++;
						@endphp
					<div data-extension="{{ $extension }}" class="card-panel {{ $class }} {{ $class2 }}">{{ $kernel->getExtensionName() }}</div>
					@endif
				@endforeach
				@if ($ct == 0)
					<li class="collection-item"><div class="col s12 center">{{ trans('synthesiscms/admin.no_applets') }}</div></li>
				@endif
			</ul>
			</div>
			<div class="col s9">
				<iframe scrolling="no" onchange="resizeIframeBasedOnContents(this)" onload="resizeIframeBasedOnContents(this)" class="col s12" height="420px" frameBorder="0" id="settings-view" src="{{ url('/admin/manage_applets') }}/{{ $firstExt }}"></iframe>
			</div>
		</div>




















	</div>
@endsection
