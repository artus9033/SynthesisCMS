@extends('installer/pure_html/src.template')

@section('title')
	{!! trans("synthesiscms/errors.error_not_installed_cms_yet") !!}
@endsection

@section('main-color', 'red')

@section('main')
	<div class="col s12">
		<div class="container">
			<h2 class="white-text">
				<i class="material-icons large prefix center-on-small-only" style="vertical-align: middle;">explore</i>&nbsp;{{ trans('synthesiscms/errors.error_not_installed_cms_yet_header') }}
			</h2>
			<h4 class="light red-text text-lighten-4 center-on-small-only">{!! trans('synthesiscms/errors.error_not_installed_cms_yet') !!}</h4>
		</div>
	</div>
	<div class="col s12 white darken-1 z-depth-3" style="margin-top: 10px;">
		<div class="container" style="margin-top: 40px; margin-bottom: 50px;">
			<div class="col s12 m6 l9 row">
				<p class="flow-text caption">{!! trans('synthesiscms/errors.error_not_installed_cms_yet_help') !!}</p>
				<a href="{!! route('install') !!}" class="btn-large waves-effect waves-light">
					<i class="material-icons white-text left">build</i>&nbsp;{{ trans('synthesiscms/errors.install_link') }}
				</a>
			</div>
			<div class="col s12 m6 l3 row">
				{!! file_get_contents(resource_path('assets/logos/dist/synthesiscms-icon.svg')) !!}
			</div>
		</div>
	</div>
@endsection
