@extends('installer/pure_html/src.template')

@section('title')
	{!! trans("synthesiscms/errors.error_cms_already_installed") !!}
@endsection

@section('main-color', 'red')

@section('main')
	<div class="col s12">
		<div class="container">
			<h2 class="white-text">
				<i class="material-icons large prefix center-on-small-only" style="vertical-align: middle;">bug_report</i>&nbsp;{{ trans('synthesiscms/errors.generic_header') }}
			</h2>
			<h4 class="light red-text text-lighten-4 center-on-small-only">{!! trans('synthesiscms/errors.error_cms_already_installed') !!}</h4>
		</div>
	</div>
	<div class="col s12 white darken-1 z-depth-3" style="margin-top: 10px;">
		<div class="container" style="margin-top: 40px; margin-bottom: 50px;">
			<div class="col s12 m6 l9">
				<p class="flow-text caption">{!! trans('synthesiscms/errors.error_cms_already_installed_help') !!}</p>
				<a href="{{ url($synthesiscmsHomePage) }}" class="btn-large waves-effect waves-light"><i
							class="material-icons white-text left">home</i>&nbsp;{{ trans('synthesiscms/errors.cmserr_link') }}
				</a>
			</div>
			<div class="col s12 m6 l3 row">
				{!! file_get_contents(resource_path('assets/logos/dist/synthesiscms-icon.svg')) !!}
			</div>
		</div>
	</div>
@endsection
