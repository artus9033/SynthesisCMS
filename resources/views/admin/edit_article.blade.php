@extends('layouts.admin')

@section('title')
	{{ trans('synthesiscms/admin.edit_article') }}
@endsection

@section('side-nav-active-zero-indexed', 0)

@section('breadcrumbs')
	<a href="{{ route('admin') }}" class="breadcrumb">{{ trans('synthesiscms/admin.backend') }}</a>
	<a href="{{ route('manage_articles') }}"
	   class="breadcrumb">{{ trans('synthesiscms/admin.manage_articles') }}</a>
	<a class="breadcrumb">{{ trans('synthesiscms/admin.edit_article') }}</a>
@endsection

@section('head')
	<script>
        $(document).ready(function () {
            $('select').formSelect();
        });
	</script>
	<style>
		#select-color-div .caret {
			color: {{ $synthesiscmsMainColor }}  !important;
		}

		#select-color-div .select-dropdown {
			border-bottom-color: {{ $synthesiscmsMainColor }}  !important;
		}

		label {
			text-align: left !important;
		}
	</style>
@endsection

@section('main')
	<div id="modalDelete{{ $article->id }}" class="modal">
		<div class="modal-content">
			<h3>{{ trans('synthesiscms/admin.modal_delete_article_header') }}</h3>
			<div class="row col s12">
				<div class="divider red col s10 offset-s1" style="height: 2px;"></div>
			</div>
			<h5>{{ trans('synthesiscms/admin.modal_delete_article_content', ['article' => $article->title]) }}</h5>
			<h5 class="red-text darken-1">
				<strong>{{ trans('synthesiscms/admin.modal_delete_article_content_2') }}</strong></h5>
		</div>
		<div class="modal-footer">
			<a style="margin-right: 9%;" onclick="$('#modalDelete{{ $article->id }}').modal('close');"
			   class="modal-action modal-close waves-effect waves-green btn-flat right">{{ trans('synthesiscms/admin.modal_delete_article_btn_no') }}</a>
			<a style="margin-left: 9%;" href="{{ route('manage_articles') }}/delete/{{ $article->id }}"
			   class="modal-action red white-text modal-close waves-effect waves-light btn-flat left">{{ trans('synthesiscms/admin.modal_delete_article_btn_yes') }}</a>
		</div>
	</div>
	<div>
		<div class="card-content no-padding">
			<div class="card-title col s12 row valign-wrapper">
				<h3 class="{{ $synthesiscmsMainColor }}-text valign-wrapper col s12"><i
							class="material-icons prefix {{ $synthesiscmsMainColor }}-text medium valign">create</i>&nbsp;{{ trans('synthesiscms/admin.edit_article') }}
					&nbsp;(ID&nbsp;{{ $article->id }})</h3>
			</div>
			<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12"></div>
			<div class="col s12 row"></div>
			<form id="edit" role="form" method="post" action="">
				{{ csrf_field() }}
				<div class="input-field col s12">
					<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">label_outline</i>
					<input value="{{ $article->title }}" id="title" name="title" type="text">
					<label for="title">{{ trans('synthesiscms/article.title') }}</label>
				</div>
				<div class="row col s12">
					<label for="desc">{{ trans('synthesiscms/article.content') }}</label>
					<textarea class="editor" id="desc" name="desc"></textarea>
				</div>
				<script>
                    $(document).ready(function () {
                        $(".editor").trumbowyg('html', {!! json_encode($article->description) !!});
                    });
				</script>
				<div class="col s12 tooltipped" data-position="top" data-delay="50"
					 data-tooltip="{{ trans('synthesiscms/article.hasImageTooltip') }}">
					 <p>
						<label>
							<input class="filled-in" type="checkbox" id="hasImage" name="hasImage">
							<span class="{{ $synthesiscmsMainColor }}-text">
								{{ trans('synthesiscms/article.hasImage') }}
							</span>
						</label>
					</p>
				</div>
				<div class="row"></div>
				<ul class="collapsible popout col s12 row" data-collapsible="accordion">
					<li>
						<div class="collapsible-header {{ $synthesiscmsMainColor }}-text" id="collapsible" style="pointer-events: none;">
							 <i class="material-icons {{ $synthesiscmsMainColor }}-text center">photo</i>{{ trans('synthesiscms/article.articleImage') }}
						</div>
						<div class="collapsible-body col s12 card-panel z-depth-3">
							<div class="col s12 row"></div>
							<div class="input-field col s6">
								<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">link</i>
								<input id="image" name="image" type="text">
								<label for="image">{{ trans('synthesiscms/article.imageURL') }}</label>
							</div>
							<script>
                                function articleImagePickerCallback(url, fsize) {
                                    $('#image').val(url);
                                }
							</script>
							@include('partials.file-picker', ['picker_modal_id' => 'article_edit_item_picker', 'callback_function_name' => 'articleImagePickerCallback', 'followIframeParentHeight' => false, 'fileExtensions' => ['jpg', 'png', 'gif', 'jpeg', 'tga', 'gif', 'webp', 'JPG', 'PNG', 'GIF', 'JPEG', 'TGA', 'WEBP']])
							<a onclick="$('#article_edit_item_picker').modal('open');"
							   class="btn btn-large center col s6 row waves-effect waves-light {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text">
								<i class="material-icons white-text">attachment</i>&nbsp;&nbsp;{{ trans('synthesiscms/article.imageFile') }}
							</a>
						</div>
					</li>
				</ul>
				<script>
                    $(document).ready(function () {
                        var hasImageChecked = {{ $article->hasImage }};
                        $('#image').val("{!! $article->image !!}");
                        $('#hasImage').prop('checked', hasImageChecked);
                        if (hasImageChecked) {
                            imgCollapsible = true;
                            $("#collapsible").click();
                            imgCollapsible = false;
                        }
                    });
                    var imgCollapsible = {{ $article->hasImage }};
                    $("#hasImage").click(function () {
                        imgCollapsible = true;
                        $("#collapsible").click();
                        imgCollapsible = false;
                    });
                    $("#collapsible").click(function (event) {
                        if (!imgCollapsible) {
                            event.preventDefault();
                        }
                    });
				</script>
				<div class="row">
					<div class="input-field col s8 offset-s2" id="select-color-div">
						<select class="{{ $synthesiscmsMainColor }}-text" name="articleCategory" id="articleCategory">
							@foreach (App\Models\Content\ArticleCategory::all() as $key => $value)
								<option @php if($value->id == $article->articleCategory){ echo("selected"); } @endphp value="{{ $value->id }}"
										class="card-panel col s10 offset-s1 red white-text truncate">ID {{ $value->id }}: {{ $value->title }}</option>
							@endforeach
						</select>
						<label>{{ trans('synthesiscms/extensions.choose_article_category') }}</label>
					</div>
				</div>
				<div class="col s12 m10 offset-m1 l8 offset-l2">
					<div style="text-align: left !important;" class="chips" id="article-tags"></div>
				</div>
				<input style="visibility: hidden;" name="articleTags" id="articleTags">
				<script>
                    $(document).ready(function () {
						@php
							$hydrogenArticleTags = "";
							foreach($article->tags as $key => $tag){
								$hydrogenArticleTags .= "{ tag: \"$tag->name\", }," . PHP_EOL;
							}
						@endphp
                        var hydrogenArticleTagsData = [
							{!! $hydrogenArticleTags !!}
						];
                        var synthesiscmsArticleChips = [];
                        $.each(hydrogenArticleTagsData, function(index, value){
                            synthesiscmsArticleChips.push(value.tag);
						});
                        updateHydrogenTagsInput();
						@php
							$autocompleteTags = "";
							foreach(\App\Models\Content\Tag::all() as $key => $tag){
								$autocompleteTags .= "\"$tag->name\": null," . PHP_EOL;
							}
						@endphp
                        var hydrogenAutocompleteData = {
							{!! $autocompleteTags !!}
						};
                        $('#article-tags').chips({
                            placeholder: "{{ trans('synthesiscms/article.enter_tag_first') }}",
                            secondaryPlaceholder: "{{ trans('synthesiscms/article.enter_tag_more') }}",
                            autocompleteOptions: {
                                data: hydrogenAutocompleteData,
                                limit: Infinity,
                                minLength: 1
                            },
                            data: hydrogenArticleTagsData,
                        });

                        $('#article-tags').on('chip.add', function (e, chip) {
                            synthesiscmsArticleChips.push(chip.tag);
                            updateHydrogenTagsInput();
                        });

                        $('#article-tags').on('chip.delete', function (e, chip) {
                            synthesiscmsArticleChips.splice(synthesiscmsArticleChips.indexOf(chip.tag), 1);
                            updateHydrogenTagsInput();
                        });

                        function updateHydrogenTagsInput() {
                            var text = "";
                            $.each(synthesiscmsArticleChips, function (index, value) {
                                text += btoa(value) + ";";
                            });
                            $("#articleTags").val(text);
                        }
                    });
				</script>
				<div class="row">
					<div class="input-field col s8 offset-s2" id="select-color-div">
						<select class="{{ $synthesiscmsMainColor }}-text" name="cardSize" id="cardSize">
							<option @if($article->cardSize === \App\Models\Content\Article::cardSizeNotDefined) selected
									@endif value="0"
									class="card-panel col s10 offset-s1 red white-text truncate">{{ trans('synthesiscms/article.card_size_not_defined') }}</option>
							<option @if($article->cardSize === \App\Models\Content\Article::cardSizeSmall) selected
									@endif value="1"
									class="card-panel col s10 offset-s1 red white-text truncate">{{ trans('synthesiscms/article.card_size_small') }}</option>
							<option @if($article->cardSize === \App\Models\Content\Article::cardSizeMedium) selected
									@endif value="2"
									class="card-panel col s10 offset-s1 red white-text truncate">{{ trans('synthesiscms/article.card_size_medium') }}</option>
							<option @if($article->cardSize === \App\Models\Content\Article::cardSizeLarge) selected
									@endif value="3"
									class="card-panel col s10 offset-s1 red white-text truncate">{{ trans('synthesiscms/article.card_size_large') }}</option>
						</select>
						<label>{{ trans('synthesiscms/article.choose_card_size') }}</label>
					</div>
				</div>
			</form>
		</div>
		<div class="card-action">
			<a onclick="$('#edit').submit()"
			   class="btn-flat waves-effect waves-green {{ $synthesiscmsMainColor }}-text"><i
						class="material-icons {{ $synthesiscmsMainColor }}-text left">save</i>{{ trans('synthesiscms/admin.save_article') }}
			</a>
			<a class="btn-flat waves-effect waves-yellow {{ $synthesiscmsMainColor }}-text"
			   href="{{ route('manage_articles') }}"><i
						class="material-icons {{ $synthesiscmsMainColor }}-text left">cancel</i>{{ trans('synthesiscms/admin.cancel_article') }}
			</a>
			<button class="btn-flat waves-effect waves-red {{ $synthesiscmsMainColor }}-text"
					onclick="$('#modalDelete{{ $article->id }}').modal('open');"><i
						class="material-icons {{ $synthesiscmsMainColor }}-text left">security</i>{{ trans('synthesiscms/article.delete_article') }}
			</button>
		</div>
	</div>
@endsection
