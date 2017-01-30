@extends('layouts.standalone_module', ['brand_logo' => $page->page_title])

@section('mod_title')
	{{ $page->page_title }}
@endsection

@section('mod_breadcrumbs')
	@if($base_slug != "/")
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
		$ctr = count($atoms->toArray());
		$one = array();
		$two = array();
		list($one, $two) = array_chunk($atoms->toArray(), ceil(count($atoms->toArray()) / 2));
	    @endphp

	    <div class="container col s6 row">
		    @include('hydrogen::partials/list', ['atoms' => $one])
	    </div>
	    <div class="container col s6 row">
		    @include('hydrogen::partials/list', ['atoms' => $two])
	    </div>
	    @if ($ctr == 0)
	    	@include('partials/error', ['error' => trans("hydrogen::messages.err_no_atoms")])
	    @endif
@endsection
