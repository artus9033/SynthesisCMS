<!DOCTYPE html>
<html lang="{!! App::getLocale() !!}">
<head>
	@include('partials/base-head-contents', ['title' => $synthesiscmsHeaderTitle])

	@yield('head')
</head>
<body style="overflow-x: hidden">
	<header class="no-print">
		@yield('header')
	</header>
	<main>
		<scrollbar>
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
		</scrollbar>
	</main>
	@include('partials/footer')
	{!! $synthesiscmsPositionManager->getStandard(App\SynthesisCMS\API\Positions\SynthesisPositions::BelowFooter, Request::url()) !!}
</body>
</html>
