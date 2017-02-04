<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="{{ $synthesiscmsTabColor }}">
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
	<title>{{ $synthesiscmsHeaderTitle }} - @yield('title')</title>
	@yield('head')
	<style>
	body {
		min-height: 100vh;
	}
	</style>
</head>
<header>
	@yield('header')
</header>
<body>
	@yield('body')
	<div class="col s12 row" style="margin-bottom: 0px !important; min-height: 61vh;">
		{!! $synthesiscmsPositionManager->getStandard(App\SynthesisCMS\API\Positions\SynthesisPositions::OverMenu, Request::url()) !!}
		<nav class="{{ $synthesiscmsMainColor }} col s12 z-depth-3">
			<div class="nav-wrapper col s12">
				<div class="left">
					{!! $synthesiscmsPositionManager->getStandard(App\SynthesisCMS\API\Positions\SynthesisPositions::BeforeSiteName, Request::url()) !!}
				</div>
				<a href="/" class="brand-logo" style="margin-left: 10px;">{{ $synthesiscmsHeaderTitle }}</a>
					<div class="input-field right">
						<select id="lang-select" class="icons white-text" onchange="if(this.selectedIndex !== 'undefined') setLanguage(this.options[this.selectedIndex].value);">
							<option value="EN" data-icon="{!! asset('img/langs/UK.png') !!}" class="{{ $synthesiscmsMainColor }}-text left circle"><span class="{{ $synthesiscmsMainColor }}-text">EN</span></option>
							<option value="PL" data-icon="{!! asset('img/langs/PL.png') !!}" class="{{ $synthesiscmsMainColor }}-text left circle"><span class="{{ $synthesiscmsMainColor }}-text">PL</span></option>
						</select>
					</div>
					@php
					$app_locale = strtoupper(\App::getLocale());
					@endphp
					<script>
					$('#lang-select').val('{{ $app_locale }}');
					</script>
					<ul class="col s10 right">
						@yield('menu')
						{!! $synthesiscmsPositionManager->getStandard(App\SynthesisCMS\API\Positions\SynthesisPositions::OverMenu, Request::url()) !!}
						@if (Auth::guest())
							<li class="right col s3 m2 l2"><a class="center" href="{{ url('/register') }}"><i class="material-icons white-text left">create</i>{!! trans('synthesiscms/menu.register') !!}</a></li>
							<li class="right col s3 m2 l2"><a class="center" href="{{ url('/login') }}"><i class="material-icons white-text left">fingerprint</i>{!! trans('synthesiscms/menu.login') !!}</a></li>
						@else
							<ul id="user_dropdown" class="dropdown-content">
								<li>
									@if(Auth::user()->is_admin)
										<a class="{{ $synthesiscmsMainColor }}-text" href="{{ url('/admin') }}"><i class="material-icons {{ $synthesiscmsMainColor }}-text left">build</i>{!! trans('synthesiscms/menu.admin') !!}</a>
									@endif
									<a class="{{ $synthesiscmsMainColor }}-text" href="{{ url('/profile') }}"><i class="material-icons {{ $synthesiscmsMainColor }}-text left">perm_identity</i>{!! trans('synthesiscms/menu.profile') !!}</a>
									<a class="{{ $synthesiscmsMainColor }}-text" href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="material-icons {{ $synthesiscmsMainColor }}-text left">power_settings_new</i>{!! trans('synthesiscms/menu.logout') !!}</a>
									<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
										{{ csrf_field() }}
									</form>
								</li>
							</ul>
							<li class="right" style="min-width: 210px;"><a class="dropdown-button center" href="/profile" data-activates="user_dropdown"><i class="material-icons white-text left">account_circle</i>{{ Auth::user()->name }}<i class="material-icons right">arrow_drop_down</i></a></li>
						@endif
					</ul>
				</div>
			</nav>
			{!! $synthesiscmsPositionManager->getStandard(App\SynthesisCMS\API\Positions\SynthesisPositions::BelowMenu, Request::url()) !!}
			{!! $synthesiscmsPositionManager->getStandard(App\SynthesisCMS\API\Positions\SynthesisPositions::OverBreadcrumbs, Request::url()) !!}
			<nav class="{{ $synthesiscmsMainColor }} lighten-1 col s12 z-depth-2">
				<div class="nav-wrapper col s12">
					<div class="col s12">
						<a href="/" class="breadcrumb"><i class="material-icons">home</i>&nbsp;{{ trans('synthesiscms/main.home')}}</a>
						@yield('breadcrumbs')
					</div>
				</div>
			</nav>
			{!! $synthesiscmsPositionManager->getStandard(App\SynthesisCMS\API\Positions\SynthesisPositions::BelowBreadcrumbs, Request::url()) !!}
			<div class="main col s12 row">
				@if(Session::has('message'))
					@include('partials/message', ['message' => Session::get('message')])
				@endif
				@each('partials/error', $errors, 'error')
				@if(Session::has('toasts'))
					@each('partials/toast', Session::get('toasts'), 'toast')
				@endif
				{!! $synthesiscmsPositionManager->getStandard(App\SynthesisCMS\API\Positions\SynthesisPositions::OverContent, Request::url()) !!}
				@yield('main')
				{!! $synthesiscmsPositionManager->getStandard(App\SynthesisCMS\API\Positions\SynthesisPositions::BelowContent, Request::url()) !!}
			</div>
		</div>
		@include('partials/footer')
		{!! $synthesiscmsPositionManager->getStandard(App\SynthesisCMS\API\Positions\SynthesisPositions::BelowFooter, Request::url()) !!}
	</body>
	</html>
