<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
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
		<nav class="{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12 z-depth-3">
			<div class="nav-wrapper col s12">
				<div class="left">
					{!! $synthesiscmsPositionManager->getStandard(App\SynthesisCMS\API\Positions\SynthesisPositions::BeforeSiteName, Request::url()) !!}
				</div>
				<a class="brand-logo left hide-on-med-and-down" style="width: 10%; z-index: 99999999999999999999999999999999999999999999999999999999999999999 !important; position: relative;"><img class="col s12 circle" style="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAA5FBMVEX////9zJnhHjr9zJrhGzj9ypX+0Z3/1qX9yJHhKEPgACr9zZngACzztrrgDjTgFDboZWjlTlvtd2bpbnnfADDxkXXkR1fmVmXxp6v90qXmXWvpdYDfACX/8+j/+vbfAB/+38H+69n+7Nv91q/kQVP64OH+8eX+27n6w5r+5s/ym4XfABrzoon97/DqbWn906n1r5b2yMvrgYv2spj99PXtj5b529zulpzjNUvoZHDmVFz/3anzopX0qJLxloLyr7D3z9H/6Mjxn5////X3s47vjHrqc3Xznn72qobscWHug3X7yKDq0mgUAAATWklEQVR4nO2diULbSBJALbdbKMiRh6AcJsY2GDBHCAu5SHYnk5kkm9nJ///P6uijqvqQbMn2rJeaCRZguvt1VVdVH5I7nQd5kAd5kAf535LbD3cH+3cv3m+6HSuS9x+vRv00SdL+JP3wdtOtaV/eHkySrpRef/Ji0w1qW770NV8ho+ebblK7cnvV6xJJH226UW3K+yvKl0lysulmtSipocFcdt9tul2tyV3fBtjtTk433bKW5HpiB+wmHzfdtJbkg0OFmRKvN922duSRdRTm0t+OqOg00q0x09uRk7C3u+nGtSKPd52E3atNN64VeeF0NNtCuP069I3D0aYb14r4fOnBphvXjnS3PR523qUuwm1JTN156dbMgl86lHi1NUtS45F1JPZfbrph7ckX6xz/ftPNalMem+s0SXe7VhRvR2StbffZdgFmDvXZZKDweunVh003aAVy+/xqN00Gg6Q/2r3bksk9levHd/vPnu9/uN10Qx6kkXzcUvtUcjDqbjfiQT+Lg9uMeJAvaCS97UU8KFdsthfxoK8Stu1EPNBrbv9jiG+vazX3AC4q1jLU69P3pxvviesXB6PRZDK6v/tS8c4DvGpaiXi7v5uVO5n0X24yA7ren4jt+V46evTY99YDuiycdH1rNL/1Rkk53+olo6635FXKiys4I+qNTtxqMQC73cHIifj2BC0K9EbPxysBqJKPdKU3mbjWXSyAecMdiKeThJbc38SinKXVPcfSkhUw33mytvt0Yq7qDEbrdzl3tt2I3sg2cXcAuhC7A8tbB2tf1LGuLWXmtGe+1QloN1TH0uPaD264dq4nhm/3ANoQ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"></a>
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
