<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="shortcut icon" type="image/ico" href="{{ url('/favicon.ico') }}"/>
	<meta name="viewport" content="width=device-width, initial-scale=0.7">
	<meta name="theme-color" content="{{ $synthesiscmsTabColor }}">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<script type="text/javascript" src="{!! asset('js/jquery-3.1.1.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('js/materialize.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('js/app.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('js/clipboard.min.js') !!}"></script>
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
	<link href="{!! asset('css/facebook-likebox-slideout.css') !!}" rel="stylesheet">
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
<div id="like-box">
	<div class="outside">
		<div class="inside">
			<iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fszkola.dla.niepelnosprawnych%2F&tabs=timeline%2C%20events&width=340&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="340" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
		</div>
	</div>
	<div class="belt">Facebook</div>
</div>

<script>
$(document).ready(function() {
	$.ajaxSetup({ cache: true });
	//TODO: add language to script url
	$.getScript('//connect.facebook.net/pl_PL/sdk.js#xfbml=1&version=v2.8', function(){
		FB.init({
			appId: 'TODO', //TODO: add facebook app id
			version: 'v2.7'
		});
		$('#loginbutton,#feedbutton').removeAttr('disabled');
		FB.getLoginStatus(function(){

		});
	});
});
</script>
@yield('body')
<div class="col s12 row" style="margin-bottom: 0px !important; min-height: 61vh;">
	{!! $synthesiscmsPositionManager->getStandard(App\SynthesisCMS\API\Positions\SynthesisPositions::OverMenu, Request::url()) !!}
	<nav class="{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12 z-depth-3">
		<div class="nav-wrapper col s12">
			<div class="left">
				{!! $synthesiscmsPositionManager->getStandard(App\SynthesisCMS\API\Positions\SynthesisPositions::BeforeSiteName, Request::url()) !!}
			</div>
			<a id="synthesiscms-app-logo" class="brand-logo left hide-on-med-and-down" style="z-index: 99999999999999999999999999999999999999999999999999999999999999999 !important; position: relative;">
				<img style="width: auto; height: 50%; border-radius: 50%; background-color: rgba(255, 255, 255, 1); box-shadow: 0 0 8px rgba(255, 255, 255, 0.8); margin-top: 5px;" src="{{ url('/favicon.ico') }}">
			</a>
			<a href="{{ url('/') }}" style="position: relative;" class="brand-logo left">{{ $synthesiscmsHeaderTitle }}</a>
			<div class="input-field right hide-on-med-and-down">
				<select id="lang-select" class="icons white-text" onchange="if(this.selectedIndex !== 'undefined') setLanguage(this.options[this.selectedIndex].value, '{{ url("/") }}');">
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
			<ul class="hide-on-med-and-down">
				@yield('menu')
				{!! $synthesiscmsPositionManager->getStandard(App\SynthesisCMS\API\Positions\SynthesisPositions::OverMenu, Request::url()) !!}
				@if (Auth::guest())
					<li class="right"><a class="center" href="{{ url('/register') }}"><i class="material-icons white-text left">create</i>{!! trans('synthesiscms/menu.register') !!}</a></li>
					<li class="right"><a class="center" href="{{ url('/login') }}"><i class="material-icons white-text left">fingerprint</i>{!! trans('synthesiscms/menu.login') !!}</a></li>
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
					<li class="right" style="min-width: 210px;"><a class="dropdown-button center" href="{{ url('/profile') }}" data-activates="user_dropdown"><i class="material-icons white-text left">account_circle</i>{{ Auth::user()->name }}<i class="material-icons right">arrow_drop_down</i></a></li>
				@endif
				{!! $synthesiscmsPositionManager->getStandard(App\SynthesisCMS\API\Positions\SynthesisPositions::InsideMenu, Request::url()) !!}
			</ul>
		</div>
	</nav>
	{!! $synthesiscmsPositionManager->getStandard(App\SynthesisCMS\API\Positions\SynthesisPositions::BelowMenu, Request::url()) !!}
	{!! $synthesiscmsPositionManager->getStandard(App\SynthesisCMS\API\Positions\SynthesisPositions::OverBreadcrumbs, Request::url()) !!}
	<nav class="{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} lighten-1 col s12 z-depth-2">
		<div class="nav-wrapper col s12">
			<div class="col s12">
				<a href="{{ url('/') }}" class="breadcrumb"><i class="material-icons">home</i>&nbsp;{{ trans('synthesiscms/main.home')}}</a>
				@yield('breadcrumbs')
			</div>
		</div>
	</nav>
	{!! $synthesiscmsPositionManager->getStandard(App\SynthesisCMS\API\Positions\SynthesisPositions::BelowBreadcrumbs, Request::url()) !!}
	<div class="main col s12 row no-padding">
		@if(Session::has('messages'))
			@each('partials/message', Session::get('messages'), 'message')
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
