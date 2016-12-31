@extends('layouts.app')

@section('breadcrumbs')
<a href="/profile" class="breadcrumb">{{ trans('synthesiscms/main.profile')}}</a>
@endsection

@section('main')
<div class="container">
	<h1>{{ trans('synthesiscms/auth.profile') }}</h1>
	@if(Session::has('message'))
	    <div class="card-panel col s10 offset-s1 red white-text center">
	      {{ Session::get('message') }}
	    </div>
	@endif
    @foreach($errors as $error)
	    <div class="card-panel col s8 offset-s2 red white-text center" style="height: 45px;">
 		<h5 class="center">{{ $error }}</h5>
 	   </div>
    @endforeach
    <a href="/profile/password" class="btn teal waves-effect waves-light center hoverable">{{ trans('synthesiscms/auth.change_password') }}</a>
</div>
@endsection
