<!DOCTYPE html>
<html lang="{!! App::getLocale() !!}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>{{ $synthesiscmsHeaderTitle }} - @yield('title')</title>
	<link rel="shortcut icon" type="image/ico" href="{{ url('/favicon.ico') }}"/>

	<meta http-equiv="Content-language" content="{!! App::getLocale() !!}">
	<meta name="theme-color" content="{{ $synthesiscmsTabColor }}">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="synthesiscms-dynamic-url-handler-start-tag" content="{!! $synthesiscmsUrlMiddlewareHandlerStartTag !!}">
	<meta name="synthesiscms-dynamic-url-handler-end-tag" content="{!! $synthesiscmsUrlMiddlewareHandlerEndTag !!}">
	<meta name="synthesiscms-public-root" content="{{ url('/') }}">
	<meta name="synthesiscms-asset-root" content="{{ asset('/') }}">

	<script type="text/javascript" src="{!! asset('js/jquery-3.1.1.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('js/materialize.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('js/Chart.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('js/synthesiscms-js-utils.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('js/app.js') !!}"></script>

	<link type="text/css" href="path/to/OverlayScrollbars.css" rel="stylesheet"/>
	<script type="text/javascript" src="path/to/OverlayScrollbars.js"></script>

	<link href="{!! asset('css/app.css') !!}" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="{!! asset("fonts/material-icons/material-icons.css") !!}">
	<link type="text/css" rel="stylesheet" href="{!! asset('css/materialize.css') !!}" media="screen,projection"/>

	@yield('head')

	<style>
		body {
			min-height: 100vh;
		}
	</style>
</head>
<body>
	<scrollbar>
		@yield('body')
		<div class="col s12 row">
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
</scrollbar>
</body>
</html>
