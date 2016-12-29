@extends('layouts.error')

@section('title', '404')

@section('body')
	<div class="red col s12 valign-wrapper" style="height: 100vh;">
		<div class="white center col s12 white red-text valign">
			<div class="col s12 center">
			<h2 class="center col s12">
				{{ trans('synthesiscms/errors.404_header') }}
			</h2>
			<div class="divider white red col s10 offset-s1"></div>
			<h5 class="red-text center">{{ trans('synthesiscms/errors.404_desc') }}</h5>
		</div>
		</div>
@endsection
