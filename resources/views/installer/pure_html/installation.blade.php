@extends('installer/pure_html/src.template')

@section('title')
	{!! trans("synthesiscms/installer.title") !!}
@endsection

@section('main-color', 'teal')

@section('main')
	<div class="col s12 m12 l9">
		<div style="margin-left: 8rem;" class="hide-on-med-and-down">
			<h2 class="white-text">
				<i class="material-icons large prefix center-on-small-only" style="vertical-align: middle;">explore</i>&nbsp;{{ trans('synthesiscms/installer.title') }}
			</h2>
			<h4 class="light teal-text text-lighten-4 center-on-small-only">{!! trans('synthesiscms/installer.title_desc') !!}</h4>
		</div>
		<div class="hide-on-large-only">
			<h2 class="white-text">
				<i class="material-icons large prefix center-on-small-only" style="vertical-align: middle;">explore</i>&nbsp;{{ trans('synthesiscms/installer.title') }}
			</h2>
			<h4 class="light teal-text text-lighten-4 center-on-small-only">{!! trans('synthesiscms/installer.title_desc') !!}</h4>
		</div>
	</div>
	<div class="col s12 m6 l3 hide-on-med-and-down">
		{!! file_get_contents(resource_path('assets/logos/dist/synthesiscms-logo.svg')) !!}
	</div>
	<div class="col s12 white darken-1 z-depth-3" style="margin-top: 10px;">
		<div class="container" style="margin-top: 40px; margin-bottom: 50px;">
			<div class="col s12 m6 l7">
				<p class="flow-text caption">{!! trans('synthesiscms/errors.error_not_installed_cms_yet_help') !!}</p>
				<a href="{!! route('install') !!}" class="btn-large waves-effect waves-light">
					<i class="material-icons white-text left">build</i>&nbsp;{{ trans('synthesiscms/errors.install_link') }}
				</a>
			</div>
		</div>
	</div>
@endsection
