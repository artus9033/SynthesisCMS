@extends('layouts.standalone_extension', ['brand_logo' => $page->page_title])

@section('mod_title')
	{{ $page->page_title }}
@endsection

@section('mod_breadcrumbs')
	@if($base_slug != url("/") || $base_slug != "/")
		<a href="{{ url($base_slug) }}" class="breadcrumb">{{ \App\Toolbox::string_truncate($page->page_title, 25) }}</a>
	@endif
@endsection

@section('mod_main')
	@php
	use App\Models\Content\Atom;
	$atomsCount = Atom::where('molecule', $atomsKey)->count();
	$atomsArray = [];
	$chunkCounter = 0;
	$atomCounter = 0;
	foreach(Atom::where('molecule', $atomsKey)->cursor() as $as){
		$atomCounter++;
		if($atomCounter == 15){
			$chunkCounter++;
			$atomCounter = 0;
		}
		if($chunkCounter == $currentPage){
			array_push($atomsArray, $as);
		}
	}
	$atoms = collect($atomsArray);
	@endphp
	<div class="col s10 offset-s1 card-panel white-text {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} z-depth-2 hoverable center row">
		<h3 class="col s12">{{ $page->page_title }}</h3>
		<div class="col s12 row white divider" style="height: 2px;"></div>
		<h5 class="col s12">{!! $page->page_header !!}</h5>
	</div>
	@php
	$one_column_list = (\App\Extensions\Hydrogen\Models\HydrogenExtension::where('id', $page->id)->first()->list_column_count == 1);
	if(!$one_column_list){
		$one = array();
		$two = array();
		list($one, $two) = array_chunk($atoms->toArray(), ceil(count($atoms->toArray()) / 2));
	}else{
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
	@if($atomsCount > 15)
		<ul class="pagination col s12 row center">
			<li @if($currentPage == 1) class="disabled" @else class="waves-effect waves-{{ $synthesiscmsMainColor }} tooltipped" data-position="top" data-delay="50" data-tooltip="{{ trans("Hydrogen::hydrogen.first") }}" @endif>
				<a @if($currentPage != 1) href="{{ url($base_slug) }}/p/1" @endif>
					<i class="material-icons">first_page</i>
				</a>
			</li>
			<li @if($currentPage == 1) class="disabled" @else class="waves-effect waves-{{ $synthesiscmsMainColor }} tooltipped" data-position="top" data-delay="50" data-tooltip="{{ trans("Hydrogen::hydrogen.previous") }}" @endif>
				<a @if($currentPage != 1) href="{{ url($base_slug) }}/p/{{ $currentPage - 1 }}" @endif>
					<i class="material-icons">chevron_left</i>
				</a>
			</li>
			@for ($i = 1; $i <= round($atomsCount / 15); $i++)
				<li class="waves-effect waves-{{ $synthesiscmsMainColor }} @if($currentPage == $i) active @endif">
					<a href="{{ url($base_slug) }}/p/{{ $i }}">{{ $i }}</a>
				</li>
			@endfor
			<li @if($currentPage == round($atomsCount / 15)) class="disabled" @else class="waves-effect waves-{{ $synthesiscmsMainColor }} tooltipped" data-position="top" data-delay="50" data-tooltip="{{ trans("Hydrogen::hydrogen.next") }}" @endif>
				<a @if($currentPage != round($atomsCount / 15)) href="{{ url($base_slug) }}/p/{{ $currentPage + 1 }}" @endif>
					<i class="material-icons">chevron_right</i>
				</a>
			</li>
			<li @if($currentPage == round($atomsCount / 15)) class="disabled" @else class="waves-effect waves-{{ $synthesiscmsMainColor }} tooltipped" data-position="top" data-delay="50" data-tooltip="{{ trans("Hydrogen::hydrogen.last") }}" @endif>
				<a @if($currentPage != round($atomsCount / 15)) href="{{ url($base_slug) }}/p/{{ round($atomsCount / 15) }}" @endif>
					<i class="material-icons">last_page</i>
				</a>
			</li>
		</ul>
	@endif
	@if ($atomsCount == 0)
		@include('partials/error', ['error' => trans("Hydrogen::messages.err_no_atoms")])
	@endif
@endsection
