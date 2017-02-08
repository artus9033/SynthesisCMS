@if($model->enabled)
	@if($synthesiscmsPositionManager->getCustom('berylium', 'desktop-menu', Request::url()) != "")
	<nav class="col s12 {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} darken-1 hide-on-med-and-down">
		<div class="nav-wrapper">
			<ul>
				{!! $synthesiscmsPositionManager->getCustom('berylium', 'desktop-menu', Request::url()) !!}
				{!! $synthesiscmsPositionManager->getCustom('berylium', 'menu', Request::url()) !!}
			</ul>
		</div>
	</nav>
	@endif
	<ul id="berylium-mobile-menu" class="side-nav">
	@if (Auth::guest())
							<li class=""><a class="center" href="{{ url('/register') }}"><i class="material-icons white-text left">create</i>{!! trans('synthesiscms/menu.register') !!}</a></li>
							<li class=""><a class="center" href="{{ url('/login') }}"><i class="material-icons white-text left">fingerprint</i>{!! trans('synthesiscms/menu.login') !!}</a></li>
						@else
						<li class="no-padding"> <ul class="collapsible collapsible-accordion"> <li> <a class="collapsible-header"><i class="material-icons white-text left">account_circle</i>{{ Auth::user()->name }}<i class="material-icons">arrow_drop_down</i></a> <div class="collapsible-body"> <ul>
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
								</div>
								</li>
								</ul>
								</li>
						@endif
		{!! $synthesiscmsPositionManager->getCustom('berylium', 'mobile-menu', Request::url()) !!}
		{!! $synthesiscmsPositionManager->getCustom('berylium', 'menu', Request::url()) !!}
	</ul>

	<script>
	$(document).ready(function(){
		$('.berylium-menu-button-collapse').sideNav({
	      menuWidth: 300,
	      edge: 'left',
	      closeOnClick: true,
	      draggable: true
	    }
	  );
	});
	</script>
@endif
