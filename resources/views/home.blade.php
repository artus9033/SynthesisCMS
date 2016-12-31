@extends('layouts.app')

@section('main')
<div class="container">
	@if(Session::has('message'))
		@if(Session::has('message'))
     	    <div class="card-panel col s8 offset-s2 green white-text center" style="height: 45px;">
     	      <h5 class="center">{{ Session::get('message') }}</h5>
     	    </div>
     	@endif
	@endif
</div>
@endsection
