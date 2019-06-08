@php
	$desktopMenu = $synthesiscmsPositionManager->getCustom('berylium', 'desktop-menu', array(Request::url()));
	$mobileMenu = $synthesiscmsPositionManager->getCustom('berylium', 'mobile-menu', array(Request::url()));
@endphp
@if($desktopMenu && (is_array($desktopMenu) ? count($desktopMenu) : 1) && $model->enabled)
	<nav class="col s12 {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} darken-1 hide-on-med-and-down">
		<div class="nav-wrapper">
			<ul>
				@php
					$firstItemRandomId = "berylium-first-item-" . md5(date('Y-m-d H:i:s:u'));
				@endphp
				@if(!$synthesiscmsShowImageBigBanner)
					<li id="{{ $firstItemRandomId }}"><a style="opacity: 0;">SynthesisCMS Logo Separator</a></li>
				@endif
				<script>
                    $(document).ready(function () {
                        $("#{{ $firstItemRandomId }}").width($('#synthesiscms-app-logo').width());
                    });
				</script>
				{!! $desktopMenu !!}
			</ul>
		</div>
	</nav>
@endif
<style>
	.berylium-icon-dropdown {
		position: relative;
	}
</style>
<script>
    $('.dropdown-trigger-berylium').dropdown({
        inDuration: 300,
        outDuration: 225,
        constrainWidth: true,
        hover: true,
        gutter: 0,
        coverTrigger: true,
        stopPropagation: false
    });
</script>
<ul id="berylium-mobile-menu" class="sidenav">
	<li class="no-padding">
		<div class="user-view">
			<div class="background">
				<img src="{!! asset('img/office.jpg') !!}">
			</div>
			<a href="{!! url($synthesiscmsHomePage) !!}">
				<img class="circle" style="border-radius: unset !important;"
					 src="{!! asset('img/synthesiscms-icon.svg') !!}">
			</a>
			<a href="{!! url($synthesiscmsHomePage) !!}">
				<span class="white-text name truncate">
					@if(\App\SynthesisCMS\API\Auth\UserPrivilegesManager::isGuest())
						{{ trans('synthesiscms/helper.guest_username') }}
					@else
						{{ Auth::user()->name }}
					@endif
				</span>
			</a>
			<a href="{!! url($synthesiscmsHomePage) !!}">
				<span class="white-text email truncate">
					@if(\App\SynthesisCMS\API\Auth\UserPrivilegesManager::isGuest())
						{{ trans('synthesiscms/helper.guest_email') }}
					@else
						{{ Auth::user()->email }}
					@endif
				</span>
			</a>
		</div>
	</li>
	@if (\App\SynthesisCMS\API\Auth\UserPrivilegesManager::isGuest())
		@if($synthesiscmsShowLoginRegisterButtons)
			<ul style="width: 100%;" class="collapsible collapsible-accordion">
				<li class="{{ $synthesiscmsMainColor }}-text col s12 waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}">
					<a title="{!! trans('synthesiscms/menu.register') !!}" class="{{ $synthesiscmsMainColor }}-text collapsible-header" href="{{ route('register') }}"><i
								class="material-icons {{ $synthesiscmsMainColor }}-text left">create</i>{!! trans('synthesiscms/menu.register') !!}
					</a>
				</li>
			</ul>
			<ul style="width: 100%;" class="collapsible collapsible-accordion">
				<li class="{{ $synthesiscmsMainColor }}-text col s12 waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}">
					<a title="{!! trans('synthesiscms/menu.login') !!}" class="{{ $synthesiscmsMainColor }}-text collapsible-header" href="{{ route('login') }}"><i
								class="material-icons {{ $synthesiscmsMainColor }}-text left">fingerprint</i>{!! trans('synthesiscms/menu.login') !!}
					</a>
				</li>
			</ul>
		@endif
	@else
		<ul style="width: 100%;" class="collapsible collapsible-accordion">
			<li class="bold">
				<a class="collapsible-header {{ $synthesiscmsMainColor }}-text {{ $synthesiscmsMainColorClass }} waves-effect waves-{{ $synthesiscmsMainColor }}">
					<i class="material-icons {{ $synthesiscmsMainColor }}-text {{ $synthesiscmsMainColorClass }}">account_circle</i>
					{{ Auth::user()->name }}
					<i class="material-icons right {{ $synthesiscmsMainColor }}-text {{ $synthesiscmsMainColorClass }}">arrow_drop_down</i>
				</a>
				<div class="collapsible-body col s12">
					<ul>
						<li>
							@if(Auth::user()->is_admin)
								<a title="{!! trans('synthesiscms/menu.admin') !!}" class="{{ $synthesiscmsMainColor }}-text waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}"
								   href="{{ route('admin') }}">
									<i class="material-icons {{ $synthesiscmsMainColor }}-text left">build</i>{!! trans('synthesiscms/menu.admin') !!}
								</a>
							@endif
							<a title="{!! trans('synthesiscms/menu.profile') !!}" class="{{ $synthesiscmsMainColor }}-text" href="{{ route('profile') }}">
								<i class="material-icons {{ $synthesiscmsMainColor }}-text left">perm_identity</i>{!! trans('synthesiscms/menu.profile') !!}
							</a>
							<a title="{!! trans('synthesiscms/menu.logout') !!}" class="{{ $synthesiscmsMainColor }}-text" href="{{ route('logout') }}"
							   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
								<i class="material-icons {{ $synthesiscmsMainColor }}-text left">power_settings_new</i>{!! trans('synthesiscms/menu.logout') !!}
							</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST"
								  style="display: none;">
								{{ csrf_field() }}
							</form>
						</li>
					</ul>
				</div>
			</li>
		</ul>
	@endif
	@if($model->enabled)
		{!! $mobileMenu !!}
	@endif
	{!! $synthesiscmsPositionManager->getStandard(App\SynthesisCMS\API\Positions\SynthesisPositions::InsideMenu, Request::url()) !!}
	<ul style="width: 100%;" class="collapsible collapsible-accordion">
		<li class="no-padding">
			<a title="{!! trans('Berylium::berylium.language') !!}" class="collapsible-header {{ $synthesiscmsMainColor }}-text {{ $synthesiscmsMainColorClass }}">
				<i class="material-icons left {{ $synthesiscmsMainColor }}-text {{ $synthesiscmsMainColorClass }}">public</i>
				{{ trans('Berylium::berylium.language') }}
				<i class="material-icons right {{ $synthesiscmsMainColor }}-text {{ $synthesiscmsMainColorClass }}">arrow_drop_down</i>
			</a>
			<div class="collapsible-body" style="padding: unset !important;">
				<ul>
					<script>
                        $(document).ready(function () {
                            $('.lang-span-berylium').each(function () {
                                var chk_lang_str = "{{ \App::getLocale() }}";
                                var element = $(this);
                                if (element.text().toLowerCase() == chk_lang_str.toLowerCase()) {
                                    element.addClass("{{ $synthesiscmsMainColor }} white-text waves-light");
                                } else {
                                    element.addClass("{{ $synthesiscmsMainColor }}-text waves-{{ $synthesiscmsMainColor }}");
                                }
                            });
                            $('.lang-span-berylium').click(function () {
                                SynthesisCmsJsUtils.setLanguage($(this).text().toUpperCase());
                            });
                        });
					</script>
					<li>
						<span class="waves-effect col s12 lang-span-berylium">EN</span>
						<span class="waves-effect col s12 lang-span-berylium">PL</span>
					</li>
				</ul>
			</div>
		</li>
	</ul>
</ul>

<script>
    $(document).ready(function () {
        $('.sidenav').sidenav({
            menuWidth: 300,
            edge: 'left',
            draggable: true
        });
    });
</script>
