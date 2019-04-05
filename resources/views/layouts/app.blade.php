<!DOCTYPE html>
<html lang="{!! App::getLocale() !!}">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://unpkg.com/gutenberg-css@0.4" media="print">
	<link rel="stylesheet" href="https://unpkg.com/gutenberg-css@0.4/dist/themes/oldstyle.min.css" media="print">
	<!-- TODO: implement no-print class from gutenberg in the CMS -->
	<!-- TODO: download gutenberg via npm for offline server usage -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="shortcut icon" type="image/ico" href="{{ url('/favicon.ico') }}"/>
	<meta http-equiv="Content-language" content="{!! App::getLocale() !!}">
	<meta name="viewport" content="width=device-width, initial-scale=0.7">
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
	<script type="text/javascript" src="{!! asset('js/clipboard.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('js/synthesiscms-js-utils.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('js/dragula.js') !!}"></script>
	<link type="text/css" rel="stylesheet" href="{!! asset("fonts/roboto/roboto.css") !!}">
	<link type="text/css" rel="stylesheet" href="{!! asset("css/dragula.css") !!}">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<script type="text/javascript" src="{!! asset('js/jquery.optiscroll.js') !!}"></script>
	<link type="text/css" rel="stylesheet" href="{!! asset("css/optiscroll.css") !!}">
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
	<title>{{ $synthesiscmsHeaderTitle }}</title>
	<meta name="description" content="{{trim(View::yieldContent('title'))}}">
	<!-- TODO: add article description to description meta tag -->
	@yield('head')
	<style>
		body {
			min-height: 100vh;
		}
	</style>
</head>
<header class="no-print">
	@yield('header')
</header>
<body style="overflow-x: hidden">
@yield('body')
<div class="col s12 row" style="margin-bottom: 0px !important;">
	{!! $synthesiscmsPositionManager->getStandard(App\SynthesisCMS\API\Positions\SynthesisPositions::OverMenu, Request::url()) !!}
	<nav id="synthesiscms-app-main-nav" class="no-print {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12 no-padding z-depth-3">
		<div class="nav-wrapper col s12 no-padding">
			<div class="left synthesiscms-mobile-btn-wrapper">
				{!! $synthesiscmsPositionManager->getStandard(App\SynthesisCMS\API\Positions\SynthesisPositions::BeforeSiteName, Request::url()) !!}
			</div>
			@if($synthesiscmsShowImageBigBanner)
				<a id="synthesiscms-big-image-banner" href="{!! url($synthesiscmsHomePage) !!}"
				class="hide-on-med-and-down brand-logo">
					<img id="synthesiscms-app-logo-img" style="object-fit: scale-down;" src="{{ url('/banner.png') }}">
				</a>
				<a id="synthesiscms-mobile-brand-logo" href="{!! url($synthesiscmsHomePage) !!}"
				   class="hide-on-large-only brand-logo truncate">{{ $synthesiscmsHeaderTitle }}
				</a>
			@else
				<a id="synthesiscms-app-logo" class="brand-logo left hide-on-med-and-down"
				   style="background-color: {!! $synthesiscmsLogoBackgroundColor !!}; position: relative; box-shadow: rgba(255, 255, 255, 0.8) 0px 0px 8px; border-bottom-right-radius: 2.3em; z-index: 999 !important; overflow: hidden;"
				   href="{!! url($synthesiscmsHomePage) !!}">
					<img id="synthesiscms-app-logo-img" style="padding: 10px; object-fit: scale-down;" src="{{ url('/favicon.ico') }}">
				</a>
				<a id="synthesiscms-mobile-brand-logo" href="{!! url($synthesiscmsHomePage) !!}"
				   class="hide-on-large-only brand-logo truncate">{{ $synthesiscmsHeaderTitle }}</a>
				<a id="synthesiscms-desktop-brand-logo" href="{!! url($synthesiscmsHomePage) !!}" style="max-width: 100%;"
			    class="hide-on-med-and-down brand-logo truncate col s7">{{ $synthesiscmsHeaderTitle }}</a>
			@endif
			<script>
                function synthesiscmsResizeBrandLogoMargin() {
                    var mobileBtnWrapper = $('.synthesiscms-mobile-btn-wrapper');
                    var appLogoImg = $("#synthesiscms-app-logo-img");
                    var jBody = $('body');
                    var desktopLogoWidth = (jBody.width() - $('#synthesiscms-large-screens-menu-part-right').width() - $('#synthesiscms-app-logo').width());
                    var desktopBrandLogo = $("#synthesiscms-desktop-brand-logo");
                    var mobileBrandLogo = $("#synthesiscms-mobile-brand-logo");
                    /*$("#synthesiscms-big-image-banner").height(appLogoImg.width());
                    $("#synthesiscms-app-main-nav").height(appLogoImg.width());
                    mobileBrandLogo.css('width', (jBody.width() - mobileBtnWrapper.width()));
                    mobileBrandLogo.css('max-width', (jBody.width() - mobileBtnWrapper.width()));
                    mobileBrandLogo.css('padding-left', mobileBtnWrapper.width());
                    desktopBrandLogo.css('max-width', desktopLogoWidth);
                    desktopBrandLogo.css('width', desktopLogoWidth);*/
                }
                $(document).ready(function () {
                    //$("#synthesiscms-app-logo").height($("#synthesiscms-app-logo").width()); //substituted with height: 220% - looks better & doesn't wait 'till document ready
                    //$("#synthesiscms-large-screen-logo-image").width($("#synthesiscms-app-logo").width() - 10);
                    //$("#synthesiscms-large-screen-logo-image").height($("#synthesiscms-app-logo").height() - 10);
                    synthesiscmsResizeBrandLogoMargin();
					$(".tabs").tabs();
                });
                $(window).resize(function () {
                    synthesiscmsResizeBrandLogoMargin();
                });
			</script>
			@php
				$app_locale = strtoupper(\App::getLocale());
			@endphp
			<ul class="hide-on-med-and-down right" id="synthesiscms-large-screens-menu-part-right">
				<li class="input-field right hide-on-med-and-down" id="language-select-container">
					<select id="lang-select" class="icons white-text"
							onchange="if(this.selectedIndex !== 'undefined') SynthesisCmsJsUtils.setLanguage(this.options[this.selectedIndex].value);">
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
				@if (\App\SynthesisCMS\API\Auth\UserPrivilegesManager::isGuest())
					@if($synthesiscmsShowLoginRegisterButtons)
						<li class="right">
							<a class="center" href="{{ route('register') }}">
								<i class="material-icons white-text left">create</i>{!! trans('synthesiscms/menu.register') !!}
							</a>
						</li>
						<li class="right">
							<a class="center" href="{{ route('login') }}">
								<i class="material-icons white-text left">fingerprint</i>{!! trans('synthesiscms/menu.login') !!}
							</a>
						</li>
					@endif
				@else
					<ul id="user_dropdown" class="dropdown-content">
						<li>
							@if(Auth::user()->is_admin)
								<a class="{{ $synthesiscmsMainColor }}-text" href="{{ route('admin') }}"><i
											class="material-icons {{ $synthesiscmsMainColor }}-text left">build</i>{!! trans('synthesiscms/menu.admin') !!}
								</a>
							@endif
							<a class="{{ $synthesiscmsMainColor }}-text" href="{{ route('profile') }}"><i
										class="material-icons {{ $synthesiscmsMainColor }}-text left">perm_identity</i>{!! trans('synthesiscms/menu.profile') !!}
							</a>
							<a class="{{ $synthesiscmsMainColor }}-text" href="{{ route('logout') }}"
							   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
										class="material-icons {{ $synthesiscmsMainColor }}-text left">power_settings_new</i>{!! trans('synthesiscms/menu.logout') !!}
							</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								{{ csrf_field() }}
							</form>
						</li>
					</ul>
					<li class="right" style="min-width: 210px;">
						<a class="dropdown-trigger dropdown-button center" data-target="user_dropdown">
							<i class="material-icons white-text left">account_circle</i>
							{{ Auth::user()->name }}
							<i class="material-icons right">arrow_drop_down</i>
						</a>
					</li>
				@endif
				{!! $synthesiscmsPositionManager->getStandard(App\SynthesisCMS\API\Positions\SynthesisPositions::InsideMenu, Request::url()) !!}
			</ul>
		</div>
	</nav>
	{!! $synthesiscmsPositionManager->getStandard(App\SynthesisCMS\API\Positions\SynthesisPositions::BelowMenu, Request::url()) !!}
	{!! $synthesiscmsPositionManager->getStandard(App\SynthesisCMS\API\Positions\SynthesisPositions::OverBreadcrumbs, Request::url()) !!}
	<nav class="{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} lighten-1 col s12 z-depth-2 row">
		<div class="nav-wrapper col s12">
			<div class="col s12">
				<a href="{{ url($synthesiscmsHomePage) }}" class="breadcrumb">
					<i class="material-icons">home</i>&nbsp;{{ trans('synthesiscms/main.home')}}
				</a>
				@yield('breadcrumbs')
			</div>
		</div>
	</nav>
	{!! $synthesiscmsPositionManager->getStandard(App\SynthesisCMS\API\Positions\SynthesisPositions::BelowBreadcrumbs, Request::url()) !!}
	<div class="main col s12 row no-padding">
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
		{!! $synthesiscmsPositionManager->getStandard(App\SynthesisCMS\API\Positions\SynthesisPositions::OverContent, Request::url()) !!}
		@yield('main')
		{!! $synthesiscmsPositionManager->getStandard(App\SynthesisCMS\API\Positions\SynthesisPositions::BelowContent, Request::url()) !!}
	</div>
</div>
@include('partials/footer')
{!! $synthesiscmsPositionManager->getStandard(App\SynthesisCMS\API\Positions\SynthesisPositions::BelowFooter, Request::url()) !!}
</body>
</html>
