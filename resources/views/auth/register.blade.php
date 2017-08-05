@extends('layouts.app')

@section('title')
	{{ trans('synthesiscms/auth.registration')}}
@endsection

@section('head')
	<link type="text/css" rel="stylesheet" href="{!! asset('css/login-register.css') !!}"/>
@endsection

@section('breadcrumbs')
	<a href="{{ url('/register') }}" class="breadcrumb">{{ trans('synthesiscms/auth.registration')}}</a>
@endsection

@section('main')
	<div class="col s6 offset-s3 z-depth-1 grey lighten-4 row card"
		 style="display: inline-block; padding: 0px 48px 0px 48px; border: 1px solid #EEE;">
		<div class="card-content">
			<div class="card-title">
				<h3 class="{{ $synthesiscmsMainColor }}-text center">{{ trans('synthesiscms/auth.registration')}}</h3>
			</div>
			<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12"></div>
			<form class="form-horizontal col s12" role="form" method="POST" action="{{ url('/register') }}">
				{{ csrf_field() }}
				<div class='row'></div>
				<div class='row'>
					@if ($errors->has('name'))
						<h5 class="red-text center">
							<strong>{{ $errors->first('name') }}</strong>
						</h5>
					@endif
					<div class='input-field col s12'>
						<i class="material-icons {{ $synthesiscmsMainColor }}-text prefix">perm_identity</i>
						<input class='validate' type='text' name='name' id='name' value="{{ old('name') }}" required/>
						<label for='name' data-error="{{ trans('synthesiscms/auth.name_bad')}}"
							   data-success="{{ trans('synthesiscms/auth.name_ok')}}">{{ trans('synthesiscms/auth.name')}}</label>
					</div>
				</div>
				<div class='row'>
					@if ($errors->has('email'))
						<h5 class="red-text center">
							<strong>{{ $errors->first('email') }}</strong>
						</h5>
					@endif
					<div class='input-field col s12'>
						<i class="material-icons {{ $synthesiscmsMainColor }}-text prefix">mail_outline</i>
						<input class='validate' type='email' name='email' id='email' value="{{ old('email') }}"
							   required/>
						<label for='email' data-error="{{ trans('synthesiscms/auth.email_bad')}}"
							   data-success="{{ trans('synthesiscms/auth.email_ok')}}">{{ trans('synthesiscms/auth.email')}}</label>
					</div>
				</div>
				<div class='row'>
					@if ($errors->has('password'))
						<h5 class="red-text center">
							<strong>{{ $errors->first('password') }}</strong>
						</h5>
					@endif
					<div class='input-field col s12'>
						<i class="material-icons {{ $synthesiscmsMainColor }}-text prefix">lock_outline</i>
						<input class='validate' type='password' name='password' id='password'
							   value="{{ old('password') }}" required/>
						<label for='password' data-error="{{ trans('synthesiscms/auth.password_bad')}}"
							   data-success="{{ trans('synthesiscms/auth.password_ok')}}">{{ trans('synthesiscms/auth.password')}}</label>
					</div>
				</div>
				<div class='row'>
					<div class='input-field col s12'>
						<i class="material-icons {{ $synthesiscmsMainColor }}-text prefix">lock_outline</i>
						<input class='validate' type='password' name='password_confirmation' id='password_confirmation'
							   required/>
						<label for='password_confirmation' data-error="{{ trans('synthesiscms/auth.password_bad')}}"
							   data-success="{{ trans('synthesiscms/auth.password_ok')}}">{{ trans('synthesiscms/auth.password')}}</label>
					</div>
					<div class="row"></div>
					<button type='submit' name='btn_login'
							class='col s12 btn btn-large waves-effect waves-light {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} hoverable'>{{ trans('synthesiscms/auth.register')}}</button>
				</div>
			</form>
		</div>
		<div class="card-action col s12 row center">
			<a class="center {{ $synthesiscmsMainColor }}-text darken-1"
			   href="{{ url('/login') }}">{{ trans('synthesiscms/auth.login')}}</a>
		</div>
	</div>
@endsection
