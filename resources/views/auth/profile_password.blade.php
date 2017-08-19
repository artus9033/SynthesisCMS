@extends('layouts.app')

@section('head')
	<link type="text/css" rel="stylesheet" href="{!! asset('css/login-register.css') !!}"/>
@endsection

@section('title')
	{{ trans('synthesiscms/auth.change_password')}}
@endsection

@section('breadcrumbs')
	<a href="{{ route('profile') }}" class="breadcrumb">{{ trans('synthesiscms/main.profile')}}</a>
	<a href="{{ url('/profile/password') }}"
	   class="breadcrumb">{{ trans('synthesiscms/main.profile_change_password')}}</a>
@endsection

@section('main')
	<div class="card col s12 m10 offset-m1 z-depth-2">
		<div class="card-content center">
			<div class="card-title {{ $synthesiscmsMainColor }}-text valign-wrapper">
				<h1 class=" valign valign-wrapper">
					<i class="material-icons {{ $synthesiscmsMainColor }}-text medium valign">account_circle</i>
					&nbsp;{{ trans('synthesiscms/auth.change_password') }}
				</h1>
			</div>
			<div class="col s12 row {{ $synthesiscmsMainColor }} divider"></div>
			<form id="form" class="col s12 row" method="post" action="">
				{{ csrf_field() }}
				<div class="input-field col s6">
					<i class="material-icons {{ $synthesiscmsMainColor }}-text prefix">lock_outline</i>
					<label for="newpassword">{{ trans('synthesiscms/auth.newpassword') }}</label>
					<input id="newpassword2" name="newpassword2" type="password" value="">
				</div>
				<div class="input-field col s6">
					<i class="material-icons {{ $synthesiscmsMainColor }}-text prefix">lock_outline</i>
					<label for="newpassword2">{{ trans('synthesiscms/auth.newpassword2') }}</label>
					<input id="newpassword" name="newpassword" type="password" value="">
				</div>
				<div class="input-field col s12">
					<i class="material-icons {{ $synthesiscmsMainColor }}-text prefix">security</i>
					<label for="oldpassword">{{ trans('synthesiscms/auth.oldpassword') }}</label>
					<input id="oldpassword" name="oldpassword" type="password" value="">
				</div>
				<div class="col s12 row">
					<button type="submit"
							class="btn btn-large {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} waves-effect waves-light center hoverable">
						<i class="material-icons white-text left">phonelink_lock</i>{{ trans('synthesiscms/auth.change_password_btn') }}
					</button>
				</div>
			</form>
		</div>
	</div>
@endsection
