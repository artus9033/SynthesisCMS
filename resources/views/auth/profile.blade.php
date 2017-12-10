@extends('layouts.app')

@section('head')
	<link type="text/css" rel="stylesheet" href="{!! asset('css/login-register.css') !!}"/>
@endsection

@section('title')
	{{ trans('synthesiscms/auth.profile')}}
@endsection

@section('breadcrumbs')
	<a href="{{ route('profile') }}" class="breadcrumb">{{ trans('synthesiscms/main.profile') }}</a>
@endsection

@section('main')
	<div class="col s12 z-depth-1 grey lighten-4 row card @if($synthesiscmsClientIsAnyMobile) no-padding @endif"
		 style="display: inline-block; padding: 0px 48px 0px 48px; border: 1px solid #EEE;">
		<div class="card-content @if($synthesiscmsClientIsAnyMobile) no-padding @endif">
			<div class="card-title col s12">
				<h3 class="{{ $synthesiscmsMainColor }}-text valign-wrapper col s12 @if(\App\SynthesisCMS\API\Auth\UserPrivilegesManager::isContentEditor()) m8 row @endif">
					<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text medium valign">supervisor_account</i>
					&nbsp;{{ trans('synthesiscms/auth.profile') }}
				</h3>
				@if(\App\SynthesisCMS\API\Auth\UserPrivilegesManager::isContentEditor())
					<div class="col s12 m4 valign row">
						<a class="col s12 btn-large {{ $synthesiscmsMainColor }} waves-effect waves-light"
						   href="{{ route('admin') }}"
						   class="btn-large {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} waves-effect waves-light hoverable">
							<i class="material-icons white-text left"
							   style="line-height: unset !important; font-size: 1.8rem;">build</i>
							{{ trans('synthesiscms/menu.admin') }}
						</a>
					</div>
				@endif
			</div>
			<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12"></div>
			<div class="col s12 row"></div>
			<div class="col s12 row">
				<table class="bordered col s12 l7 striped hide-on-small-only">
					<thead>
					<tr>
						<th data-field="id">{{ trans('synthesiscms/profile.id') }}</th>
						<th data-field="name">{{ trans('synthesiscms/profile.name') }}</th>
						<th data-field="email">{{ trans('synthesiscms/profile.email') }}</th>
						<th data-field="rights">{{ trans('synthesiscms/profile.rights') }}</th>
					</tr>
					</thead>

					<tbody>
					<tr>
						<td>{{ \Auth::user()->id }}</td>
						<td>{{ \Auth::user()->name }}</td>
						<td>{{ \Auth::user()->email }}</td>
						<td>@php if(\Auth::user()->is_admin){ echo trans('synthesiscms/profile.admin'); }else{ echo trans('synthesiscms/profile.user'); } @endphp</td>
					</tr>
					</tbody>
				</table>
				<div class="col s12 hide-on-med-and-up">
					<span class="col s12">
						<span class="{{ $synthesiscmsMainColor }}-text">
							{{ trans('synthesiscms/profile.id') }}
						</span>
						{{ \Auth::user()->id }}
					</span>
					<div class="col s12 row divider {{ $synthesiscmsMainColor }}-text"></div>
					<span class="col s12">
						<span class="{{ $synthesiscmsMainColor }}-text">
							{{ trans('synthesiscms/profile.name') }}
						</span>
						{{ \Auth::user()->name }}
					</span>
					<div class="col s12 row divider {{ $synthesiscmsMainColor }}-text"></div>
					<span class="col s12">
						<span class="{{ $synthesiscmsMainColor }}-text">
							{{ trans('synthesiscms/profile.email') }}
						</span>
						{{ \Auth::user()->email }}
					</span>
					<div class="col s12 row divider {{ $synthesiscmsMainColor }}-text"></div>
					<span class="col s12">
						<span class="{{ $synthesiscmsMainColor }}-text">
							{{ trans('synthesiscms/profile.rights') }}
						</span>
						@php
							if(\Auth::user()->is_admin){
								echo trans('synthesiscms/profile.admin');
							}else{
								echo trans('synthesiscms/profile.user');
							}
						@endphp
					</span>
				</div>
				<div class="col s12 l5 row">
					<div class="col s12 row"></div>
					<div class="col s12 l10 offset-l1">
						<a href="{{ url('/profile/password') }}"
						   class="btn btn-large {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} waves-effect waves-light center hoverable col s12 m10 offset-m1">
							<i class="material-icons white-text left">lock_outline</i>
							{{ trans('synthesiscms/profile.change_password') }}
						</a>
					</div>
					<div class="col s12 row"></div>
					<div class="col s12 l10 offset-l1">
						<a href="{{ route('logout') }}"
						   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
						   class="btn btn-large col s12 {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} waves-effect waves-light center hoverable col s12 m10 offset-m1">
							<i class="material-icons white-text left">power_settings_new</i>
							{!! trans('synthesiscms/menu.logout') !!}
						</a>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							{{ csrf_field() }}
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
