@extends('layouts/only_empty_body_head')

@section('head')
<style>
#molecule-div .caret {
	color: {{ $synthesiscmsMainColor }} !important;
}

#molecule-div .select-dropdown {
	border-bottom-color: {{ $synthesiscmsMainColor }} !important;
}

#molecule-div .select-wrapper {
	margin-top: 5px !important;
}

label{
	text-align: left !important;
}
</style>
<script src="{{ asset('trumbowyg/trumbowyg.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('trumbowyg/ui/trumbowyg.min.css') }}">
<script>
$(document).ready(function(){
	$('.collapsible').collapsible();
	var selector = "#@yield('side-nav-active')";
	if(selector != "#"){
		$(selector).addClass("active");
		$(selector).parents('li').children('a').click();
		$(".editor").trumbowyg({
			lang: '{{ \App::getLocale() }}'
		});
	}
	$('ul:not(.collapsible) > li.active').addClass('lighten-1');
	$('ul:not(.collapsible) > li.active').addClass('{{ $synthesiscmsMainColor }}');
});
</script>
@endsection

@section('main')
	<div class="col s12 z-depth-1 lighten-4 row card" style="display: inline-block; padding: 0px 48px 0px 48px; border: 1px solid #EEE;">
		<div class="card-content">
			<div class="card-title col s12">
				<h3 class="{{ $synthesiscmsMainColor }}-text valign-wrapper"><i class="material-icons prefix {{ $synthesiscmsMainColor }}-text medium valign">settings</i>&nbsp;{{ trans('synthesiscms/admin.applet_settings', ['applet' => $kernel->getExtensionName()]) }}</h3>
			</div>
			<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12"></div>
			<form id="form" class="col s12 row" method="post" action="">
				{{ csrf_field() }}
				<div class="input-field col s12">
					<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">title</i>
					<input name="title" id="title" type="text">
					<label for="title">{{ trans("Nitrogen::nitrogen.item_title") }}</label>
				</div>
				<div class="input-field col s12 l6">
					<input name="titleTextColor" id="titleTextColor" type="text" value="teal">
					<label for="titleTextColor">{{ trans("Nitrogen::nitrogen.title_text_color") }}</label>
				</div>
				<div class="input-field col s12 l6">
					<input name="contentTextColor" id="contentTextColor" type="text" value="white">
					<label for="contentTextColor">{{ trans("Nitrogen::nitrogen.content_text_color") }}</label>
				</div>
				<div class="row"></div>
				<div class="row col s12 container">
					<label for="content">{{ trans("Nitrogen::nitrogen.item_content") }}</label>
					<textarea class="editor" id="content" name="content"></textarea>
				</div>
				<script>
				$(document).ready(function(){
					$("#content").trumbowyg(); //empty content
				});
				</script>
				<div class="collapsible-header {{ $synthesiscmsMainColor }}-text"><i class="material-icons {{ $synthesiscmsMainColor }}-text center">photo</i>{{ trans("Nitrogen::nitrogen.item_image") }}</div>
				<div class="input-field col s12 l8 offset-l2" id="molecule-div">
					<select class="{{ $synthesiscmsMainColor }}-text" name="type" id="type">
						<option selected value="single" class="card-panel col s10 offset-s1 red white-text truncate"><h5>{{ trans("Nitrogen::nitrogen.item_typeSingle") }}</h5></option>
						<option value="folder" class="card-panel col s10 offset-s1 red white-text truncate"><h5>{{ trans("Nitrogen::nitrogen.item_typeFolder") }}</h5></option>
					</select>
					<label>{{ trans("Nitrogen::nitrogen.item_sourceHeader") }}</label>
				</div>
				<div class="col s12 l8 offset-l2 input-field">
					<a href="#image-picker" class="btn btn-large center waves-effect col s2 l4 waves-light {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text">
						<i class="material-icons white-text">attachment</i>&nbsp;&nbsp;{{ trans('synthesiscms/atom.imageFile') }}
					</a>
					<input id="image-tv" name="image-tv" class="col s10 l8" type="text">
				</div>
				<script>
				function imagePickerCallback(txt){
					$('#image-tv').val(txt);
				}
				</script>
				@include('partials/image-picker')
				<div class="row"></div>
				<button type="submit" class="col s12 center text-center btn-flat waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}">{{ trans('synthesiscms/admin.save_applet') }}</button>
			</form>
		</div>
	</div>
@endsection