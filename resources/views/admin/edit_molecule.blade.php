@extends('layouts.admin')

@section('title')
	{{ trans('synthesiscms/admin.edit_route', ['route' => $molecule->slug]) }}
@endsection

@section('breadcrumbs')
	<a href="/admin" class="breadcrumb">{{ trans('synthesiscms/admin.backend') }}</a>
	<a href="/admin/manage_molecules" class="breadcrumb">{{ trans('synthesiscms/admin.manage_molecules') }}</a>
	<a class="breadcrumb">{{ trans('synthesiscms/admin.edit_molecule') }}</a>
@endsection

@section('main')
<style>
label{
	text-align: left !important;
}
</style>
<div id="modalDelete{{ $molecule->id }}" class="modal">
	<div class="modal-content">
		<h3>{{ trans('synthesiscms/admin.modal_delete_molecule_header') }}</h3>
		<div class="row col s12"><div class="divider red col s10 offset-s1" style="height: 2px;"></div></div>
		<h5>{{ trans('synthesiscms/admin.modal_delete_molecule_content', ['molecule' => $molecule->title]) }}</h5>
		<h5 class="red-text darken-1"><strong>{{ trans('synthesiscms/admin.modal_delete_molecule_content_2') }}</strong></h5>
	</div>
	<form class="form" id="formDelete{{ $molecule->id }}" method="delete">
	</form>
	<div class="modal-footer">
		<a style="margin-right: 9%;" onclick="$('#modalDelete{{ $molecule->id }}').modal('close');" class="modal-action modal-close waves-effect waves-green btn-flat right">{{ trans('synthesiscms/admin.modal_delete_molecule_btn_no') }}</a>
		<a style="margin-left: 9%;" onclick="$('#formDelete{{ $molecule->id }}').submit();" class="modal-action red white-text modal-close waves-effect waves-light btn-flat left">{{ trans('synthesiscms/admin.modal_delete_molecule_btn_yes') }}</a>
	</div>
</div>
<div class="col s12 z-depth-1 grey lighten-4 row card" style="display: inline-block; padding: 0px 48px 0px 48px; border: 1px solid #EEE;">
	<div class="card-content">
		<div class="card-title col s12 row valign-wrapper">
			<h3 class="teal-text valign-wrapper col s12"><i class="material-icons prefix teal-text medium valign">create</i>&nbsp;{{ trans('synthesiscms/admin.edit_molecule') }}</h3>
		</div>
		<div class="divider teal col s12"></div>
		<div class="col s12 row"></div>
		<form id="edit" role="form" method="post" action="">
			{{ csrf_field() }}
			<div class="input-field col s12">
				<i class="material-icons prefix teal-text">label_outline</i>
				<input value="{{ $molecule->title }}" id="title" name="title" type="text">
				<label for="title">{{ trans('synthesiscms/molecule.title') }}</label>
			</div>
			<div class="row">
				<div class="input-field col s12">
					<i class="material-icons prefix teal-text">description</i>
					<textarea id="desc" name="desc" class="materialize-textarea">{{ $molecule->description }}</textarea>
					<label for="desc">{{ trans('synthesiscms/molecule.content') }}</label>
				</div>
			</div>
		</form>
	</div>
	<div class="card-action">
		<a onclick="$('#edit').submit()" class="btn-flat waves-effect waves-green teal-text"><i class="material-icons teal-text left">save</i>{{ trans('synthesiscms/admin.save_route') }}</a>
		<a class="btn-flat waves-effect waves-yellow teal-text" href="{{ URL::previous() }}"><i class="material-icons teal-text left">cancel</i>{{ trans('synthesiscms/admin.cancel_route') }}</a>
		<button class="btn-flat waves-effect waves-red teal-text" data-target="modalDelete{{ $molecule->id }}"><i class="material-icons teal-text left">security</i>{{ trans('synthesiscms/admin.delete_route') }}</button>
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
