@extends('layouts.admin')

@section('title')
	{{ trans('synthesiscms/admin.edit_route', ['route' => $page->slug]) }}
@endsection

@section('head')
<style>
	#molecule-div .caret {
	  color: teal !important;
	}

	#molecule-div .select-dropdown {
	  border-bottom-color: teal !important;
	}

	#molecule-div .select-wrapper {
	  margin-top: 5px !important;
	}
</style>
@endsection

@section('breadcrumbs')
	<a href="/admin" class="breadcrumb">{{ trans('synthesiscms/admin.backend') }}</a>
	<a href="/admin/manage_routes" class="breadcrumb">{{ trans('synthesiscms/admin.manage_routes') }}</a>
	<a class="breadcrumb">{{ trans('synthesiscms/admin.edit_route', ['route' => $page->slug]) }}</a>
@endsection

@section('main')
<style>
label{
	text-align: left !important;
}
</style>
<div id="modalDelete{{ $page->id }}" class="modal">
	<div class="modal-content">
		<h3>{{ trans('synthesiscms/admin.modal_delete_route_header') }}</h3>
		<div class="row col s12"><div class="divider red col s10 offset-s1" style="height: 2px;"></div></div>
		<h5>{{ trans('synthesiscms/admin.modal_delete_route_content', ['route' => $page->slug]) }}</h5>
		<h5 class="red-text darken-1"><strong>{{ trans('synthesiscms/admin.modal_delete_route_content_2') }}</strong></h5>
	</div>
	<div class="modal-footer">
		<a style="margin-right: 9%;" onclick="$('#modalDelete').modal('close');" class="modal-action modal-close waves-effect waves-green btn-flat right">{{ trans('synthesiscms/admin.modal_delete_route_btn_no') }}</a>
		<a style="margin-left: 9%;" href="/admin/manage_routes/delete/{{ $page->id }}" class="modal-action red white-text modal-close waves-effect waves-light btn-flat left">{{ trans('synthesiscms/admin.modal_delete_route_btn_yes') }}</a>
	</div>
</div>
<div class="col s12 z-depth-1 grey lighten-4 row card" style="display: inline-block; padding: 0px 48px 0px 48px; border: 1px solid #EEE;">
	<div class="card-content">
		<div class="card-title col s12 row valign-wrapper">
			<h3 class="teal-text valign-wrapper col s8"><i class="material-icons prefix teal-text medium valign">create</i>&nbsp;{{ trans('synthesiscms/admin.edit_route', ['route' => $page->slug]) }}</h3>
			<div class="col s4 valign row">
				<a class="col s12 btn-large waves-effect waves-light" href="{{ $page->slug }}" target="_blank" class="btn-large teal waves-effect waves-light hoverable"><i class="material-icons white-text left">open_in_new</i>{{ trans('synthesiscms/admin.view_route') }}</a>
			</div>
		</div>
		<div class="divider teal col s12"></div>
		<div class="col s12 row"></div>
		<div class="row">
			<form id="edit" role="form" method="post" action="">
				{{ csrf_field() }}
				<div class="card-panel col s8 offset-s2 z-depth-2 center teal white-text">
				<h5>{{ trans('synthesiscms/modules.edit_main') }}</h5>
			</div>
				<div class="row">
						<div class="input-field col s6">
							<input value="{{ $page->slug }}" id="slug" name="slug" type="text">
							<label for="slug">{{ trans('synthesiscms/modules.slug') }}</label>
						</div>
						<div class="input-field col s6">
							<input value="{{ $page->page_title }}" id="title" name="title" type="text">
							<label for="title">{{ trans('synthesiscms/modules.title') }}</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<textarea id="header" name="header" class="materialize-textarea">{{ $page->page_header }}</textarea>
							<label for="header">{{ trans('synthesiscms/modules.header') }}</label>
						</div>
					</div>
					<div class="row col s12 center">
						<div class="input-field col s8 offset-s2 valign" id="molecule-div">
							<select id="molecule" name="molecule" class="teal-text">
									@php
										$tmp_ct = 0;
									@endphp
									@foreach (App\Molecule::all() as $key => $value)
										@php
											$tmp_ct++;
											var_dump($value);
										@endphp
									@endforeach
									@if ($tmp_ct == 0)
										<option disabled selected class="card-panel col s10 offset-s1 red white-text"><h5>{{ trans('synthesiscms/modules.no_molecules') }}</h5></option>
									@endif
							</select>
							<label>{{ trans('synthesiscms/modules.choose_molecule') }}</label>
						</div>
						</div>
			</form>
			<div class="divider teal col s12 row"></div>
			<div class="card-panel col s8 offset-s2 z-depth-2 center teal white-text row">
			<h5>{{ trans('synthesiscms/modules.edit_specific') }}</h5>
		</div>
			{!! \App::make('App\Modules\\'.$page->module.'\ModuleKernel')->edit($page) !!}
		</div>
	</div>
	<div class="card-action">
		<a onclick="$('#edit').submit()" class="btn-flat waves-effect waves-green teal-text"><i class="material-icons teal-text left">save</i>{{ trans('synthesiscms/admin.save_route') }}</a>
		<a class="btn-flat waves-effect waves-yellow teal-text" href="{{ URL::previous() }}"><i class="material-icons teal-text left">cancel</i>{{ trans('synthesiscms/admin.cancel_route') }}</a>
		<button class="btn-flat waves-effect waves-red teal-text" data-target="modalDelete{{ $page->id }}"><i class="material-icons teal-text left">security</i>{{ trans('synthesiscms/admin.delete_route') }}</button>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('.modal').modal({
		dismissible: false
	}
);
});
</script>
@endsection
