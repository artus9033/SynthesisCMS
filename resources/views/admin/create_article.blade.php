@extends('layouts.admin')

@section('title')
	{{ trans('synthesiscms/admin.create_article')}}
@endsection

@section('side-nav-active', 'manage_articles')

@section('head')
	<style>
		#articleCategory-div .caret {
			color: {{ $synthesiscmsMainColor }}     !important;
		}

		#articleCategory-div .select-dropdown {
			border-bottom-color: {{ $synthesiscmsMainColor }}     !important;
		}

		#articleCategory-div .select-wrapper {
			margin-top: 5px !important;
		}
	</style>
@endsection

@section('breadcrumbs')
	<a href="{{ url('/admin') }}" class="breadcrumb">{{ trans('synthesiscms/admin.backend') }}</a>
	<a href="{{ url('/admin/manage_articles') }}"
	   class="breadcrumb">{{ trans('synthesiscms/admin.manage_articles') }}</a>
	<a class="breadcrumb">{{ trans('synthesiscms/admin.create_article') }}</a>
@endsection

@section('main')
	<div>
		<div class="card-content no-padding">
			<div class="card-title col s12">
				<h3 class="{{ $synthesiscmsMainColor }}-text valign-wrapper col s8"><i
							class="material-icons prefix {{ $synthesiscmsMainColor }}-text medium valign">create</i>&nbsp;{{ trans('synthesiscms/admin.create_article') }}
				</h3>
			</div>
			<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12"></div>
			<div class="col s12 row"></div>
			<form class="form" method="POST" action="">
				{{ csrf_field() }}
				<div class="input-field col s12 tooltipped" data-position="top" data-delay="50"
					 data-tooltip="{{ trans('synthesiscms/admin.create_article_title_tooltip') }}">
					<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">label_outline</i>
					<input id="title" type="text" name="title" class="validate">
					<label for="title">{{ trans('synthesiscms/admin.create_article_title_label') }}</label>
				</div>
				<div class="row col s12 container">
					<label for="desc">{{ trans('synthesiscms/article.content') }}</label>
					<textarea class="editor" id="desc" name="desc"></textarea>
				</div>
				<script>
                    $(document).ready(function () {
                        $(".editor").trumbowyg('html', ''); //empty content
                    });
				</script>
				<div class="col s12 tooltipped" data-position="top" data-delay="50"
					 data-tooltip="{{ trans('synthesiscms/article.hasImageTooltip') }}">
					<p class="col s6 offset-s4">
						<input class="filled-in" type="checkbox" id="hasImage" name="hasImage">
						<label for="hasImage"
							   class="{{ $synthesiscmsMainColor }}-text">{{ trans('synthesiscms/article.hasImage') }}</label>
					</p>
				</div>
				<div class="row"></div>
				<ul class="collapsible popout col s12 row" data-collapsible="accordion">
					<li>
						<div class="collapsible-header {{ $synthesiscmsMainColor }}-text" id="collapsible"
							 style="pointer-events: none;"><i
									class="material-icons {{ $synthesiscmsMainColor }}-text center">photo</i>{{ trans('synthesiscms/article.articleImage') }}
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
							@include('partials.file-picker', ['picker_modal_id' => 'article_create_item_picker', 'callback_function_name' => 'articleImagePickerCallback', 'followIframeParentHeight' => false, 'fileExtensions' => ['jpg', 'png', 'gif', 'jpeg']])
							<a href="#article_create_item_picker"
							   class="btn btn-large center col s6 row waves-effect waves-light {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text">
								<i class="material-icons white-text">attachment</i>&nbsp;&nbsp;{{ trans('synthesiscms/article.imageFile') }}
							</a>
						</div>
					</li>
				</ul>
				<script>
                    var imgCollapsible = false;
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
				<div class="row col s12 center">
					<div class="input-field col s8 offset-s2 valign" id="articleCategory-div">
						<select id="articleCategory" name="articleCategory" class="{{ $synthesiscmsMainColor }}-text">
							@foreach (App\Models\Content\ArticleCategory::all() as $key => $value)
								<option value="{{ $value->id }}"
										class="card-panel col s10 offset-s1 red white-text truncate">
									<h5>{{ $value->title }}</h5></option>
							@endforeach
						</select>
						<label>{{ trans('synthesiscms/extensions.choose_article_category') }}</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s8 offset-s2" id="articleCategory-div">
						<select class="{{ $synthesiscmsMainColor }}-text" name="cardSize" id="cardSize">
							<option value="0"
									class="card-panel col s10 offset-s1 red white-text truncate">{{ trans('synthesiscms/article.card_size_not_defined') }}</option>
							<option value="1"
									class="card-panel col s10 offset-s1 red white-text truncate">{{ trans('synthesiscms/article.card_size_small') }}</option>
							<option value="2"
									class="card-panel col s10 offset-s1 red white-text truncate">{{ trans('synthesiscms/article.card_size_medium') }}</option>
							<option value="3"
									class="card-panel col s10 offset-s1 red white-text truncate">{{ trans('synthesiscms/article.card_size_large') }}</option>
						</select>
						<label>{{ trans('synthesiscms/article.choose_card_size') }}</label>
					</div>
				</div>
				<button type="submit"
						class="offset-s4 valign col s4 text-center btn btn-large waves-effect waves-light {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}">
					<i class="material-icons white-text right">send</i>{{ trans('synthesiscms/admin.create_article') }}
				</button>
				<div class="col s12 row"></div>
				<a class="btn-flat waves-effect waves-yellow {{ $synthesiscmsMainColor }}-text col s2 offset-s5"
				   href="{{ route('manage_articles') }}"><i
							class="material-icons {{ $synthesiscmsMainColor }}-text left">cancel</i>{{ trans('synthesiscms/admin.cancel_article') }}
				</a>
				<div class="col s12 row"></div>
			</form>
		</div>
	</div>
@endsection
