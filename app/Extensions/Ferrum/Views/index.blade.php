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
	<div id="options" class="modal bottom-sheet" style="height: 100vh;">
		<div class="modal-content center col s12">
			<h4 class="col s12">{{ trans('Ferrum::ferrum.options_modal_header') }}</h4>
			<div class="col s12">
				<div class="col s12">
					<i onclick="window.print()"
					   class="material-icons card-panel z-depth-2 hoverable medium waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} {{ $synthesiscmsMainColor }}-text tooltipped"
					   data-position="top" data-delay="50"
					   data-tooltip="{{ trans('Ferrum::ferrum.options_modal_btn_print') }}">print</i>
					<i class="material-icons card-panel z-depth-2 hoverable medium waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} {{ $synthesiscmsMainColor }}-text tooltipped"
					   data-position="top" data-delay="50"
					   data-tooltip="{{ trans('Ferrum::ferrum.options_modal_btn_share') }}">share</i>
					<i data-clipboard-text="{{ url()->current() }}"
					   class="material-icons card-panel z-depth-2 hoverable medium waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} {{ $synthesiscmsMainColor }}-text tooltipped"
					   data-position="top" data-delay="50"
					   data-tooltip="{{ trans('Ferrum::ferrum.options_modal_btn_copy_link') }}">link</i>
				</div>
				<script>
                    new Clipboard('.copylink');
				</script>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#!"
			   class="modal-action modal-close waves-effect waves-yellow btn-flat">{{ trans('Ferrum::ferrum.options_modal_btn_cancel') }}</a>
		</div>
	</div>
	<script>
        $(document).ready(function () {
            $('.modal').modal();
        });
	</script>
	@if($extension_instance->showHeader)
		<div class="col s10 offset-s1 card-panel white-text {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} z-depth-2 hoverable center row">
			<h3 class="col s12">{{ $page->page_title }}</h3>
			<div class="col s12 row white divider" style="height: 2px;"></div>
			<h5 class="col s12">{!! $page->page_header !!}</h5>
		</div>
	@endif
	<div class="row">
		<div class="col s10 offset-s1">
			<div class="card z-depth-3">
				@if ($article->hasImage)
					<div class="card-image">
						<img src="{{ $article->image }}">
						<span class="card-title left card-panel white {{ $synthesiscmsMainColor }}-text z-depth-2"
							  style="margin: 10px 10px 10px 10px; font-weight: 400;">{{ $article->title }}</span>
						<a onclick="$('#options').modal('open');"
						   class="btn-floating btn-large halfway-fab waves-effect waves-light {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} z-depth-2"><i
									class="material-icons">more_horiz</i></a>
					</div>
				@endif
				<div class="card-content">
					@if (!$article->hasImage)
						<span class="card-title" style="font-weight: 400; display: inline;">{{ $article->title }}</span>
						<a onclick="$('#options').modal('open');"
						   class="btn-floating waves-effect waves-light {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} z-depth-2 right"><i
									class="material-icons">more_horiz</i></a>
						<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12"
							 style="margin-top: 10px; margin-bottom: 10px;"></div>
					@endif
					{!! $article->description !!}
				</div>
			</div>
		</div>
@endsection