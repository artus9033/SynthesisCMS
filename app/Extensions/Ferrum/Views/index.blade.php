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
			<h1 class="col s12">{{ $page->page_title }}</h1>
			<div class="col s12 row white divider" style="height: 2px;"></div>
			<h5 class="col s12">{!! $page->page_header !!}</h5>
		</div>
	@endif
	@php
		use App\Extensions\Ferrum\FerrumIdManager;

		$ferrumIdManager = new FerrumIdManager();
		$parsedJson = json_decode($formInJson);
		$base_href = "";
		if($base_slug != url("/") || $base_slug != "/"){
			$base_href = url($base_slug);
		}
	@endphp
	<form action="{{ $base_href . '/apply' }}" class="col s12 row" method="POST">
		{{ csrf_field() }}
		@php($ctr = 0)
		@if($parsedJson)
			@foreach($parsedJson as $node)
				@php($ctr++)
				@if($node->elementType == "ferrum-label-element")
					@include('Ferrum::items/labelTitle', ['mode' => 'frontend-show-item', 'ferrumIdManagerInstance' => $ferrumIdManager, 'itemTitle' => $node->elementValuesArray[0]])
				@endif
				@if($node->elementType == "ferrum-label-with-description-element")
					@include('Ferrum::items/labelWithDescription', ['mode' => 'frontend-show-item', 'ferrumIdManagerInstance' => $ferrumIdManager, 'itemTitle' => $node->elementValuesArray[0], 'itemDescription' => $node->elementValuesArray[1]])
				@endif
				@if($node->elementType == "ferrum-text-input-with-hint-element")
					@include('Ferrum::items/textInput', ['mode' => 'frontend-show-item', 'ferrumIdManagerInstance' => $ferrumIdManager, 'itemInputLabel' => $node->elementValuesArray[0]])
				@endif
				@if($node->elementType == "ferrum-number-input-with-hint-element")
					@include('Ferrum::items/numberInput', ['mode' => 'frontend-show-item', 'ferrumIdManagerInstance' => $ferrumIdManager, 'itemInputLabel' => $node->elementValuesArray[0]])
				@endif
			@endforeach
		@endif
		<input style="display: none;" value="{!! $ferrumIdManager->ferrumGetAllIdsArrayImploded() !!}"
			   name="ferrum-all-form-ids-jsonified">
		@if($ctr > 0)
			<button class="btn-large {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text waves-effect waves-light col s12 m6 offset-m3 l2 offset-l5 center row"
					type="submit" name="action">
				{{ $extension_instance->submitButtonText }}
				<i class="material-icons right">send</i>
			</button>
		@else
			@include('partials/error', ['error' => trans('Ferrum::messages.msg_no_items')])
		@endif
	</form>
@endsection
