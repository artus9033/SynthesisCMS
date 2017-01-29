@extends('layouts.app')

@section('title')
	@yield('mod_title')
@endsection

@section('breadcrumbs')
	@parent
	@yield('mod_breadcrumbs')
@endsection

@section('brand-logo')
	@php if(!isset($brand_logo)): @endphp
	@parent
	@php else: @endphp
	{{ $brand_logo }}
	@php endif; @endphp
@endsection

@section('main')
	<div class="col s12 m12 l12 z-depth-1 grey lighten-4 row card z-depth-5" style="display: inline-block; padding: 0px 48px 0px 48px; border: 1px solid #EEE;">
		<div class="card-content">
			@section('mod_main')
				@parent
			@show
		</div>
	</div>
@endsection
