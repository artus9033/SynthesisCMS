@extends('layouts.standalone_extension')

@section('mod_title')
	{{ $page->page_title }}
@endsection

@section('mod_breadcrumbs')
	@if($base_slug != url("/") || $base_slug != "/")
		<a href="{{ url($base_slug) }}"
		   class="breadcrumb">{{ \App\Toolbox::string_truncate($page->page_title, 25) }}</a>
	@endif
@endsection

@section('mod_main')
	@if($extension_instance->showHeader)
		<div class="col s10 offset-s1 card-panel white-text {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} z-depth-2 hoverable center row">
			<h3 class="col s12">{{ $page->page_title }}</h3>
			<div class="col s12 row white divider" style="height: 2px;"></div>
			<h5 class="col s12">{!! $page->page_header !!}</h5>
		</div>
	@endif
	@include('partials/message', ['message' => $extension_instance->applicationConfirmationText])
@endsection
