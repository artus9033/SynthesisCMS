@extends('layouts.standalone_extension')

@section('mod_title')
	{{ $page->page_title }}
@endsection

@section('mod_image')
	@if($article->hasImage)
		{!! url($article->image) !!}
	@endif
@endsection

@section('mod_breadcrumbs')
	<a title="{!! $page->page_title !!}" href="{{ url($base_slug) }}" class="breadcrumb">{{ \App\Toolbox::string_truncate($page->page_title, 25) }}</a>
	<a title="{!! $article->title !!}" class="breadcrumb">{{ \App\Toolbox::string_truncate($article->title, 25) }}</a>
@endsection

@section('mod_main')
	<article title="{!! $article->title !!}">
		<div id="options" class="modal bottom-sheet">
			<div class="modal-content center col s12">
				<h3 class="col s12">{{ trans('Hydrogen::hydrogen.options_modal_header') }}</h3>
				<div class="col s12">
					<div class="col s12">
						<i onclick="window.print()"
						   class="material-icons card-panel z-depth-2 hoverable medium waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} {{ $synthesiscmsMainColor }}-text tooltipped"
						   data-position="top" data-delay="50"
						   data-tooltip="{{ trans('Hydrogen::hydrogen.options_modal_btn_print') }}">print</i>
						<i onclick="$('<a>').attr('href', 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURI('{!! \URL::current() !!}')).attr('target', '_blank')[0].click();"
						   class="material-icons card-panel z-depth-2 hoverable medium waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} {{ $synthesiscmsMainColor }}-text tooltipped"
						   data-position="top" data-delay="50"
						   data-tooltip="{{ trans('Hydrogen::hydrogen.options_modal_btn_share') }}">share</i>
						<i onclick="SynthesisCmsJsUtils.showToast('{!! trans('Hydrogen::hydrogen.options_modal_toast_link_copied') !!}', 2000)"
						   data-clipboard-text="{{ url()->current() }}"
						   class="copylink material-icons card-panel z-depth-2 hoverable medium waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} {{ $synthesiscmsMainColor }}-text tooltipped"
						   data-position="top" data-delay="50"
						   data-tooltip="{{ trans('Hydrogen::hydrogen.options_modal_btn_copy_link') }}">link</i>
					</div>
					<script>
                        new Clipboard('.copylink');
					</script>
				</div>
			</div>
		</div>
		<script>
            $(document).ready(function () {
                $('.modal').modal();
            });
		</script>

		@if($extension_instance->showHeader)
			<div class="col s10 offset-s1 card-panel white-text {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} z-depth-2 hoverable center row">
				<h1 style="font-size: 2.92rem" class="col s12">{{ $page->page_title }}</h1>
				<div class="col s12 row white divider" style="height: 2px;"></div>
				<h5 class="col s12">{!! $page->page_header !!}</h5>
			</div>
		@endif
		
		<div class="card z-depth-3 col @if($article->hasImage) s12 m12 l12 @else s12 m12 l10 offset-l1 @endif">
			@if($article->hasImage)
				<div class="card-image col s12 m6 l5 row">
					<img src="{{ url($article->image) }}" class="synthesis-cool-image materialboxed"
						 data-caption="{{ $article->title }}">
					<a style="position: absolute; top: 10%; right: -15px;"
					   onclick="$('#options').modal('open');"
					   class="halfway-fab btn-floating btn-large waves-effect waves-light {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} z-depth-2">
						<i class="material-icons">more_vert</i>
					</a>
				</div>
			@else
				<a style="position: absolute; right: 5%; top: 5%;"
				   onclick="$('#options').modal('open');"
				   class="btn-floating btn-large waves-effect waves-light {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} z-depth-2">
					<i class="material-icons">more_vert</i>
				</a>
			@endif
			<div class="card-content col @if($article->hasImage) s12 m6 l7 @else s12 m12 l12 @endif">
				<h4 class="{{ $synthesiscmsMainColor }}-text col s12">
					{{ $article->title }}
				</h4>
				<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12"
					 style="margin-top: 10px; margin-bottom: 10px;"></div>
				<div class="col s12">
						<span>
							<i class="material-icons {{ $synthesiscmsMainColor }}-text">perm_identity</i>
							{{ $article->getPublisher() }}
						</span>
					&nbsp;&nbsp;
					<span>
							<i class="material-icons {{ $synthesiscmsMainColor }}-text">today</i>
						{{ \Carbon\Carbon::parse($article->created_at)->toDateString() }}
						</span>
					&nbsp;&nbsp;
					<span>
							<i class="material-icons {{ $synthesiscmsMainColor }}-text">local_offer</i>
						{!! trans('Hydrogen::hydrogen.tags') !!}
						@php($tagsCount = 0)
						@foreach($article->tags as $tag)
							@php($tagsCount++)
							<div class="chip">
									{!! $tag->name !!}
								</div>
						@endforeach
						@if($tagsCount == 0)
							<div class="chip">
									{!! trans('Hydrogen::hydrogen.no_tags') !!}
								</div>
						@endif
						</span>
					<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12"
						 style="margin-top: 10px; margin-bottom: 10px;"></div>
					<div class="flow-text">
						{!! $article->description !!}
					</div>
				</div>
			</div>
		</div>
	</article>
@endsection
