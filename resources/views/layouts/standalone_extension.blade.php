@extends('layouts.app')

@section('title')
	@yield('mod_title')
@endsection

@section('breadcrumbs')
	@parent
	@yield('mod_breadcrumbs')
@endsection

@section('main')
	@if(!$synthesiscmsClientIsAnyMobile)
		<div class="col s12 m12 l12 z-depth-1 grey lighten-4 row card z-depth-5"
			 style="display: inline-block; padding: 0px 48px 0px 48px; border: 1px solid #EEE;">
			<div class="card-content">
				@endif
				@section('mod_main')
					@parent
				@show
				@if(!$synthesiscmsClientIsAnyMobile)
			</div>
		</div>
	@endif
@endsection
