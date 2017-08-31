<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/ico" href="{{ url('/favicon.ico') }}"/>
	<!-- Hard-coded theme-color (red), because App functionality may not work when a 500 ISE error happens -->
	<meta name="theme-color" content="#db5945">
	<script type="text/javascript" src="{!! asset('js/jquery-3.1.1.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('js/materialize.js') !!}"></script>
	<link type="text/css" rel="stylesheet" href="{!! asset("fonts/material-icons/material-icons.css") !!}">
	<link type="text/css" rel="stylesheet" href="{!! asset('css/materialize.css') !!}" media="screen,projection"/>
	<title>{!! trans("synthesiscms/errors.cmserr") !!}</title>
	@yield('head')
</head>
<body style="overflow-x: hidden">
<div class="section red lighten-2" style="height: 100vh;">
	<div class="col s12 row">
		<div class="col s12">
			<div class="container">
				<h2 class="white-text">
					<i class="material-icons large prefix center-on-small-only" style="vertical-align: middle;">explore</i>&nbsp;{{ trans('synthesiscms/errors.error_not_installed_cms_yet_header') }}
				</h2>
				<h4 class="light red-text text-lighten-4 center-on-small-only">{!! trans('synthesiscms/errors.error_not_installed_cms_yet') !!}</h4>
			</div>
		</div>
		<div class="col s12 white darken-1 z-depth-3" style="margin-top: 10px;">
			<div class="container col s12 m12 l6" style="margin-top: 40px; margin-bottom: 50px;">
				<p class="flow-text caption">{!! trans('synthesiscms/errors.error_not_installed_cms_yet_help') !!}</p>
				<a href="{!! route('install') !!}" class="btn-large waves-effect waves-light">
					<i class="material-icons white-text left">build</i>&nbsp;{{ trans('synthesiscms/errors.install_link') }}
				</a>
			</div>
			<div class="container col s12 m12 l6 hide-on-small-only" style="margin-top: 40px; margin-bottom: 50px;">
				<div style="background: url('{!! asset('img/synthesiscms-icon.svg') !!}')"></div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
