@extends('layouts.admin')

@section('title')
	{{ trans('synthesiscms/admin.edit_route', ['route' => $atom->slug]) }}
@endsection

@section('side-nav-active', 'manage_atoms')

@section('breadcrumbs')
	<a href="/admin" class="breadcrumb">{{ trans('synthesiscms/admin.backend') }}</a>
	<a href="/admin/manage_atoms" class="breadcrumb">{{ trans('synthesiscms/admin.manage_atoms') }}</a>
	<a class="breadcrumb">{{ trans('synthesiscms/admin.edit_atom') }}</a>
@endsection

@section('head')
	<script>$(document).ready(function() {
    $('select').material_select();
});</script>
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

	label{
		text-align: left !important;
	}
</style>
@endsection

@section('main')
<div id="modalDelete{{ $atom->id }}" class="modal">
	<div class="modal-content">
		<h3>{{ trans('synthesiscms/admin.modal_delete_atom_header') }}</h3>
		<div class="row col s12"><div class="divider red col s10 offset-s1" style="height: 2px;"></div></div>
		<h5>{{ trans('synthesiscms/admin.modal_delete_atom_content', ['atom' => $atom->title]) }}</h5>
		<h5 class="red-text darken-1"><strong>{{ trans('synthesiscms/admin.modal_delete_atom_content_2') }}</strong></h5>
	</div>
	<div class="modal-footer">
		<a style="margin-right: 9%;" onclick="$('#modalDelete{{ $atom->id }}').modal('close');" class="modal-action modal-close waves-effect waves-green btn-flat right">{{ trans('synthesiscms/admin.modal_delete_atom_btn_no') }}</a>
		<a style="margin-left: 9%;" href="/admin/manage_atoms/delete/{{ $atom->id }}" class="modal-action red white-text modal-close waves-effect waves-light btn-flat left">{{ trans('synthesiscms/admin.modal_delete_atom_btn_yes') }}</a>
	</div>
</div>
<div class="col s12 z-depth-1 grey lighten-4 row card" style="display: inline-block; padding: 0px 48px 0px 48px; border: 1px solid #EEE;">
	<div class="card-content">
		<div class="card-title col s12 row valign-wrapper">
			<h3 class="teal-text valign-wrapper col s12"><i class="material-icons prefix teal-text medium valign">create</i>&nbsp;{{ trans('synthesiscms/admin.edit_atom') }}&nbsp;(ID&nbsp;{{ $atom->id }})</h3>
		</div>
		<div class="divider teal col s12"></div>
		<div class="col s12 row"></div>
		<form id="edit" role="form" method="post" action="">
			{{ csrf_field() }}
			<div class="input-field col s12">
				<i class="material-icons prefix teal-text">label_outline</i>
				<input value="{{ $atom->title }}" id="title" name="title" type="text">
				<label for="title">{{ trans('synthesiscms/atom.title') }}</label>
			</div>
			<div class="row">
				<div class="input-field col s12">
					<i class="material-icons prefix teal-text">description</i>
					<textarea id="desc" name="desc" class="materialize-textarea">{{ $atom->description }}</textarea>
					<label for="desc">{{ trans('synthesiscms/atom.content') }}</label>
				</div>
			</div>
			<div class="row">
		       <div class="input-field col s8 offset-s2" id="molecule-div">
		         <select class="teal-text" name="molecule" id="molecule">
				    @foreach (App\Molecule::all() as $key => $value)
 					   <option @php if($value->id == $atom->molecule){ echo("selected"); } @endphp value="{{ $value->id }}" class="card-panel col s10 offset-s1 red white-text truncate"><h5>ID {{ $value->id }}: {{ $value->title }}</h5></option>
 				   @endforeach
		          </select>
				<label>{{ trans('synthesiscms/modules.choose_molecule') }}</label>
		       </div>
		     </div>
		</form>
	</div>
	<div class="card-action">
		<a onclick="$('#edit').submit()" class="btn-flat waves-effect waves-green teal-text"><i class="material-icons teal-text left">save</i>{{ trans('synthesiscms/admin.save_atom') }}</a>
		<a class="btn-flat waves-effect waves-yellow teal-text" href="{{ URL::previous() }}"><i class="material-icons teal-text left">cancel</i>{{ trans('synthesiscms/admin.cancel_atom') }}</a>
		<button @php if($atom->id == 1){ echo('disabled'); } @endphp class="btn-flat waves-effect waves-red teal-text" data-target="modalDelete{{ $atom->id }}"><i class="material-icons teal-text left">security</i>{{ trans('synthesiscms/atom.delete_atom') }}</button>
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
