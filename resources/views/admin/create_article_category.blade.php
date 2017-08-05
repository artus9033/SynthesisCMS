@extends('layouts.admin')

@section('title')
	{{ trans('synthesiscms/admin.create_article_category')}}
@endsection

@section('side-nav-active', 'manage_article_categories')

@section('head')
	<style>
		.caret {
			color: {{ $synthesiscmsMainColor }}     !important;
		}

		.select-dropdown {
			border-bottom-color: {{ $synthesiscmsMainColor }}     !important;
		}

		.select-wrapper {
			margin-top: 5px !important;
		}
	</style>
@endsection

@section('breadcrumbs')
	<a href="{{ url('/admin') }}" class="breadcrumb">{{ trans('synthesiscms/admin.backend') }}</a>
	<a href="{{ url('/admin/manage_article_categories') }}"
	   class="breadcrumb">{{ trans('synthesiscms/admin.manage_article_categories') }}</a>
	<a class="breadcrumb">{{ trans('synthesiscms/admin.create_article_category') }}</a>
@endsection

@section('main')
	<div>
		<div class="card-content">
			<div class="card-title col s12">
				<h3 class="{{ $synthesiscmsMainColor }}-text valign-wrapper"><i
							class="material-icons prefix {{ $synthesiscmsMainColor }}-text medium valign">create</i>&nbsp;{{ trans('synthesiscms/admin.create_article_category') }}
				</h3>
			</div>
			<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12"></div>
			<div class="col s12 row"></div>
			<form id="form" class="col s12 row" method="post" action="">
				{{ csrf_field() }}
				<div class="input-field col s12 tooltipped" data-position="top" data-delay="50"
					 data-tooltip="{{ trans('synthesiscms/admin.create_article_category_title_tooltip') }}">
					<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">label_outline</i>
					<input id="title" type="text" name="title" class="validate">
					<label for="title">{{ trans('synthesiscms/admin.create_article_category_title_label') }}</label>
				</div>
				<div class="row col s12 container">
					<label for="description">{{ trans('synthesiscms/article_category.content') }}</label>
					<textarea class="editor" id="description" name="description"></textarea>
				</div>
				<script>
                    $(document).ready(function () {
                        $(".editor").trumbowyg('html', ''); //empty content
                    });
				</script>
				<button type="submit"
						class="offset-s4 valign col s4 text-center btn btn-large waves-effect waves-light {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}">
					<i class="material-icons white-text right">send</i>{{ trans('synthesiscms/admin.create_article_category') }}
				</button>
				<div class="col s12 row"></div>
				<a class="btn-flat waves-effect waves-yellow {{ $synthesiscmsMainColor }}-text col s2 offset-s5"
				   href="{{ route('manage_article_categories') }}"><i
							class="material-icons {{ $synthesiscmsMainColor }}-text left">cancel</i>{{ trans('synthesiscms/admin.cancel_article_category') }}
				</a>
				<div class="col s12 row"></div>
			</form>
		</div>
	</div>
@endsection
