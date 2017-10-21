@extends('layouts.standalone_extension', ['brand_logo' => $page->page_title])

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
	@php
		use App\Models\Content\Article;
		use App\Extensions\Hydrogen\HydrogenSortingType;
		use App\Extensions\Hydrogen\HydrogenSortingDirection;
		$hasAnyArticlesInside = true;
		$articlesPerPage = $extension_instance->articles_on_single_page;
		$articlesCount = Article::where('articleCategory', $articlesKey)->count();
		if($articlesCount > 0){
			if($articlesCount <= $articlesPerPage){
				if($extension_instance->default_sorting_type == HydrogenSortingType::Alphabetical){
					$order_field = 'title';
				}else if($extension_instance->default_sorting_type == HydrogenSortingType::CreationDate){
					$order_field = 'created_at';
				}else if($extension_instance->default_sorting_type == HydrogenSortingType::ModificationDate){
					$order_field = 'updated_at';
				}

				if($extension_instance->default_sorting_direction == HydrogenSortingDirection::Ascending){
					$order_direction = 'asc';
				}else{
					$order_direction = 'desc';
				}
				$articles = Article::where('articleCategory', $articlesKey)->orderBy($order_field, $order_direction)->get();
			}else{
				$articlesArray = [];
				$chunkCounter = 1;
				$articleCounter = 0;
				foreach(Article::where('articleCategory', $articlesKey)->cursor() as $as){
					if($articleCounter == $articlesPerPage){
						$chunkCounter++;
						$articleCounter = 0;
					}
					if($chunkCounter == $currentPage){
						array_push($articlesArray, $as);
					}
					$articleCounter++;
				}
				$articles = collect($articlesArray);
			}
		}else{
			$hasAnyArticlesInside = false;
		}
	@endphp
	@if(!$hasAnyArticlesInside)
		@include('partials/error', ['error' => trans("Hydrogen::messages.err_no_articles")]);
	@else
		<div class="col s10 offset-s1 card-panel white-text {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} z-depth-2 hoverable center row">
			<h3 class="col s12">{{ $page->page_title }}</h3>
			<div class="col s12 row white divider" style="height: 2px;"></div>
			<h5 class="col s12">{!! $page->page_header !!}</h5>
		</div>
		@php
			$one_column_list = ($extension_instance->list_column_count == 1);
			$two_column_list = ($extension_instance->list_column_count == 2);

			//Override the column count depending on device screen
			if($synthesiscmsClientIsPhone){
				$one_column_list = true;
			}

			if($synthesiscmsClientIsTablet){
				$two_column_list = true;
			}

			if($one_column_list){
				$all = $articles;
			}else if($two_column_list){
				if($articles->count() == 1){
					$one = $articles;
					$two = array();
				}else{
					$one = array();
					$two = array();
					list($one, $two) = $articles->chunk($articles->count() / 2);
				}
			}else{
				if($articles->count() == 1){
					$one = $articles;
					$two = array();
					$three = array();
				}else if($articles->count() == 2){
					$one = array();
					$two = array();
					$three = array();
					list($one, $two) = $articles->chunk($articles->count() / 2);
				}else{
					$one = array();
					$two = array();
					$three = array();
					list($one, $two, $three) = $articles->chunk($articles->count() / 3);
				}
			}
		$hydrogenUidPrefix = "hydrogen-list-";
		@endphp
		<style>
			.card-image.small {
				max-height: 300px !important;
				overflow: hidden;
			}

			.card-image.medium {
				max-height: 400px !important;
				overflow: hidden;
			}

			.card-image.large {
				max-height: 500px !important;
				overflow: hidden;
			}

			.card img {
				transition: all 0.3s ease-in-out;
				max-width: 100%;
				background-color: rgba(0, 0, 0, 0.7);
			}

			.card:hover img {
				transform: scale(1.1, 1.1);
				opacity: 0.8;
			}
		</style>
		@if ($one_column_list)
			<div class="container col s10 offset-s1 row">
				@include('Hydrogen::partials/list', ['articles' => $all, 'hydrogenUid' => $hydrogenUidPrefix . 1])
			</div>
		@elseif($two_column_list)
			<div class="container col s12 m6 row">
				@include('Hydrogen::partials/list', ['articles' => $one, 'hydrogenUid' => $hydrogenUidPrefix . 1])
			</div>
			<div class="container col s12 m6 row">
				@include('Hydrogen::partials/list', ['articles' => $two, 'hydrogenUid' => $hydrogenUidPrefix . 2])
			</div>
		@else
			<div class="container col s12 m6 l4 row">
				@include('Hydrogen::partials/list', ['articles' => $one, 'hydrogenUid' => $hydrogenUidPrefix . 1])
			</div>
			<div class="container col s12 m6 l4 row">
				@include('Hydrogen::partials/list', ['articles' => $two, 'hydrogenUid' => $hydrogenUidPrefix . 2])
			</div>
			<div class="container col s12 m6 l4 row">
				@include('Hydrogen::partials/list', ['articles' => $three, 'hydrogenUid' => $hydrogenUidPrefix . 3])
			</div>
		@endif
		@if($articlesCount > $articlesPerPage)
			<ul class="pagination col s12 row center">
				<li @if($currentPage == 1) class="disabled"
					@else class="waves-effect waves-{{ $synthesiscmsMainColor }} tooltipped" data-position="top"
					data-delay="50" data-tooltip="{{ trans("Hydrogen::hydrogen.first") }}" @endif>
					<a @if($currentPage != 1) href="{{ url($base_slug) }}/p/1" @endif>
						<i class="material-icons">first_page</i>
					</a>
				</li>
				<li @if($currentPage == 1) class="disabled"
					@else class="waves-effect waves-{{ $synthesiscmsMainColor }} tooltipped" data-position="top"
					data-delay="50" data-tooltip="{{ trans("Hydrogen::hydrogen.previous") }}" @endif>
					<a @if($currentPage != 1) href="{{ url($base_slug) }}/p/{{ $currentPage - 1 }}" @endif>
						<i class="material-icons">chevron_left</i>
					</a>
				</li>
				@php
					if(ceil($articlesCount / $articlesPerPage) <= 6){
						$pagination_limit = ceil($articlesCount / $articlesPerPage);
						$pagination_divider = false;
					}else{
						$pagination_limit = 3;
						$pagination_divider = true;
					}
				@endphp
				@for ($i = 1; $i <= $pagination_limit; $i++)
					<li class="waves-effect waves-{{ $synthesiscmsMainColor }} @if($currentPage == $i) {!! $synthesiscmsMainColor !!} lighten-2 @endif">
						<a href="{{ url($base_slug) }}/p/{{ $i }}">{{ $i }}</a>
					</li>
				@endfor
				@if($pagination_divider)
					<span>...</span>
					@for ($i = ceil($articlesCount / $articlesPerPage) + 1 - $pagination_limit; $i <= ceil($articlesCount / $articlesPerPage); $i++)
						<li class="waves-effect waves-{{ $synthesiscmsMainColor }} @if($currentPage == $i) {!! $synthesiscmsMainColor !!} lighten-2 @endif">
							<a href="{{ url($base_slug) }}/p/{{ $i }}">{{ $i }}</a>
						</li>
					@endfor
				@endif
				<li @if($currentPage == ceil($articlesCount / $articlesPerPage)) class="disabled"
					@else class="waves-effect waves-{{ $synthesiscmsMainColor }} tooltipped" data-position="top"
					data-delay="50" data-tooltip="{{ trans("Hydrogen::hydrogen.next") }}" @endif>
					<a @if($currentPage != ceil($articlesCount / $articlesPerPage)) href="{{ url($base_slug) }}/p/{{ $currentPage + 1 }}" @endif>
						<i class="material-icons">chevron_right</i>
					</a>
				</li>
				<li @if($currentPage == ceil($articlesCount / $articlesPerPage)) class="disabled"
					@else class="waves-effect waves-{{ $synthesiscmsMainColor }} tooltipped" data-position="top"
					data-delay="50" data-tooltip="{{ trans("Hydrogen::hydrogen.last") }}" @endif>
					<a @if($currentPage != ceil($articlesCount / $articlesPerPage)) href="{{ url($base_slug) }}/p/{{ ceil($articlesCount / $articlesPerPage) }}" @endif>
						<i class="material-icons">last_page</i>
					</a>
				</li>
			</ul>
		@endif
		@if ($articlesCount == 0)
			@include('partials/error', ['error' => trans("Hydrogen::messages.err_no_articles")])
		@endif
	@endif
@endsection
