@extends('layouts.app')

@section('head')
<link type="text/css" rel="stylesheet" href="{!! asset('css/login-register.css') !!}"/>
@endsection

@section('title')
	{{ trans('synthesiscms/auth.change_password')}}
@endsection

@section('breadcrumbs')
<a href="/profile" class="breadcrumb">{{ trans('synthesiscms/main.profile')}}</a>
<a href="/profile/password" class="breadcrumb">{{ trans('synthesiscms/main.profile_change_password')}}</a>
@endsection

@section('main')
<div class="container">
	<h1>{{ trans('synthesiscms/auth.change_password') }}</h1>

{!! Form::open(array('route' => 'profile', 'class' => 'form')) !!}

<div class="input-field col s6">
	<i class="material-icons teal-text prefix">lock</i>
    <label for="newpassword">{{ trans('synthesiscms/auth.newpassword') }}</label>
    <input id="newpassword2" name="newpassword2" type="password" value="">
</div>

<div class="input-field col s6">
	<i class="material-icons teal-text prefix">lock_outline</i>
	<label for="newpassword2">{{ trans('synthesiscms/auth.newpassword2') }}</label>
    <input id="newpassword" name="newpassword" type="password" value="">
</div>

<div class="input-field col s12">
	<i class="material-icons teal-text prefix">security</i>
    <label for="oldpassword">{{ trans('synthesiscms/auth.oldpassword') }}</label>
    <input id="oldpassword" name="oldpassword" type="password" value="">
</div>
<div class="col s12 row">
<button type="submit" class="btn btn-large teal waves-effect waves-light center hoverable"><i class="material-icons white-text left">phonelink_lock</i>{{ trans('synthesiscms/auth.change_password_btn') }}</button>
</div>
{!! Form::close() !!}
</div>
@endsection
