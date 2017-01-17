@extends('layouts.admin')

@section('title')
	{{ trans('synthesiscms/admin.manage_atoms')}}
@endsection

@section('breadcrumbs')
	<a href="/admin" class="breadcrumb">{{ trans('synthesiscms/admin.backend') }}</a>
	<a href="/admin/manage_atoms" class="breadcrumb">{{ trans('synthesiscms/admin.manage_atoms') }}</a>
@endsection

@section('main')
	<button onclick="toggleAll('.delete_checkbox');" class="btn-floating btn-large teal white-text waves-effect waves-light z-depth-4 tooltipped" data-position="left" data-delay="50" data-tooltip="{{ trans('synthesiscms/admin.select_all') }}" style="position: absolute; bottom: 32px; right: 32px;">
		<i class="large material-icons">select_all</i>
	</button>
	<div class="col s12 z-depth-1 grey lighten-4 row card" style="display: inline-block; padding: 0px 48px 0px 48px; border: 1px solid #EEE;">
		<div class="card-content">
			<div class="card-title col s12">
				<h3 class="teal-text valign-wrapper"><i class="material-icons prefix teal-text medium valign">content_copy</i>&nbsp;{{ trans('synthesiscms/admin.manage_atoms') }}</h3>
			</div>
			<div class="divider teal col s12"></div>
			<div class="col s12 row"></div>
			<form class="form col s12 row" id="massdelete" method="post" action="/admin/manage_atoms/mass_delete">
				{{ csrf_field() }}
				<a href="/admin/manage_atoms/create_atom" class="btn teal waves-effect waves-light hoverable"><i class="material-icons white-text left">add</i>{{ trans('synthesiscms/admin.create_atom') }}</a>
				&nbsp;&nbsp;&nbsp;
				<button type="submit" class="btn teal white-text hoverable waves-effect waves-teal"><i class="material-icons white-text left">delete_sweep</i>{{ trans('synthesiscms/atom.delete_selected') }}</button>
				<div class="col s12 row"></div>
				<table class="bordered col s12">
					<thead>
						<tr>
							<th data-field="check" class="center">{{ trans('synthesiscms/atom.check') }}</th>
							<th data-field="id" class="center">{{ trans('synthesiscms/atom.id') }}</th>
							<th data-field="title" class="center">{{ trans('synthesiscms/atom.title') }}</th>
							<th data-field="category" class="center">{{ trans('synthesiscms/atom.molecule') }}</th>
							<th data-field="edit" class="center">{{ trans('synthesiscms/atom.edit_atom') }}</th>
							<th data-field="delete" class="center">{{ trans('synthesiscms/atom.delete_atom') }}</th>
						</tr>
					</thead>
					<tbody>
						@php
						use \App\Atom;
						$all_atoms = Atom::all();
						$all_atoms_count = $all_atoms->count();
						@endphp
						@foreach ($all_atoms as $atom)
							<tr>
							<td class="right">
								<div class="col s12">
									<p>
										<input class="delete_checkbox filled-in" type="checkbox" id="checkbox{{ $atom->id }}" name="delete_checkbox{{ $atom->id }}">
										<label for="checkbox{{ $atom->id }}"></label>
									</p>
								</div>
							</td>
							<td class="center">{{ $atom->id }}</td>
							<td class="center">{{ $atom->title }}</td>
							<td class="center">{{ App\Molecule::find($atom->molecule)->title }}&nbsp;(ID&nbsp;{{ $atom->molecule }})</td>
							<td class="center"><a href="/admin/manage_atoms/edit/{{ $atom->id }}" class="btn teal waves-effect waves-light hoverable"><i class="material-icons white-text left">create</i>{{ trans('synthesiscms/atom.edit') }}</a></td>
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
							<td class="center"><button data-target="modalDelete{{ $atom->id }}" class="btn teal waves-effect waves-light hoverable"><i class="material-icons white-text left">delete</i>{{ trans('synthesiscms/atom.delete_atom') }}</button></td>
						</tr>
					@endforeach
					@if ($all_atoms_count == 0)
						<tr><td colspan="6" class="center">{{ trans('synthesiscms/admin.no_atoms') }}</td></tr>
					@endif
				</tr>
			</tbody>
		</table>
	</form>
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
