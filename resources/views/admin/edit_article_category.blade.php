@extends('layouts.admin')

@section('title')
	{{ trans('synthesiscms/admin.edit_article_category') }}
@endsection

@section('side-nav-active-zero-indexed', 0)

@section('breadcrumbs')
	<a href="{{ route('admin') }}" class="breadcrumb">{{ trans('synthesiscms/admin.backend') }}</a>
	<a href="{{ route('manage_article_categories') }}"
	   class="breadcrumb">{{ trans('synthesiscms/admin.manage_article_categories') }}</a>
	<a class="breadcrumb">{{ trans('synthesiscms/admin.edit_article_category') }}</a>
@endsection

@section('main')
	<style>
		label {
			text-align: left !important;
		}
	</style>
	<div id="modalDelete{{ $articleCategory->id }}" class="modal">
		<div class="modal-content">
			<h3>{{ trans('synthesiscms/admin.modal_delete_article_category_header') }}</h3>
			<div class="row col s12">
				<div class="divider red col s10 offset-s1" style="height: 2px;"></div>
			</div>
			<h5>{{ trans('synthesiscms/admin.modal_delete_article_category_content', ['articleCategory' => $articleCategory->title]) }}</h5>
			<h5 class="red-text darken-1">
				<strong>{{ trans('synthesiscms/admin.modal_delete_article_category_content_2') }}</strong></h5>
			<div class="col s12 center">
				<p class="center">
					<input class="filled-in {{ $synthesiscmsMainColor }}-text" type="checkbox"
						   id="checkboxDeleteArticles{{ $articleCategory->id }}"
						   name="checkboxDeleteArticles{{ $articleCategory->id }}">
					<label class="{{ $synthesiscmsMainColor }}-text"
						   for="checkboxDeleteArticles{{ $articleCategory->id }}">{{ trans('synthesiscms/admin.modal_mass_delete_article_category_checkbox_delete_subarticles') }}</label>
				</p>
			</div>
		</div>
		<div class="modal-footer">
			<a style="margin-right: 9%;" onclick="$('#modalDelete{{ $articleCategory->id }}').modal('close');"
			   class="modal-action modal-close waves-effect waves-green btn-flat right">{{ trans('synthesiscms/admin.modal_delete_article_category_btn_no') }}</a>
			<a style="margin-left: 9%;"
			   onclick="window.location.href = ('{{ url('/') }}/admin/manage_article_categories/delete/{{ $articleCategory->id }},' + $('#checkboxDeleteArticles{{ $articleCategory->id }}').prop('checked'));"
			   class="modal-action red white-text modal-close waves-effect waves-light btn-flat left">{{ trans('synthesiscms/admin.modal_delete_article_category_btn_yes') }}</a>
		</div>
	</div>
	<div>
		<div class="card-content no-padding">
			<div class="card-title col s12 row valign-wrapper">
				<h3 class="{{ $synthesiscmsMainColor }}-text valign-wrapper col s12"><i
							class="material-icons prefix {{ $synthesiscmsMainColor }}-text medium valign">create</i>&nbsp;{{ trans('synthesiscms/admin.edit_article_category') }}
					&nbsp;(ID&nbsp;{{ $articleCategory->id }})</h3>
			</div>
			<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12"></div>
			<div class="col s12 row"></div>
			<form id="edit" role="form" method="post" action="">
				{{ csrf_field() }}
				<div class="input-field col s12">
					<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">label_outline</i>
					<input value="{{ $articleCategory->title }}" id="title" name="title" type="text">
					<label for="title">{{ trans('synthesiscms/article_category.title') }}</label>
				</div>
				<div class="row">
					<div class="row col s12">
						<label for="desc">{{ trans('synthesiscms/article_category.content') }}</label>
						<textarea class="editor" id="desc" name="desc"></textarea>
					</div>
					<script>
                        $(document).ready(function () {
                            $(".editor").trumbowyg('html', {!! json_encode($articleCategory->description) !!});
                        });
					</script>
				</div>
			</form>
		</div>
		<div class="card-action">
			<a onclick="$('#edit').submit()"
			   class="btn-flat waves-effect waves-green {{ $synthesiscmsMainColor }}-text"><i
						class="material-icons {{ $synthesiscmsMainColor }}-text left">save</i>{{ trans('synthesiscms/admin.save_article_category') }}
			</a>
			<a class="btn-flat waves-effect waves-yellow {{ $synthesiscmsMainColor }}-text"
			   href="{{ route('manage_article_categories') }}"><i
						class="material-icons {{ $synthesiscmsMainColor }}-text left">cancel</i>{{ trans('synthesiscms/admin.cancel_article_category') }}
			</a>
			<button @php if($articleCategory->id == 1){ echo('disabled'); } @endphp class="btn-flat waves-effect waves-red {{ $synthesiscmsMainColor }}-text"
					onclick="$('#modalDelete{{ $articleCategory->id }}').modal('open');"><i
						class="material-icons {{ $synthesiscmsMainColor }}-text left">security</i>{{ trans('synthesiscms/article_category.delete_article_category') }}
			</button>
		</div>
	</div>
	<script type="text/javascript">
        $(document).ready(function () {
            $('.modal').modal({
                    dismissible: false
                }
            );
        });
	</script>
@endsection
