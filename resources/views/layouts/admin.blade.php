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
	<script type="text/javascript" src="{!! asset('js/clipboard.min.js') !!}"></script>
	<script type="text/javascript">
	/**$.ajaxSetup({
	//this collides with Trumbowyg's noEmbed & upload plugins
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});**/
	</script>
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="{!! asset('css/materialize.css') !!}"  media="screen,projection"/>
	<link href="{!! asset('css/app.css') !!}" rel="stylesheet">
	<title>{{ $synthesiscmsHeaderTitle }} - @yield('title')</title>
	<script src="{{ asset('trumbowyg/trumbowyg.min.js') }}"></script>
	<link rel="stylesheet" href="{{ asset('trumbowyg/ui/trumbowyg.min.css') }}">
	<script src="{{ asset('trumbowyg/plugins/base64/trumbowyg.base64.min.js') }}"></script>
	<script src="{{ asset('trumbowyg/plugins/colors/trumbowyg.colors.min.js') }}"></script>
	<link rel="stylesheet" href="{{ asset('trumbowyg/plugins/colors/ui/trumbowyg.colors.min.css') }}">
	<script src="{{ asset('trumbowyg/plugins/emoji/trumbowyg.emoji.min.js') }}"></script>
	<script src="{{ asset('trumbowyg/plugins/pasteimage/trumbowyg.pasteimage.min.js') }}"></script>
	<script src="{{ asset('trumbowyg/plugins/table/trumbowyg.table.min.js') }}"></script>
	<script src="{{ asset('trumbowyg/plugins/upload/trumbowyg.upload.js') }}"></script>
	<script src="{{ asset('trumbowyg/plugins/noembed/trumbowyg.noembed.js') }}"></script>
	<script>
	$(document).ready(function(){
		$('.collapsible').collapsible();
		var selector = "#@yield('side-nav-active')";
		if(selector != "#"){
			$(selector).addClass("active");
			$(selector).parents('li').children('a').click();
			$(".editor").trumbowyg({
				autogrow: true,
            fullscreenable: false,
		  btnsDef: {
                    image: {
                        dropdown: ['insertImage', 'upload', 'base64', 'noembed'],
                        ico: 'insertImage'
			    },
			    link: {
                        dropdown: ['createLink', 'unlink', 'noembed'],
                        ico: 'link'
                    }
                },
                btns: [
                    ['viewHTML'],
                    ['undo', 'redo'],
                    ['formatting'],
                    'btnGrp-design',
                    ['link'],
                    ['image'],
                    'btnGrp-justify',
                    'btnGrp-lists',
                    ['foreColor', 'backColor'],
                    ['preformatted'],
                    ['horizontalRule'],
                    ['fullscreen']
                ],
                plugins: {
                    upload: {
                        serverPath: {!! json_encode(url("/") . "/admin/upload") !!},
                        fileFieldName: 'file',
                        headers: {
					   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    }
			},
				lang: '{{ \App::getLocale() }}'
			});
		}
		$('ul:not(.collapsible) > li.active').addClass('lighten-1');
		$('ul:not(.collapsible) > li.active').addClass('{{ $synthesiscmsMainColor }}');
		$('.admin-menu-button-collapse').sideNav({
			menuWidth: 300,
			edge: 'left',
			closeOnClick: true,
			draggable: true
		});
	});
	</script>
	@if(!$synthesiscmsClientIsAnyMobile)
	<style>
	body{
		padding-left: 300px;
	}
	</style>
@endif
@yield('head')
</head>
<header>
	@if(!$synthesiscmsClientIsAnyMobile)
		<ul id="nav-mobile" class="side-nav fixed" style="transform: translateX(0px);">
		@else
			<ul id="nav-mobile" class="side-nav">
			@endif
			<li class="logo"><a href="{{ url('/admin') }}" class="brand-logo {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text waves-effect waves-light"><i class="material-icons white-text">verified_user</i>{{ trans('synthesiscms/admin.backend') }}</a></li>
			<li>
				<ul class="collapsible collapsible-accordion">
					<li class="bold"><a class="collapsible-header waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}"><i class="material-icons {{ $synthesiscmsMainColor }}-text">description</i>{{ trans('synthesiscms/admin.section_content') }}</a>
						<div class="collapsible-body" style="padding: unset !important;">
							<ul>
								<li id="manage_atoms"><a class="waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}" href="{{ url('/admin/manage_atoms') }}">{{ trans('synthesiscms/admin.manage_atoms') }}</a></li>
								<li id="manage_molecules"><a class="waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}" href="{{ url('/admin/manage_molecules') }}">{{ trans('synthesiscms/admin.manage_molecules') }}</a></li>
							</ul>
						</div>
					</li>
					<li class="bold"><a class="collapsible-header waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}"><i class="material-icons {{ $synthesiscmsMainColor }}-text">supervisor_account</i>{{ trans('synthesiscms/admin.section_users') }}</a>
						<div class="collapsible-body" style="padding: unset !important;">
							<ul>
								<li id="profile"><a class="waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}" href="{{ url('/profile') }}">{{ trans('synthesiscms/profile.profile') }}</a></li>
								<li id="manage_users"><a class="waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}" href="{{ url('/admin/manage_users') }}">{{ trans('synthesiscms/admin.manage_users') }}</a></li>
							</ul>
						</div>
					</li>
					<li class="bold"><a class="collapsible-header waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}"><i class="material-icons {{ $synthesiscmsMainColor }}-text">pages</i>{{ trans('synthesiscms/admin.section_routes') }}</a>
						<div class="collapsible-body" style="padding: unset !important;">
							<ul>
								<li id="manage_routes"><a class="waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}" href="{{ url('/admin/manage_routes') }}">{{ trans('synthesiscms/admin.manage_routes') }}</a></li>
								<li id="manage_applets"><a class="waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}" href="{{ url('/admin/manage_applets') }}">{{ trans('synthesiscms/admin.manage_applets') }}</a></li>
							</ul>
						</div>
					</li>
					<li class="bold active"><a class="collapsible-header waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}"><i class="material-icons {{ $synthesiscmsMainColor }}-text">settings</i>{{ trans('synthesiscms/admin.section_settings') }}</a>
						<div class="collapsible-body" style="padding: unset !important;">
							<ul>
								<li id="settings"><a class="waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}" href="{{ url('/admin/settings') }}">{{ trans('synthesiscms/admin.settings') }}</a></li>
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
			<nav class="{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12 z-depth-3">
				<div class="nav-wrapper col s12">
					@if($synthesiscmsClientIsAnyMobile)
						<div class="left">
							<button data-activates="nav-mobile" class="admin-menu-button-collapse lighten-1 btn btn-floating btn-large {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} waves-effect waves-light z-depth-1">
								<i class="material-icons">menu</i>
							</button>
						</div>
					@endif
					<a href="{{ url('/') }}" class="brand-logo" style="margin-left: 10px;">{{ $synthesiscmsHeaderTitle }} - @section('brand-logo'){{ trans('synthesiscms/admin.backend') }}@show</a>
						<div class="input-field right hide-on-med-and-down">
							<select id="lang-select" class="icons white-text" onchange="if(this.selectedIndex !== 'undefined') setLanguage(this.options[this.selectedIndex].value, '{{ url("/") }}');">
								<option value="EN" data-icon="{!! asset('img/langs/UK.png') !!}" class="{{ $synthesiscmsMainColor }}-text left circle"><span class="{{ $synthesiscmsMainColor }}-text">EN</span></option>
								<option value="PL" data-icon="{!! asset('img/langs/PL.png') !!}" class="{{ $synthesiscmsMainColor }}-text left circle"><span class="{{ $synthesiscmsMainColor }}-text">PL</span></option>
							</select>
						</div>
						<script>
						$('#lang-select').val("{{ strtoupper(\App::getLocale()) }}");
						</script>
						<ul class="col s10 right hide-on-med-and-down">
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
								<li class="right" style="min-width: 210px;"><a class="dropdown-button center" href="{{ url('/profile') }}" data-activates="user_dropdown"><i class="material-icons white-text left">account_circle</i>{{ Auth::user()->name }}<i class="material-icons right">arrow_drop_down</i></a></li>
							@endif
						</ul>
					</div>
				</nav>
				<nav class="{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} lighten-1 col s12 z-depth-2">
					<div class="nav-wrapper col s12">
						<div class="col s12">
							<a href="{{ url('/') }}" class="breadcrumb"><i class="material-icons">home</i>&nbsp;{{ trans('synthesiscms/main.home')}}</a>
							@yield('breadcrumbs')
						</div>
					</div>
				</nav>
				<div class="main col s12 row center">
					@if(Session::has('messages'))
						@each('partials/message', Session::get('messages'), 'message')
					@endif
					@each('partials/error', $errors, 'error')
					@if(Session::has('toasts'))
						@each('partials/toast', Session::get('toasts'), 'toast')
					@endif
					@if(!$synthesiscmsClientIsAnyMobile)
						<div class="col s12 m12 l12 z-depth-1 grey lighten-4 row card z-depth-5" style="display: inline-block; padding: 0px 48px 0px 48px; border: 1px solid #EEE;">
							<div class="card-content">
							@else
								<div class="col s12 row">
								@endif
								@yield('main')
							</div>
							@if(!$synthesiscmsClientIsAnyMobile)
							</div>
						@endif
					</body>
					</html>
