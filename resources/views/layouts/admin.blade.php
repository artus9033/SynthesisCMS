<!DOCTYPE html>
<html lang="{!! App::getLocale() !!}">
<head>
	@include('partials/base-head-contents', ['title' => $synthesiscmsHeaderTitle])

	<script src="{{ asset('trumbowyg/trumbowyg.min.js') }}"></script>
	<link rel="stylesheet" href="{{ asset('trumbowyg/ui/trumbowyg.min.css') }}">

	<script src="{{ asset('trumbowyg/plugins/allowtagsfrompaste/trumbowyg.allowtagsfrompaste.min.js') }}"></script>
	<script src="{{ asset('trumbowyg/plugins/base64/trumbowyg.base64.min.js') }}"></script>

	<script src="{{ asset('trumbowyg/plugins/cleanpaste/trumbowyg.cleanpaste.min.js') }}"></script>

	<script src="{{ asset('trumbowyg/plugins/colors/trumbowyg.colors.min.js') }}"></script>
	<link rel="stylesheet" href="{{ asset('trumbowyg/plugins/colors/ui/trumbowyg.colors.min.css') }}">

	<script src="{{ asset('trumbowyg/plugins/emoji/trumbowyg.emoji.min.js') }}"></script>
	<link rel="stylesheet" href="{{ asset('trumbowyg/plugins/emoji/ui/trumbowyg.emoji.min.css') }}">

	<script src="{{ asset('trumbowyg/plugins/fontfamily/trumbowyg.fontfamily.min.js') }}"></script>

	<script src="{{ asset('trumbowyg/plugins/fontsize/trumbowyg.fontsize.min.js') }}"></script>

	<script src="{{ asset('trumbowyg/plugins/history/trumbowyg.history.min.js') }}"></script>

	<script src="{{ asset('trumbowyg/plugins/lineheight/trumbowyg.lineheight.min.js') }}"></script>

	<script src="{{ asset('trumbowyg/plugins/mathml/trumbowyg.mathml.min.js') }}"></script>

	<script src="{{ asset('trumbowyg/plugins/noembed/trumbowyg.noembed.min.js') }}"></script>

	<script src="{{ asset('trumbowyg/plugins/pasteembed/trumbowyg.pasteembed.min.js') }}"></script>

	<script src="{{ asset('trumbowyg/plugins/pasteimage/trumbowyg.pasteimage.min.js') }}"></script>
	
	<script src="{{ asset('trumbowyg/plugins/preformatted/trumbowyg.preformatted.min.js') }}"></script>

	<script src="{{ asset('jquery-resizable-dom/jquery-resizable.min.js') }}"></script>
	<script src="{{ asset('jquery-resizable-dom/jquery-resizableTableColumns.min.js') }}"></script>
	<script src="{{ asset('trumbowyg/plugins/resizimg/trumbowyg.resizimg.min.js') }}"></script>

	<script src="{{ asset('trumbowyg/plugins/ruby/trumbowyg.ruby.min.js') }}"></script>

	<script src="{{ asset('trumbowyg/plugins/specialchars/trumbowyg.specialchars.min.js') }}"></script>
	<link rel="stylesheet" href="{{ asset('trumbowyg/plugins/specialchars/ui/trumbowyg.specialchars.min.css') }}">

	<script src="{{ asset('trumbowyg/plugins/table/trumbowyg.table.min.js') }}"></script>
	<link rel="stylesheet" href="{{ asset('trumbowyg/plugins/table/ui/trumbowyg.table.min.css') }}">

	<script src="{{ asset('trumbowyg/plugins/template/trumbowyg.template.min.js') }}"></script>
	
	<script src="{{ asset('trumbowyg/plugins/upload/trumbowyg.upload.min.js') }}"></script>

	<script src="{{ asset('trumbowyg/plugins/artus9033/trumbowyg.imagepicker.js') }}"></script>
	<script src="{{ asset('trumbowyg/plugins/artus9033/trumbowyg.table_artus9033.js') }}"></script>
	<script src="{{ asset('trumbowyg/plugins/artus9033/trumbowyg.insertFacebookAlbum.js') }}"></script>
	<script src="{{ asset('trumbowyg/plugins/artus9033/trumbowyg.fileEmbed.js') }}"></script>
	
	@foreach (glob(public_path('trumbowyg/langs/') . '*.js') as $file)
		<script src='{{ asset('trumbowyg/langs/' . basename($file)) }}'></script>
	@endforeach

	<script>
        $(document).ready(function () {
			var zeroIndexedCollapsibleHeaderNumberString = '@yield('side-nav-active-zero-indexed')';
			
			$('.collapsible').collapsible();

			$('.fixed-action-btn').floatingActionButton();

            if (zeroIndexedCollapsibleHeaderNumberString.length) {
                $('#admin-mobile-menu-automatically-opened-collapsible-main-element').collapsible('open', parseInt(zeroIndexedCollapsibleHeaderNumberString));
                $('#admin-desktop-menu-automatically-opened-collapsible-main-element').collapsible('open', parseInt(zeroIndexedCollapsibleHeaderNumberString));
			}
			
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
                    },
                    insertImageFromServer: {
                        ico: 'insertImageFromServer'
                    }
                },
                btns: [
                    ['viewHTML'],
					['undo', 'redo'],
					['historyUndo', 'historyRedo']
					['formatting'],
					['strong', 'em', 'del'],
					['superscript', 'subscript'],
					['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
        			['unorderedList', 'orderedList'],
                    ['link'],
                    ['image'],
					['fontfamily', 'fontsize', 'lineheight', 'mathml'],
                    ['foreColor', 'backColor', 'preformatted'],
					['emoji','base64', 'noembed'],
                    ['insertImageFromServer', 'insertFacebookAlbum', 'fileEmbed'],
                    ['horizontalRule', 'table'],
        			['removeformat'],
					['fullscreen']
                ],
                plugins: {
                    upload: {
                        serverPath: {!! json_encode(route('admin_upload_post')) !!},
                        fileFieldName: 'synthesiscms-file',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    }
                },
                lang: '{{ \App::getLocale() }}'
			});
			
			$('ul:not(.collapsible) > li.active').addClass('lighten-1');
			
			$('ul:not(.collapsible) > li.active').addClass('{{ $synthesiscmsMainColor }}');
			
            $('.sidenav').sidenav({
                menuWidth: 300,
                edge: 'left',
                draggable: true
            });
        });
	</script>

	<style>
		@media only screen and (min-width: 993px) {
			body {
				padding-left: 300px;
			}
		}
	</style>

	@yield('head')
</head>
<header>
	<ul id="nav-mobile" class="sidenav">
		@include('admin.partials.admin_menu', ['adminMenuIsMobile' => true])
	</ul>
	<ul class="sidenav sidenav-fixed">
		@include('admin.partials.admin_menu', ['adminMenuIsMobile' => false])
	</ul>
	@yield('header')
</header>
<body style="overflow-x: hidden">
	<scrollbar>
		@yield('body')
		<div class="col s12 row" id="synthesiscms-admin-content-layout-wrapper">
			<nav class="{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12 z-depth-3 no-padding"
				id="synthesiscms-admin-nav-wrapper">
				<div class="nav-wrapper col s12 no-padding">
					<button data-target="nav-mobile"
							class="synthesiscms-mobile-btn-wrapper sidenav-trigger admin-menu-button-collapse hide-on-large-only lighten-1 btn btn-floating btn-large {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} waves-effect waves-light z-depth-1">
						<i class="material-icons">menu</i>
					</button>
					<a id="synthesiscms-desktop-brand-logo" style="margin-left: 10px;" href="{{ route('admin') }}"
					class="hide-on-med-and-down brand-logo truncate">
						{{ $synthesiscmsHeaderTitle }} - {{ trans('synthesiscms/admin.backend') }}
					</a>
					<a id="synthesiscms-mobile-brand-logo" style="margin-left: 0px;" href="{{ route('admin') }}"
					class="hide-on-large-only brand-logo truncate">
						{{ $synthesiscmsHeaderTitle }} - {{ trans('synthesiscms/admin.backend') }}
					</a>
					<ul class="right hide-on-med-and-down" id="synthesiscms-large-screens-menu-part-right">
						<li class="input-field right hide-on-med-and-down" id="language-select-container">
							<select id="lang-select" class="icons white-text"
									onchange="if(this.selectedIndex !== 'undefined') SynthesisCmsJsUtils.setLanguage(this.options[this.selectedIndex].value);">
								<option value="EN" data-icon="{!! asset('img/langs/UK.png') !!}"
										class="{{ $synthesiscmsMainColor }}-text left circle"
										@if(mb_strtoupper(\App::getLocale()) == "EN") selected @endif><span
											class="{{ $synthesiscmsMainColor }}-text">EN</span></option>
								<option value="PL" data-icon="{!! asset('img/langs/PL.png') !!}"
										class="{{ $synthesiscmsMainColor }}-text left circle"
										@if(mb_strtoupper(\App::getLocale()) == "PL") selected @endif><span
											class="{{ $synthesiscmsMainColor }}-text">PL</span></option>
							</select>
						</li>
						@yield('menu')
						<ul id="user_dropdown" class="dropdown-content">
							<li>
								<a class="{{ $synthesiscmsMainColor }}-text" href="{{ route('admin') }}"><i
											class="material-icons {{ $synthesiscmsMainColor }}-text left">build</i>{!! trans('synthesiscms/menu.admin') !!}
								</a>
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
					</ul>
				</div>
			</nav>
			<nav class="{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} lighten-1 col s12 z-depth-2">
				<div class="nav-wrapper col s12">
					<div class="col s12">
						<a href="{{ url($synthesiscmsHomePage) }}" class="breadcrumb">
							<i class="material-icons">home</i>&nbsp;{{ trans('synthesiscms/main.home')}}
						</a>
						@yield('breadcrumbs')
					</div>
				</div>
			</nav>
			<div class="main col s12 row center">
				@if(Session::has('messages'))
					@each('partials/message', Session::get('messages'), 'message')
					@php(Session::forget('messages'))
				@endif
				@if(!\App\Toolbox::isFunctionEnabled('shell_exec'))
					@include('partials/warning', ['warning' => trans('synthesiscms/errors.shell_exec_disabled')])
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
				<div @if(!$synthesiscmsClientIsAnyMobile) class="col s12 m12 l12 z-depth-1 grey lighten-4 row card z-depth-5 no-padding"
					style="display: inline-block; padding: 0px 48px 0px 48px; border: 1px solid #EEE;" @endif>
					<div @if(!$synthesiscmsClientIsAnyMobile) class="card-content" @endif>
						<div class="col s12 row">
							@yield('main')
						</div>
					</div>
				</div>
			</div>
		</div>
	</scrollbar>
</body>
</html>
