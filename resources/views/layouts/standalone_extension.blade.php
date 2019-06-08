@extends('layouts.app')

@section('title')
	@yield('mod_title')
@endsection

@section('image')
	@yield('mod_image')
@endsection

@section('breadcrumbs')
	@parent
	@yield('mod_breadcrumbs')
@endsection

@section('main')
	@section('mod_main')
		@parent
	@show
@endsection
