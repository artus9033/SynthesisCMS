<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="{{ $synthesiscmsTabColor }}">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="synthesiscms-dynamic-url-handler-start-tag" content="{!! $synthesiscmsUrlMiddlewareHandlerStartTag !!}">
	<meta name="synthesiscms-dynamic-url-handler-end-tag" content="{!! $synthesiscmsUrlMiddlewareHandlerEndTag !!}">
	<meta name="synthesiscms-public-root" content="{{ url('/') }}">
	<meta name="synthesiscms-asset-root" content="{{ asset('/') }}">
	<script type="text/javascript" src="{!! asset('js/jquery-3.1.1.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('js/materialize.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('js/app.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('js/Chart.js') !!}"></script>
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
	<title>{{ $synthesiscmsHeaderTitle }} - @yield('title')</title>
	@yield('head')
	<style>
		body {
			min-height: 100vh;
		}
	</style>
</head>
<body>
@yield('body')
<div class="col s12">
	@if(Session::has('messages'))
		@each('partials/message', Session::get('messages'), 'message')
		@php(Session::forget('messages'))
	@endif
	@each('partials/error', $errors, 'error')
	@if(Session::has('toasts'))
		@each('partials/toast', Session::get('toasts'), 'toast')
		@php(Session::forget('toasts'))
	@endif
	@yield('main')
</div>
</body>
</html>
