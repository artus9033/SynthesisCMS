@extends('layouts.standalone_module', ['brand_logo' => $page->page_title])

@section('mod_title')
	{{ $page->page_title }}
@endsection

@section('mod_main')
	    <div class="col s10 offset-s1 card-panel white-text teal z-depth-2 hoverable center row">
		   <h3 class="col s12">{{ $page->page_title }}</h3>
		   <div class="col s12 row white divider" style="height: 2px;"></div>
		  <h5 class="col s12">{{ $page->page_header }}</h5>
	    </div>
	    <div class="row">
        <div class="col s12 m6">
          <div class="card">
			@if ($atom->hasImage)
            <div class="card-image">
              <img src="http://materializecss.com/images/sample-1.jpg">
              <span class="card-title">Card Title</span>
              <a class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">add</i></a>
            </div>
	  @endif
            <div class="card-content">
			  @if (!$atom->hasImage)
			  	<span class="card-title">Card Title</span>
				 <a class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">add</i></a>
			  @endif
              <p>I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.</p>
            </div>
          </div>
        </div>
@endsection
