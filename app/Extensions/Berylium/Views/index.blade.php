@php
$desktopMenu = $synthesiscmsPositionManager->getCustom('berylium', 'desktop-menu', array(Request::url()));
$generalMenuForDesktop = $synthesiscmsPositionManager->getCustom('berylium', 'menu', array(Request::url(), 'desktop'));
$generalMenuForMobile = $synthesiscmsPositionManager->getCustom('berylium', 'menu', array(Request::url(), 'mobile'));
$mobileMenu = $synthesiscmsPositionManager->getCustom('berylium', 'mobile-menu', array(Request::url()));
@endphp
@if((count($generalMenuForDesktop) || count($desktopMenu)) && $model->enabled)
	<nav class="col s12 {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} darken-1 hide-on-med-and-down">
		<div class="nav-wrapper">
			<ul>
				{!! $generalMenuForDesktop !!}
				{!! $desktopMenu !!}
			</ul>
		</div>
	</nav>
@endif
<ul id="berylium-mobile-menu" class="side-nav">
	<li class="no-padding">
		<div class="userView">
			<div class="background">
				<img src="{!! asset('img/office.jpg') !!}">
			</div>
			<a href="{{ url('/profile') }}"><img class="circle" src="{!! asset('img/cms-icon.png') !!}"></a>
			<a href="{{ url('/profile') }}"><span class="white-text name truncate">@if(Auth::guest()) {{ trans('synthesiscms/helper.guest_username') }} @else {{ Auth::user()->name }} @endif</span></a>
				<a href="{{ url('/profile') }}"><span class="white-text email truncate">@if(Auth::guest()) {{ trans('synthesiscms/helper.guest_email') }} @else {{ Auth::user()->email }} @endif</span></a>
				</div>
			</li>
			@if (Auth::guest())
				<li class="{{ $synthesiscmsMainColor }}-text col s12 row waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}"><a class="" href="{{ url('/register') }}"><i class="material-icons {{ $synthesiscmsMainColor }}-text left">create</i>{!! trans('synthesiscms/menu.register') !!}</a></li>
				<li class="{{ $synthesiscmsMainColor }}-text col s12 row waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}"><a class="" href="{{ url('/login') }}"><i class="material-icons {{ $synthesiscmsMainColor }}-text left">fingerprint</i>{!! trans('synthesiscms/menu.login') !!}</a></li>
			@else
				<li class="col s12 no-padding waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}">
					<ul class="collapsible collapsible-accordion col s12">
						<li class="col s12">
							<a class="collapsible-header {{ $synthesiscmsMainColor }}-text {{ $synthesiscmsMainColorClass }}">
								<i class="material-icons left {{ $synthesiscmsMainColor }}-text {{ $synthesiscmsMainColorClass }}">account_circle</i>
								{{ Auth::user()->name }}
								<i class="material-icons right {{ $synthesiscmsMainColor }}-text {{ $synthesiscmsMainColorClass }}">arrow_drop_down</i>
							</a>
							<div class="collapsible-body" style="padding: unset !important;">
								<ul>
									<li>
										@if(Auth::user()->is_admin)
											<a class="{{ $synthesiscmsMainColor }}-text waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}" href="{{ url('/admin') }}"><i class="material-icons {{ $synthesiscmsMainColor }}-text left">build</i>{!! trans('synthesiscms/menu.admin') !!}</a>
										@endif
										<a class="{{ $synthesiscmsMainColor }}-text" href="{{ url('/profile') }}"><i class="material-icons {{ $synthesiscmsMainColor }}-text left">perm_identity</i>{!! trans('synthesiscms/menu.profile') !!}</a>
										<a class="{{ $synthesiscmsMainColor }}-text" href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="material-icons {{ $synthesiscmsMainColor }}-text left">power_settings_new</i>{!! trans('synthesiscms/menu.logout') !!}</a>
										<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
											{{ csrf_field() }}
										</form>
									</li>
								</ul>
							</div>
						</li>
					</ul>
				</li>
			@endif
			<li class="col s12 no-padding waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}">
				<ul class="collapsible collapsible-accordion col s12">
					<li class="col s12">
						<a class="collapsible-header {{ $synthesiscmsMainColor }}-text {{ $synthesiscmsMainColorClass }}">
							<i class="material-icons left {{ $synthesiscmsMainColor }}-text {{ $synthesiscmsMainColorClass }}">language</i>
							{{ trans('Berylium::berylium.language') }}
							<i class="material-icons right {{ $synthesiscmsMainColor }}-text {{ $synthesiscmsMainColorClass }}">arrow_drop_down</i>
						</a>
						<div class="collapsible-body" style="padding: unset !important;">
							<ul>
								<script>
								$(document).ready(function(){
									$('.lang-span-berylium').each(function(){
										var chk_lang_str = "{{ \App::getLocale() }}";
										var element = $(this);
										if(element.text().toLowerCase() == chk_lang_str.toLowerCase()){
											element.addClass("{{ $synthesiscmsMainColor }} white-text waves-light");
										}else{
											element.addClass("{{ $synthesiscmsMainColor }}-text waves-{{ $synthesiscmsMainColor }}");
										}
									});
									$('.lang-span-berylium').click(function(){
										setLanguage($(this).text().toUpperCase(), '{{ url("/") }}');
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
			</li>
			@if($model->enabled)
				{!! $generalMenuForMobile !!}
				{!! $mobileMenu !!}
			@endif
			{!! $synthesiscmsPositionManager->getStandard(App\SynthesisCMS\API\Positions\SynthesisPositions::InsideMenu, Request::url()) !!}
		</ul>

		<script>
		$(document).ready(function(){
			$('.berylium-menu-button-collapse').sideNav({
				menuWidth: 300,
				edge: 'left',
				closeOnClick: true,
				draggable: true
			});
		});
		</script>
