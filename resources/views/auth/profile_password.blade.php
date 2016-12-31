@extends('layouts.app')

@section('breadcrumbs')
<a href="/profile" class="breadcrumb">{{ trans('synthesiscms/main.profile')}}</a>
<a href="/profile/password" class="breadcrumb">{{ trans('synthesiscms/main.profile_change_password')}}</a>
@endsection

@section('main')
<div class="container">
	<h1>{{ trans('synthesiscms/auth.change_password') }}</h1>
	@if(Session::has('message'))
	    <div class="card-panel col s8 offset-s2 green white-text center" style="height: 45px;">
	      <h5 class="center">{{ Session::get('message') }}</h5>
	    </div>
	@endif
    @foreach($errors as $error)
	    <div class="card-panel col s8 offset-s2 red white-text center" style="height: 45px;">
 		<h5 class="center">{{ $error }}</h5>
 	   </div>
    @endforeach

{!! Form::open(array('route' => 'profile', 'class' => 'form')) !!}

<div class="input-field col s6">
    <label for="newpassword">{{ trans('synthesiscms/auth.newpassword') }}</label>
    <input id="newpassword2" name="newpassword2" type="password" value="">
</div>

<div class="input-field col s6">
	<label for="newpassword2">{{ trans('synthesiscms/auth.newpassword2') }}</label>
    <input id="newpassword" name="newpassword" type="password" value="">
</div>

<div class="input-field col s12">
    <label for="oldpassword">{{ trans('synthesiscms/auth.oldpassword') }}</label>
    <input id="oldpassword" name="oldpassword" type="password" value="">
</div>
<button type="submit" class="btn teal waves-effect waves-light center hoverable">{{ trans('synthesiscms/auth.change_password_btn') }}</button>
{!! Form::close() !!}
</div>
@endsection
