@php
$desktopSlider = $synthesiscmsPositionManager->getCustom('nitrogen', 'desktop-slider', array(Request::url()));
$generalSliderForDesktop = $synthesiscmsPositionManager->getCustom('nitrogen', 'slider', array(Request::url(), 'desktop'));
$generalSliderForMobile = $synthesiscmsPositionManager->getCustom('nitrogen', 'slider', array(Request::url(), 'mobile'));
$mobileSlider = $synthesiscmsPositionManager->getCustom('nitrogen', 'mobile-slider', array(Request::url()));
@endphp
@if((count($generalSliderForDesktop) || count($desktopSlider)) && $model->enabled)
	<nav class="col s12 {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} darken-1 hide-on-med-and-down">
		<div class="nav-wrapper">
			<ul>
				{!! $generalSliderForDesktop !!}
				{!! $desktopSlider !!}
			</ul>
		</div>
	</nav>
@endif
<ul id="nitrogen-mobile-slider" class="side-nav">
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
				<li class="{{ $synthesiscmsMainColor }}-text col s12 row waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}"><a class="" href="{{ url('/register') }}"><i class="material-icons {{ $synthesiscmsMainColor }}-text left">create</i>{!! trans('synthesiscms/slider.register') !!}</a></li>
				<li class="{{ $synthesiscmsMainColor }}-text col s12 row waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}"><a class="" href="{{ url('/login') }}"><i class="material-icons {{ $synthesiscmsMainColor }}-text left">fingerprint</i>{!! trans('synthesiscms/slider.login') !!}</a></li>
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
											<a class="{{ $synthesiscmsMainColor }}-text waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}" href="{{ url('/admin') }}"><i class="material-icons {{ $synthesiscmsMainColor }}-text left">build</i>{!! trans('synthesiscms/slider.admin') !!}</a>
										@endif
										<a class="{{ $synthesiscmsMainColor }}-text" href="{{ url('/profile') }}"><i class="material-icons {{ $synthesiscmsMainColor }}-text left">perm_identity</i>{!! trans('synthesiscms/slider.profile') !!}</a>
										<a class="{{ $synthesiscmsMainColor }}-text" href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="material-icons {{ $synthesiscmsMainColor }}-text left">power_settings_new</i>{!! trans('synthesiscms/slider.logout') !!}</a>
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
							{{ trans('Nitrogen::nitrogen.language') }}
							<i class="material-icons right {{ $synthesiscmsMainColor }}-text {{ $synthesiscmsMainColorClass }}">arrow_drop_down</i>
						</a>
						<div class="collapsible-body" style="padding: unset !important;">
							<ul>
								<script>
								$(document).ready(function(){
									$('.lang-span-nitrogen').each(function(){
										var chk_lang_str = "{{ \App::getLocale() }}";
										var element = $(this);
										if(element.text().toLowerCase() == chk_lang_str.toLowerCase()){
											element.addClass("{{ $synthesiscmsMainColor }} white-text waves-light");
										}else{
											element.addClass("{{ $synthesiscmsMainColor }}-text waves-{{ $synthesiscmsMainColor }}");
										}
									});
									$('.lang-span-nitrogen').click(function(){
										setLanguage($(this).text().toUpperCase(), '{{ url("/") }}');
									});
								});
								</script>
								<li>
									<span class="waves-effect col s12 lang-span-nitrogen">EN</span>
									<span class="waves-effect col s12 lang-span-nitrogen">PL</span>
								</li>
							</ul>
						</div>
					</li>
				</ul>
			</li>
			@if($model->enabled)
				{!! $generalSliderForMobile !!}
				{!! $mobileSlider !!}
			@endif
			{!! $synthesiscmsPositionManager->getStandard(App\SynthesisCMS\API\Positions\SynthesisPositions::InsideSlider, Request::url()) !!}
		</ul>

		<script>
		$(document).ready(function(){
			$('.nitrogen-slider-button-collapse').sideNav({
				sliderWidth: 300,
				edge: 'left',
				closeOnClick: true,
				draggable: true
			});
		});
		</script>
