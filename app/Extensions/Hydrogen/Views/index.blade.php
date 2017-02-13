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
	$atomsPerPage = $extension_instance->atoms_on_single_page;
	$atomsCount = Atom::where('molecule', $atomsKey)->count();
	if($atomsCount <= $atomsPerPage){
		$atoms = Atom::where('molecule', $atomsKey)->get();
	}else{
		$atomsArray = [];
		$chunkCounter = 1;
		$atomCounter = 0;
		foreach(Atom::where('molecule', $atomsKey)->cursor() as $as){
			if($atomCounter == $atomsPerPage){
				$chunkCounter++;
				$atomCounter = 0;
			}
			if($chunkCounter == $currentPage){
				array_push($atomsArray, $as);
			}
			$atomCounter++;
		}
		$atoms = collect($atomsArray);
	}
	@endphp
	<div class="col s10 offset-s1 card-panel white-text {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} z-depth-2 hoverable center row">
		<h3 class="col s12">{{ $page->page_title }}</h3>
		<div class="col s12 row white divider" style="height: 2px;"></div>
		<h5 class="col s12">{!! $page->page_header !!}</h5>
	</div>
	@php
	$one_column_list = ($extension_instance->list_column_count == 1);
	if(!$one_column_list){
		if($atoms->count() == 1){
			$one = $atoms->toArray();
			$two = array();
		}else{
			$one = array();
			$two = array();
			list($one, $two) = array_chunk($atoms->toArray(), ceil(count($atoms->toArray()) / 2));
		}
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
	@if($atomsCount > $atomsPerPage)
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
			@php
			if(ceil($atomsCount / $atomsPerPage) <= 6){
				$pagination_limit = ceil($atomsCount / $atomsPerPage);
				$pagination_divider = false;
			}else{
				$pagination_limit = 3;
				$pagination_divider = true;
			}
			@endphp
			@for ($i = 1; $i <= $pagination_limit; $i++)
				<li class="waves-effect waves-{{ $synthesiscmsMainColor }} @if($currentPage == $i) active @endif">
					<a href="{{ url($base_slug) }}/p/{{ $i }}">{{ $i }}</a>
				</li>
			@endfor
			@if($pagination_divider)
				<span>...</span>
				@for ($i = ceil($atomsCount / $atomsPerPage) + 1 - $pagination_limit; $i <= ceil($atomsCount / $atomsPerPage); $i++)
				<li class="waves-effect waves-{{ $synthesiscmsMainColor }} @if($currentPage == $i) active @endif">
					<a href="{{ url($base_slug) }}/p/{{ $i }}">{{ $i }}</a>
				</li>
				@endfor
			@endif
			<li @if($currentPage == ceil($atomsCount / $atomsPerPage)) class="disabled" @else class="waves-effect waves-{{ $synthesiscmsMainColor }} tooltipped" data-position="top" data-delay="50" data-tooltip="{{ trans("Hydrogen::hydrogen.next") }}" @endif>
				<a @if($currentPage != ceil($atomsCount / $atomsPerPage)) href="{{ url($base_slug) }}/p/{{ $currentPage + 1 }}" @endif>
					<i class="material-icons">chevron_right</i>
				</a>
			</li>
			<li @if($currentPage == ceil($atomsCount / $atomsPerPage)) class="disabled" @else class="waves-effect waves-{{ $synthesiscmsMainColor }} tooltipped" data-position="top" data-delay="50" data-tooltip="{{ trans("Hydrogen::hydrogen.last") }}" @endif>
				<a @if($currentPage != ceil($atomsCount / $atomsPerPage)) href="{{ url($base_slug) }}/p/{{ ceil($atomsCount / $atomsPerPage) }}" @endif>
					<i class="material-icons">last_page</i>
				</a>
			</li>
		</ul>
	@endif
	@if ($atomsCount == 0)
		@include('partials/error', ['error' => trans("Hydrogen::messages.err_no_atoms")])
	@endif
@endsection
