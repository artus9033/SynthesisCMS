@extends('layouts.admin')

@section('title')
	{{ trans('synthesiscms/admin.settings') }}
@endsection

@section('side-nav-active', 'settings')

@section('head')
<style>
	#settings-div .caret {
	  color: {{ $synthesiscmsMainColor }} !important;
	}

	#settings-div .select-dropdown {
	  border-bottom-color: {{ $synthesiscmsMainColor }} !important;
	}

	#settings-div .select-wrapper {
	  margin-top: 5px !important;
	}
</style>
@endsection

@section('breadcrumbs')
	<a href="/admin" class="breadcrumb">{{ trans('synthesiscms/admin.backend') }}</a>
	<a href="/admin/settings" class="breadcrumb">{{ trans('synthesiscms/admin.settings') }}</a>
@endsection

@section('main')
<style>
label{
	text-align: left !important;
}
</style>
<div class="col s12 z-depth-1 grey lighten-4 row card" style="display: inline-block; padding: 0px 48px 0px 48px; border: 1px solid #EEE;">
	<div class="card-content">
		<div class="card-title col s12 row valign-wrapper">
			<h3 class="{{ $synthesiscmsMainColor }}-text valign-wrapper col s12"><i class="material-icons prefix {{ $synthesiscmsMainColor }}-text medium valign">settings</i>&nbsp;{{ trans('synthesiscms/admin.settings') }}</h3>
		</div>
		<div class="divider {{ $synthesiscmsMainColor }} col s12"></div>
		<div class="col s12 row"></div>
		<div class="row">
			<form id="edit" role="form" method="post" action="">
				{{ csrf_field() }}
					<div class="row">
						<div class="input-field col s6">
							<input value="" id="slug" name="slug" type="text">
							<label for="slug">{{ trans('synthesiscms/modules.slug') }}</label>
						</div>
					</div>
					<div class="row col s12 container">
						<label for="header">{{ trans('synthesiscms/modules.header') }}</label>
						<textarea class="editor" id="header" name="header"></textarea>
					</div>
					<script>
					$(document).ready(function(){
						$(".editor").trumbowyg('html', {!! json_encode(addslashes('todo-desc')) !!});
					});
					</script>
				</div>
			</form>
		</div>
	<div class="card-action">
		<a onclick="$('#edit').submit()" class="btn-flat waves-effect waves-green {{ $synthesiscmsMainColor }}-text"><i class="material-icons {{ $synthesiscmsMainColor }}-text left">save</i>{{ trans('synthesiscms/admin.save_route') }}</a>
		<a class="btn-flat waves-effect waves-yellow {{ $synthesiscmsMainColor }}-text" href="{{ URL::previous() }}"><i class="material-icons {{ $synthesiscmsMainColor }}-text left">cancel</i>{{ trans('synthesiscms/admin.cancel_route') }}</a>
	</div>
</div>
@endsection
