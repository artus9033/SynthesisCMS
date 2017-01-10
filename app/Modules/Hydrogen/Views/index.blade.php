@extends('layouts.standalone_module', ['brand_logo' => $page->page_title])

@section('mod_title')
	{{ $page->page_title }}
@endsection

@section('mod_main')
	<div class="row">
	  <div class="col s12 m10 l8 offset-m1 offset-l2">
	    <div class="card teal z-depth-2 hoverable center">
		 <div class="card-content white-text">
		   <span class="card-title col s12"><h3>{{ $page->page_title }}</h3></span>
		   <div class="col s12 row white divider" style="height: 2px;"></div>
		  <h5>{{ $page->page_content }}</h5>
		 </div>
	    </div>
	  </div>
	</div>
	@include('hydrogen::partials/list', ['atoms' => $atoms])
@endsection
