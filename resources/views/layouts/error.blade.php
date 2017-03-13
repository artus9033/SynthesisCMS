<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#db5945">
     <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
     <link type="text/css" rel="stylesheet" href="{!! asset('css/materialize.css') !!}"  media="screen,projection"/>
	<title>{{ $synthesiscmsHeaderTitle }} - @yield('title')</title>
	@yield('head')
</head>
<body>
	<script type="text/javascript" src="{!! asset('js/jquery-3.1.1.min.js') !!}"></script>
     <script type="text/javascript" src="{!! asset('js/materialize.js') !!}"></script>
	@yield('body')
</body>
</html>
