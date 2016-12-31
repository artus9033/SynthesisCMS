<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#26a69a">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<script type="text/javascript" src="{!! asset('js/jquery-3.1.1.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('js/materialize.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('js/app.js') !!}"></script>
	<script type="text/javascript">
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	</script>
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="{!! asset('css/materialize.css') !!}"  media="screen,projection"/>
	<link href="{!! asset('css/app.css') !!}" rel="stylesheet">
	<title>TODO - @yield('title')</title>
	@yield('head')
</head>
<body>
	@yield('body')
	<div class="col s12 row">
		<nav class="teal col s12 z-depth-3">
			<div class="nav-wrapper col s12">
				<a href="/" class="brand-logo" style="margin-left: 10px;">{{ config('app.name') }}</a>
				<div class="input-field right">
				<select class="icons white-text" onchange="if(this.selectedIndex !== 'undefined') setLanguage(this.options[this.selectedIndex].value);">
				<option value="EN" data-icon="{!! asset('img/langs/UK.png') !!}" class="left circle">EN</option>
				<option value="PL" data-icon="{!! asset('img/langs/PL.png') !!}" class="left circle">PL</option>
			   </select>
		   </div>
				<ul class="right hide-on-med-and-down">
					@yield('menu')
					@if (Auth::guest())
						<li><a href="{{ url('/login') }}">{!! trans('synthesiscms/menu.login') !!}</a></li>
						<li><a href="{{ url('/register') }}">{!! trans('synthesiscms/menu.register') !!}</a></li>
					@else
						<ul id="user_dropdown" class="dropdown-content">
							<li>
								<a href="{{ url('/profile') }}">{!! trans('synthesiscms/menu.profile') !!}</a>
								<a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{!! trans('synthesiscms/menu.logout') !!}</a>
								<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
									{{ csrf_field() }}
								</form>
							</li>
						</ul>
						<li><a class="dropdown-button" href="/profile" data-activates="user_dropdown">{{ Auth::user()->name }}<i class="material-icons right">arrow_drop_down</i></a></li>
					@endif
				</ul>
			</div>
		</nav>
		<nav class="teal lighten-1 col s12 z-depth-2">
			<div class="nav-wrapper col s12">
				<div class="col s12">
					<a href="/" class="breadcrumb"><i class="material-icons">home</i>&nbsp;{{ trans('synthesiscms/main.home')}}</a>
				   @yield('breadcrumbs')
				 </div>
			</div>
		</nav>
		<div class="main col s12 row center">
			@yield('main')
		</div>
	</div>
</body>
</html>
