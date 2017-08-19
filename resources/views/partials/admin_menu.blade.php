<li class="no-padding">
	<div class="userView" style="margin-bottom: unset !important;">
		<div class="background">
			<img src="{!! asset('img/office.jpg') !!}">
		</div>
		<a href="{{ route('profile') }}">
			<img class="circle" src="{!! asset('img/cms-icon.png') !!}">
		</a>
		<a href="{{ route('profile') }}">
				<span class="white-text name truncate">
				@if(Auth::guest())
						{{ trans('synthesiscms/helper.guest_username') }}
					@else
						{{ Auth::user()->name }}
					@endif
				</span>
		</a>
		<a href="{{ route('profile') }}">
				<span class="white-text email truncate">
					@if(Auth::guest())
						{{ trans('synthesiscms/helper.guest_email') }}
					@else
						{{ Auth::user()->email }}
					@endif
				</span>
		</a>
	</div>
</li>
<li class="bold">
	<a href="{{ route('admin') }}"
	   class="collapsible-header {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text waves-effect waves-light">
		<i class="material-icons white-text">dashboard</i>
		{{ trans('synthesiscms/admin.backend') }}
	</a>
</li>
@if($adminMenuIsMobile)
	<li class="no-padding col s12 waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}">
		<ul class="collapsible collapsible-accordion no-padding col s12">
			<li class="no-padding col s12">
				<a class="collapsible-header {{ $synthesiscmsMainColor }}-text {{ $synthesiscmsMainColorClass }} no-padding col s12">
					<i class="material-icons left {{ $synthesiscmsMainColor }}-text {{ $synthesiscmsMainColorClass }}">account_circle</i>
					{{ Auth::user()->name }}
					<i class="material-icons right {{ $synthesiscmsMainColor }}-text {{ $synthesiscmsMainColorClass }}">arrow_drop_down</i>
				</a>
				<div class="collapsible-body no-padding col s12">
					<ul>
						<li>
							@if(Auth::user()->is_admin)
								<a class="{{ $synthesiscmsMainColor }}-text waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}"
								   href="{{ route('admin') }}">
									<i class="material-icons {{ $synthesiscmsMainColor }}-text left">build</i>{!! trans('synthesiscms/menu.admin') !!}
								</a>
							@endif
							<a class="{{ $synthesiscmsMainColor }}-text" href="{{ route('profile') }}">
								<i class="material-icons {{ $synthesiscmsMainColor }}-text left">perm_identity</i>{!! trans('synthesiscms/menu.profile') !!}
							</a>
							<a class="{{ $synthesiscmsMainColor }}-text" href="{{ route('logout') }}"
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
	</li>
@endif
<ul class="collapsible collapsible-accordion">
	<li class="bold">
		<a class="collapsible-header waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}">
			<i class="material-icons {{ $synthesiscmsMainColor }}-text">description</i>{{ trans('synthesiscms/admin.section_content') }}
		</a>
		<div class="collapsible-body" style="padding: unset !important;">
			<ul>
				<li class="" id="manage_articles">
					<a class="waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}"
					   href="{{ url('/admin/manage_articles') }}">{{ trans('synthesiscms/admin.manage_articles') }}</a>
				</li>
				<li class="" id="manage_article_categories">
					<a class="waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}"
					   href="{{ url('/admin/manage_article_categories') }}">{{ trans('synthesiscms/admin.manage_article_categories') }}</a>
				</li>
			</ul>
		</div>
	</li>
	<li class="bold">
		<a class="collapsible-header waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}">
			<i class="material-icons {{ $synthesiscmsMainColor }}-text">supervisor_account</i>{{ trans('synthesiscms/admin.section_users') }}
		</a>
		<div class="collapsible-body" style="padding: unset !important;">
			<ul>
				<li class="" id="profile">
					<a class="waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}"
					   href="{{ route('profile') }}">{{ trans('synthesiscms/profile.profile') }}</a>
				</li>
				<li class="" id="manage_users">
					<a class="waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}"
					   href="{{ url('/admin/manage_users') }}">{{ trans('synthesiscms/admin.manage_users') }}</a>
				</li>
			</ul>
		</div>
	</li>
	<li class="bold">
		<a class="collapsible-header waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}">
			<i class="material-icons {{ $synthesiscmsMainColor }}-text">pages</i>{{ trans('synthesiscms/admin.section_routes') }}
		</a>
		<div class="collapsible-body" style="padding: unset !important;">
			<ul>
				<li class="" id="manage_routes">
					<a class="waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}"
					   href="{{ url('/admin/manage_routes') }}">{{ trans('synthesiscms/admin.manage_routes') }}</a>
				</li>
				<li class="" id="manage_applets">
					<a class="waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}"
					   href="{{ url('/admin/manage_applets') }}">{{ trans('synthesiscms/admin.manage_applets') }}</a>
				</li>
			</ul>
		</div>
	</li>
	<li class="bold">
		<a class="collapsible-header waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}">
			<i class="material-icons {{ $synthesiscmsMainColor }}-text">settings</i>{{ trans('synthesiscms/admin.section_settings') }}
		</a>
		<div class="collapsible-body" style="padding: unset !important;">
			<ul>
				<li class="" id="settings">
					<a class="waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}"
					   href="{{ url('/admin/settings') }}">{{ trans('synthesiscms/admin.settings') }}</a>
				</li>
			</ul>
		</div>
	</li>
</ul>
</li>