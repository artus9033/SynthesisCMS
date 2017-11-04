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
	<script type="text/javascript" src="{!! asset('js/jquery.optiscroll.js') !!}"></script>
	<link type="text/css" rel="stylesheet" href="{!! asset("css/optiscroll.css") !!}">
	<title>@yield('title')</title>
	@yield('head')
</head>
<body style="overflow-x: hidden">
@yield('body')
</body>
</html>
