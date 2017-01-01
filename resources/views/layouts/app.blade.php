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
				<select id="lang-select" class="icons white-text" onchange="if(this.selectedIndex !== 'undefined') setLanguage(this.options[this.selectedIndex].value);">
				<option value="EN" data-icon="{!! asset('img/langs/UK.png') !!}" class="left circle">EN</option>
				<option value="PL" data-icon="{!! asset('img/langs/PL.png') !!}" class="left circle">PL</option>
			   </select>
		   </div>
		   <script>
		   $('#lang-select').val('@php echo(strtoupper(\App::getLocale()));@endphp');
		   </script>
				<ul class="col s10 right">
					@yield('menu')
					@if (Auth::guest())
						<li class="right col s3 m2 l2"><a class="center" href="{{ url('/register') }}"><i class="material-icons white-text left">create</i>{!! trans('synthesiscms/menu.register') !!}</a></li>
						<li class="right col s3 m2 l2"><a class="center" href="{{ url('/login') }}"><i class="material-icons white-text left">fingerprint</i>{!! trans('synthesiscms/menu.login') !!}</a></li>
					@else
						<ul id="user_dropdown" class="dropdown-content">
							<li>
								@if(Auth::user()->is_admin)
									<a href="{{ url('/admin') }}"><i class="material-icons teal-text left">build</i>{!! trans('synthesiscms/menu.admin') !!}</a>
								@endif
								<a href="{{ url('/profile') }}"><i class="material-icons teal-text left">perm_identity</i>{!! trans('synthesiscms/menu.profile') !!}</a>
								<a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="material-icons teal-text left">power_settings_new</i>{!! trans('synthesiscms/menu.logout') !!}</a>
								<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
									{{ csrf_field() }}
								</form>
							</li>
						</ul>
						<li class="right col s3 m3 l3"><a class="dropdown-button center" href="/profile" data-activates="user_dropdown"><i class="material-icons white-text left">account_circle</i>{{ Auth::user()->name }}<i class="material-icons right">arrow_drop_down</i></a></li>
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
			@if(Session::has('message'))
				@include('partials/message', ['message' => Session::get('message')])
			@endif
		    @each('partials/error', $errors, 'error')
			@yield('main')
		</div>
	</div>
</body>
</html>
