@extends('layouts.app')

@section('head')
	<link type="text/css" rel="stylesheet" href="{!! asset('css/login-register.css') !!}"/>
@endsection

@section('title')
	{{ trans('synthesiscms/auth.profile')}}
@endsection

@section('breadcrumbs')
	<a href="{{ url('/profile') }}" class="breadcrumb">{{ trans('synthesiscms/main.profile') }}</a>
@endsection

@section('main')
	<div class="col s12 z-depth-1 grey lighten-4 row card" style="display: inline-block; padding: 0px 48px 0px 48px; border: 1px solid #EEE;">
		<div class="card-content">
			<div class="card-title col s12">
				<h3 class="{{ $synthesiscmsMainColor }}-text valign-wrapper"><i class="material-icons prefix {{ $synthesiscmsMainColor }}-text medium valign">supervisor_account</i>&nbsp;{{ trans('synthesiscms/auth.profile') }}</h5>
				</div>
				<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12"></div>
				<div class="col s12 row"></div>
				<div class="col s12 row">
					<table class="bordered col s7 striped responsive-table">
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
					<div class="col s5 row">
						<div class="col s10 offset-s1">
							<a href="{{ url('/profile/password') }}" class="btn btn-large {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} waves-effect waves-light center hoverable col s12"><i class="material-icons white-text left">lock_outline</i>{{ trans('synthesiscms/profile.change_password') }}</a>
						</div>
						<div class="col s12 row"></div>
						<div class="col s10 offset-s1">
							<a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-large col s12 {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} waves-effect waves-light center hoverable"><i class="material-icons white-text left">power_settings_new</i>{!! trans('synthesiscms/menu.logout') !!}</a>
							<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
								{{ csrf_field() }}
							</form>
						</div>
					</div>
				</div>
				<div class="col s12 row"></div>
			</div>
		</div>
	@endsection
