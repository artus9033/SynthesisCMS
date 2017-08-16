@extends('layouts.app')

@section('title')
	{{ trans('synthesiscms/auth.login')}}
@endsection

@section('head')
	<link type="text/css" rel="stylesheet" href="{!! asset('css/login-register.css') !!}"/>
@endsection

@section('breadcrumbs')
	<a href="{{ url('/login') }}" class="breadcrumb">{{ trans('synthesiscms/main.login')}}</a>
@endsection

@section('main')
	<style>
		@media screen and (min-device-width: 1200px) {
			div .main-carf-cont {
				padding: 0px 48px 0px 48px;
			}
		}
	</style>
	@if ($errors->has('email'))
		@include('partials/error', ['error' => $errors->first('email')])
	@endif
	@if ($errors->has('password'))
		<h5 class="red-text center">
			@include('partials/error', ['error' => $errors->first('password')])
		</h5>
	@endif
	<div class="main-card-cont col s12 l6 offset-l3 z-depth-1 grey lighten-4 row card"
		 style="display: inline-block; border: 1px solid #EEE;">
		<div class="card-content">
			<div class="card-title">
				<h3 class="{{ $synthesiscmsMainColor }}-text center">{{ trans('synthesiscms/auth.login')}}</h3>
			</div>
			<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12"></div>
			<form class="form-horizontal col s12" role="form" method="POST" action="{{ url('/login') }}">
				{{ csrf_field() }}
				<div class='row'>
					<div class='input-field col s12'>
						<i class="material-icons {{ $synthesiscmsMainColor }}-text prefix">account_circle</i>
						<input class='validate' type='email' name='email' id='email'/>
						<label for='email' data-error="{{ trans('synthesiscms/auth.email_bad')}}"
							   data-success="{{ trans('synthesiscms/auth.email_ok')}}">{{ trans('synthesiscms/auth.email')}}</label>
					</div>
				</div>
				<div class='row'>
					<div class='input-field col s12'>
						<i class="material-icons {{ $synthesiscmsMainColor }}-text prefix">lock_outline</i>
						<input class='validate' type='password' name='password' id='password'/>
						<label for='password' data-error="{{ trans('synthesiscms/auth.password_bad')}}"
							   data-success="{{ trans('synthesiscms/auth.password_ok')}}">{{ trans('synthesiscms/auth.password')}}</label>
					</div>
					<div class="col s12">
						<p>
							<input class="filled-in" type="checkbox" id="remember" name="remember" checked="checked">
							<label for="remember">{{ trans('synthesiscms/auth.remember')}}</label>
						</p>
					</div>
					<div class="row"></div>
					<button type='submit' name='btn_login'
							class='col s12 btn btn-large waves-effect waves-light {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} hoverable'>{{ trans('synthesiscms/auth.login_btn')}}</button>
				</div>
			</form>
		</div>
		<div class="card-action col s12 row center">
			<a class="col s4 offset-s2 center {{ $synthesiscmsMainColor }}-text darken-1"
			   href="{{ url('/register') }}">{{ trans('synthesiscms/auth.register')}}</a>
			<a class="col s4 center {{ $synthesiscmsMainColor }}-text darken-1"
			   href="{{ url('/password/reset') }}">{{ trans('synthesiscms/auth.reset')}}</a>
		</div>
	</div>
@endsection
