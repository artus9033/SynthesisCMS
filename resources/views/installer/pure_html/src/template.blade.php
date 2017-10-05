<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#db5945">
	@include("installer/pure_html/src.jquery-js")
	@include("installer/pure_html/src.materialize-js")
	@include("installer/pure_html/src.materialize-css")
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<title>@yield('title')</title>
	@yield('head')
</head>
<body style="overflow-x: hidden">
<div class="section @yield('main-color') lighten-2" style="min-height: 100vh;">
	<div class="col s12 row">
		@yield('main')
	</div>
</div>
</body>
</html>
