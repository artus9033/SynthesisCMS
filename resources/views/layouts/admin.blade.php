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
	<script src="{{ asset('trumbowyg/trumbowyg.min.js') }}"></script>
	<link rel="stylesheet" href="{{ asset('trumbowyg/ui/trumbowyg.min.css') }}">
	<script>
	$(document).ready(function(){
		$('.collapsible').collapsible();
		var selector = "#@yield('side-nav-active')";
		if(selector != "#"){
			$(selector).addClass("active");
			$(selector).parents('li').children('a').click();
			$(".editor").trumbowyg({
				lang: '{{ \App::getLocale() }}'
			});
		}
		$('ul:not(.collapsible) > li.active').addClass('lighten-1');
		$('ul:not(.collapsible) > li.active').addClass('{{ $synthesiscmsMainColor }}');
	});
	</script>
	<style>
	body{
		padding-left: 300px;
	}
	</style>
	@yield('head')
</head>
<header>
	<ul id="nav-mobile" class="side-nav fixed" style="transform: translateX(0px);">
		<li class="logo"><a href="/admin" class="brand-logo {{ $synthesiscmsMainColor }} white-text waves-effect waves-light"><i class="material-icons white-text">verified_user</i>{{ trans('synthesiscms/admin.backend') }}</a></li>
		<li>
			<ul class="collapsible collapsible-accordion">
				<li class="bold"><a class="collapsible-header waves-effect waves-{{ $synthesiscmsMainColor }}"><i class="material-icons {{ $synthesiscmsMainColor }}-text">description</i>{{ trans('synthesiscms/admin.section_content') }}</a>
					<div class="collapsible-body">
						<ul>
							<li id="manage_atoms"><a class="waves-effect waves-{{ $synthesiscmsMainColor }}" href="/admin/manage_atoms">{{ trans('synthesiscms/admin.manage_atoms') }}</a></li>
							<li id="manage_molecules"><a class="waves-effect waves-{{ $synthesiscmsMainColor }}" href="/admin/manage_molecules">{{ trans('synthesiscms/admin.manage_molecules') }}</a></li>
						</ul>
					</div>
				</li>
				<li class="bold"><a class="collapsible-header waves-effect waves-{{ $synthesiscmsMainColor }}"><i class="material-icons {{ $synthesiscmsMainColor }}-text">supervisor_account</i>{{ trans('synthesiscms/admin.section_users') }}</a>
					<div class="collapsible-body">
						<ul>
							<li id="profile"><a class="waves-effect waves-{{ $synthesiscmsMainColor }}" href="/profile">{{ trans('synthesiscms/profile.profile') }}</a></li>
							<li id="manage_users"><a class="waves-effect waves-{{ $synthesiscmsMainColor }}" href="/admin/manage_users">{{ trans('synthesiscms/admin.manage_users') }}</a></li>
						</ul>
					</div>
				</li>
				<li class="bold"><a class="collapsible-header waves-effect waves-{{ $synthesiscmsMainColor }}"><i class="material-icons {{ $synthesiscmsMainColor }}-text">pages</i>{{ trans('synthesiscms/admin.section_routes') }}</a>
					<div class="collapsible-body">
						<ul>
							<li id="manage_routes"><a class="waves-effect waves-{{ $synthesiscmsMainColor }}" href="/admin/manage_routes">{{ trans('synthesiscms/admin.manage_routes') }}</a></li>
							<li id="manage_applets"><a class="waves-effect waves-{{ $synthesiscmsMainColor }}" href="/admin/manage_applets">{{ trans('synthesiscms/admin.manage_applets') }}</a></li>
						</ul>
					</div>
				</li>
				<li class="bold active"><a class="collapsible-header waves-effect waves-{{ $synthesiscmsMainColor }}"><i class="material-icons {{ $synthesiscmsMainColor }}-text">settings</i>{{ trans('synthesiscms/admin.section_settings') }}</a>
					<div class="collapsible-body" style="display: block;">
						<ul>
							<li id="settings"><a class="waves-effect waves-{{ $synthesiscmsMainColor }}" href="/admin/settings">{{ trans('synthesiscms/admin.settings') }}</a></li>
						</ul>
					</div>
				</li>
			</ul>
		</li>
	</ul>
	@yield('header')
</header>
<body>
	@yield('body')
	<div class="col s12 row">
		<nav class="{{ $synthesiscmsMainColor }} col s12 z-depth-3">
			<div class="nav-wrapper col s12">
				<a href="/" class="brand-logo" style="margin-left: 10px;">{{ $synthesiscmsHeaderTitle }} - @section('brand-logo'){{ trans('synthesiscms/admin.backend') }}@show</a>
					<div class="input-field right">
						<select id="lang-select" class="icons white-text" onchange="if(this.selectedIndex !== 'undefined') setLanguage(this.options[this.selectedIndex].value, '{{ url("/") }}');">
							<option value="EN" data-icon="{!! asset('img/langs/UK.png') !!}" class="{{ $synthesiscmsMainColor }}-text left circle"><span class="{{ $synthesiscmsMainColor }}-text">EN</span></option>
							<option value="PL" data-icon="{!! asset('img/langs/PL.png') !!}" class="{{ $synthesiscmsMainColor }}-text left circle"><span class="{{ $synthesiscmsMainColor }}-text">PL</span></option>
						</select>
					</div>
					<script>
					$('#lang-select').val("{{ strtoupper(\App::getLocale()) }}");
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
			<nav class="{{ $synthesiscmsMainColor }} lighten-1 col s12 z-depth-2">
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
				@if(Session::has('toasts'))
					@each('partials/toast', Session::get('toasts'), 'toast')
				@endif
				@yield('main')
			</div>
		</div>
	</body>
	</html>
