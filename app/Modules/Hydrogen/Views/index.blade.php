@extends('layouts.standalone_module', ['brand_logo' => $page->page_title])

@section('mod_title')
	{{ $page->page_title }}
@endsection

@section('mod_breadcrumbs')
	<a href="{{ $base_slug }}" class="breadcrumb">{{ \App\Toolbox::string_truncate($page->page_title, 25) }}</a>
@endsection

@section('mod_main')
	    <div class="col s10 offset-s1 card-panel white-text {{ $synthesiscmsMainColor }} z-depth-2 hoverable center row">
		   <h3 class="col s12">{{ $page->page_title }}</h3>
		   <div class="col s12 row white divider" style="height: 2px;"></div>
		  <h5 class="col s12">{{ $page->page_header }}</h5>
	    </div>
		    @include('hydrogen::partials/list', ['atoms' => $atoms])
@endsection
