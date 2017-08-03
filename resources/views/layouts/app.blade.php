<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="shortcut icon" type="image/ico" href="{{ url('/favicon.ico') }}"/>
	<meta name="viewport" content="width=device-width, initial-scale=0.7">
	<meta name="theme-color" content="{{ $synthesiscmsTabColor }}">
	<meta name="csrf-token" content="{{ csrf_token() }}">
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
	<nav class="{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12 no-padding z-depth-3">
		<div class="nav-wrapper col s12 no-padding">
			<div class="left synthesiscms-mobile-btn-wrapper">
				{!! $synthesiscmsPositionManager->getStandard(App\SynthesisCMS\API\Positions\SynthesisPositions::BeforeSiteName, Request::url()) !!}
			</div>
			<a id="synthesiscms-app-logo" class="brand-logo left hide-on-med-and-down" style="position: relative; background-color: rgb(255, 255, 255); box-shadow: rgba(255, 255, 255, 0.8) 0px 0px 8px; border-bottom-right-radius: 2.3em; z-index: 2147483647 !important; height: 220%; width: 125px;">
				<img style="width: 85%; height: auto; margin-top: 10%; margin-left: 2%;" src="{{ url('/favicon.ico') }}">
			</a>
			<a href="{{ url('/') }}" style="margin-left: 25px; font-size: 2em !important;" class="hide-on-med-and-down brand-logo truncate col s7">{{ $synthesiscmsHeaderTitle }}</a>
			<a id="synthesiscms-slogan-large-screens" href="{{ url('/') }}" style="width:100%;"
			   class="hide-on-large-only brand-logo truncate synthesiscms-mobile-brand-logo">{{ $synthesiscmsHeaderTitle }}</a>
			<script>
                function synthesiscmsResizeBrandLogoMargin() {
                    $(".synthesiscms-mobile-brand-logo").css('margin-left', $('.synthesiscms-mobile-btn-wrapper').width() + 2); // 2 more pixels
                    $("#synthesiscms-slogan-large-screens").css('max-width', $(document).width() - $('#synthesiscms-large-screens-menu-part-right').width());
                }
                $(document).ready(function () {
                    synthesiscmsResizeBrandLogoMargin();
                });
                $(window).resize(function () {
                    synthesiscmsResizeBrandLogoMargin();
                });
			</script>
			@php
			$app_locale = strtoupper(\App::getLocale());
			@endphp
			<ul class="hide-on-med-and-down right" id="synthesiscms-large-screens-menu-part-right">
				<li class="input-field right hide-on-med-and-down">
					<select id="lang-select" class="icons white-text"
							onchange="if(this.selectedIndex !== 'undefined') setLanguage(this.options[this.selectedIndex].value, '{{ url("/") }}');">
						<option value="EN" data-icon="{!! asset('img/langs/UK.png') !!}"
								class="{{ $synthesiscmsMainColor }}-text left circle"
								@if(mb_strtoupper($app_locale) == "EN") selected @endif><span
									class="{{ $synthesiscmsMainColor }}-text">EN</span></option>
						<option value="PL" data-icon="{!! asset('img/langs/PL.png') !!}"
								class="{{ $synthesiscmsMainColor }}-text left circle"
								@if(mb_strtoupper($app_locale) == "PL") selected @endif><span
									class="{{ $synthesiscmsMainColor }}-text">PL</span></option>
					</select>
				</li>
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
