<!DOCTYPE html>
<html lang="{!! App::getLocale() !!}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="shortcut icon" type="image/ico" href="{{ url('/favicon.ico') }}"/>
	<meta http-equiv="Content-language" content="{!! App::getLocale() !!}">
	<meta name="viewport" content="width=device-width, initial-scale=0.7">
	<meta name="theme-color" content="{{ $synthesiscmsTabColor }}">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="synthesiscms-dynamic-url-handler-start-tag" content="{!! $synthesiscmsUrlMiddlewareHandlerStartTag !!}">
	<meta name="synthesiscms-dynamic-url-handler-end-tag" content="{!! $synthesiscmsUrlMiddlewareHandlerEndTag !!}">
	<meta name="synthesiscms-public-root" content="{{ url('/') }}">
	<meta name="synthesiscms-asset-root" content="{{ asset('/') }}">
	<script type="text/javascript" src="{!! asset('js/jquery-3.1.1.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('js/materialize.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('js/app.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('js/clipboard.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('js/synthesiscms-js-utils.js') !!}"></script>
	<script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
	</script>
	<link type="text/css" rel="stylesheet" href="{!! asset("fonts/material-icons/material-icons.css") !!}">
	<link type="text/css" rel="stylesheet" href="{!! asset('css/materialize.css') !!}" media="screen,projection"/>
	<link href="{!! asset('css/app.css') !!}" rel="stylesheet">
	<title>SynthesisCMS - {!! trans('synthesiscms/installer.installation_tab_title') !!}</title>
	@yield('head')
	<style>
		body {
			min-height: 100vh;
		}
	</style>
</head>
<body style="overflow-x: hidden">
@yield('body')
<div class="col s12 row" style="margin-bottom: 0px !important; min-height: 61vh;">
	<nav class="{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12 no-padding z-depth-3">
		<div class="nav-wrapper col s12 no-padding">
		</div>
	</nav>
	<div class="main col s12 row no-padding">
		@if(Session::has('messages'))
			@each('partials/message', Session::get('messages'), 'message')
			@php(Session::forget('messages'))
		@endif
		@if(Session::has('warnings'))
			@each('partials/warning', Session::get('warnings'), 'warning')
			@php(Session::forget('warnings'))
		@endif
		@each('partials/error', $errors, 'error')
		@if(Session::has('toasts'))
			@each('partials/toast', Session::get('toasts'), 'toast')
			@php(Session::forget('toasts'))
		@endif
		@yield('main')
	</div>
</div>
</body>
</html>
