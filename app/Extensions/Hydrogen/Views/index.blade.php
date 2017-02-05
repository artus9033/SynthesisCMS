@extends('layouts.standalone_extension', ['brand_logo' => $page->page_title])

@section('mod_title')
	{{ $page->page_title }}
@endsection

@section('mod_breadcrumbs')
	@if($base_slug != url("/") || $base_slug != "/")
		<a href="{{ $base_slug }}" class="breadcrumb">{{ \App\Toolbox::string_truncate($page->page_title, 25) }}</a>
	@endif
@endsection

@section('mod_main')
	<div class="col s10 offset-s1 card-panel white-text {{ $synthesiscmsMainColor }} z-depth-2 hoverable center row">
		<h3 class="col s12">{{ $page->page_title }}</h3>
		<div class="col s12 row white divider" style="height: 2px;"></div>
		<h5 class="col s12">{!! $page->page_header !!}</h5>
	</div>
	@php
	$one_column_list = (\App\Extensions\Hydrogen\Models\HydrogenExtension::where('id', $page->id)->first()->list_column_count == 1);
	if(!$one_column_list){
		$ctr = count($atoms->toArray());
		$one = array();
		$two = array();
		list($one, $two) = array_chunk($atoms->toArray(), ceil(count($atoms->toArray()) / 2));
	}else{
		$ctr = count($atoms->toArray());
		$all = $atoms->toArray();
	}
	@endphp
	@if (!$one_column_list)
		<div class="container col s6 row">
			@include('Hydrogen::partials/list', ['atoms' => $one])
		</div>
		<div class="container col s6 row">
			@include('Hydrogen::partials/list', ['atoms' => $two])
		</div>
	@else
		<div class="container col s10 offset-s1 row">
			@include('Hydrogen::partials/list', ['atoms' => $all])
		</div>
	@endif
	@if ($ctr == 0)
		@include('partials/error', ['error' => trans("Hydrogen::messages.err_no_atoms")])
	@endif
@endsection
