@extends('layouts.admin')

@section('title')
	{{ trans('synthesiscms/admin.manage_atoms')}}
@endsection

@section('side-nav-active', 'manage_atoms')

	@section('head')
	<style>
	#molecule-div .caret {
		color: {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} !important;
	}

	#molecule-div .select-dropdown {
		border-bottom-color: {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} !important;
	}

	#molecule-div .select-wrapper {
		margin-top: 5px !important;
	}
	</style>
@endsection

@section('breadcrumbs')
	<a href="{{ url('/admin') }}" class="breadcrumb">{{ trans('synthesiscms/admin.backend') }}</a>
	<a href="{{ url('/admin/manage_atoms') }}" class="breadcrumb">{{ trans('synthesiscms/admin.manage_atoms') }}</a>
@endsection

@section('main')
	<div class="fixed-action-btn horizontal">
		<button class="btn-floating btn-large {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text waves-effect waves-light z-depth-4 tooltipped" data-position="top" data-delay="50" data-tooltip="{{ trans('synthesiscms/admin.menu_select_actions') }}">
			<i class="large material-icons">menu</i>
		</button>
		<ul>
			<li>
				<button onclick="toggleAll('.atom_checkbox');" class="btn-floating {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="{{ trans('synthesiscms/admin.menu_select_actions_swap_selection') }}">
					<i class="large material-icons">swap_horiz</i>
				</button>
			</li>
			<li>
				<button onclick="unselectAll('.atom_checkbox');" class="btn-floating {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="{{ trans('synthesiscms/admin.menu_select_actions_unselect_all') }}">
					<i class="large material-icons">tab_unselected</i>
				</button>
			</li>
			<li>
				<button onclick="selectAll('.atom_checkbox');" class="btn-floating {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="{{ trans('synthesiscms/admin.menu_select_actions_select_all') }}">
					<i class="large material-icons">select_all</i>
				</button>
			</li>
		</ul>
	</div>
	<div id="modalMassDelete" class="modal">
		<div class="modal-content">
			<h3>{{ trans('synthesiscms/admin.modal_mass_delete_atom_header') }}</h3>
			<div class="row col s12"><div class="divider red col s10 offset-s1" style="height: 2px;"></div></div>
			<h5>{{ trans('synthesiscms/admin.modal_mass_delete_atom_content') }}</h5>
			<h5 class="red-text darken-1"><strong>{{ trans('synthesiscms/admin.modal_mass_delete_atom_content_2') }}</strong></h5>
		</div>
		<div class="modal-footer">
			<a style="margin-right: 9%;" onclick="$('#modalMassDelete').modal('close');" class="modal-action modal-close waves-effect waves-green btn-flat right">{{ trans('synthesiscms/admin.modal_mass_delete_atom_btn_no') }}</a>
			<a style="margin-left: 9%;" onclick="$('#action_form').attr('action', '{{ url('/') }}/admin/manage_atoms/mass_delete').submit();" class="modal-action red white-text modal-close waves-effect waves-light btn-flat left">{{ trans('synthesiscms/admin.modal_mass_delete_atom_btn_yes') }}</a>
		</div>
	</div>
	<div id="modalMassMove" class="modal">
		<div class="modal-content">
			<h3>{{ trans('synthesiscms/admin.modal_mass_move_atom_header') }}</h3>
			<div class="row col s12"><div class="divider red col s10 offset-s1" style="height: 2px;"></div></div>
			<h5>{{ trans('synthesiscms/admin.modal_mass_move_atom_content') }}</h5>
			<h5 class="red-text darken-1"><strong>{{ trans('synthesiscms/admin.modal_mass_move_atom_content_2') }}</strong></h5>
			<div class="row col s12 center">
				<div class="input-field col s8 offset-s2 valign" id="molecule-div">
					<select id="massMoveMolecule" name="massMoveMolecule" class="{{ $synthesiscmsMainColor }}-text">
						@foreach (App\Models\Content\Molecule::all() as $key => $value)
							<option value="{{ $value->id }}" class="card-panel col s10 offset-s1 red white-text truncate"><h5>{{ $value->title }}&nbsp;(ID {{ $value->id }})</h5></option>
						@endforeach
					</select>
					<label>{{ trans('synthesiscms/extensions.choose_molecule') }}</label>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<a style="margin-right: 9%;" onclick="$('#modalMassMove').modal('close');" class="modal-action modal-close waves-effect waves-green btn-flat right">{{ trans('synthesiscms/admin.modal_mass_move_atom_btn_no') }}</a>
			<a style="margin-left: 9%;" onclick="$('#action_form').attr('action', '{{ url('/') }}/admin/manage_atoms/mass_move/' + $('#massMoveMolecule').val()).submit();" class="modal-action red white-text modal-close waves-effect waves-light btn-flat left">{{ trans('synthesiscms/admin.modal_mass_move_atom_btn_yes') }}</a>
		</div>
	</div>
	<div class="col s12 z-depth-1 grey lighten-4 row card" style="display: inline-block; padding: 0px 48px 0px 48px; border: 1px solid #EEE;">
		<div class="card-content">
			<div class="card-title col s12">
				<h3 class="{{ $synthesiscmsMainColor }}-text valign-wrapper"><i class="material-icons prefix {{ $synthesiscmsMainColor }}-text medium valign">donut_large</i>&nbsp;{{ trans('synthesiscms/admin.manage_atoms') }}</h3>
			</div>
			<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12"></div>
			<div class="col s12 row"></div>
			<form class="form col s12 row" id="action_form" method="post">
				{{ csrf_field() }}
				<table class="col s12">
					<tbody>
						<tr>
							<td><a href="{{ url('/admin/manage_atoms/create_atom') }}" class="col s10 offset-s1 btn {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} waves-effect waves-light hoverable"><i class="material-icons white-text left">add</i>{{ trans('synthesiscms/admin.create_atom') }}</a></td>
							<td><button data-target="modalMassDelete" type="button" class="col s10 offset-s1 btn {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text hoverable waves-effect waves-light"><i class="material-icons white-text left">delete_sweep</i>{{ trans('synthesiscms/atom.delete_selected') }}</button></td>
							<td><button type="button" onclick="$('#action_form').attr('action', '{{ url('/') }}/admin/manage_atoms/mass_copy').submit();" class="col s10 offset-s1 btn {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text hoverable waves-effect waves-light"><i class="material-icons white-text left">content_copy</i>{{ trans('synthesiscms/atom.copy_selected') }}</button></td>
						</tr>
						<tr>
							<td><button data-target="modalMassMove" type="button" class="col s10 offset-s1 btn {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text hoverable waves-effect waves-light"><i class="material-icons white-text left">transform</i>{{ trans('synthesiscms/atom.move_selected') }}</button></td>
						</tr>
					</tbody>
				</table>
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
						use \App\Models\Content\Atom;
						$all_atoms = Atom::all();
						$all_atoms_count = $all_atoms->count();
						@endphp
						@foreach ($all_atoms as $atom)
							<tr>
								<td class="right">
									<div class="col s12">
										<p>
											<input class="atom_checkbox filled-in" type="checkbox" id="checkbox{{ $atom->id }}" name="atom_checkbox{{ $atom->id }}">
											<label for="checkbox{{ $atom->id }}"></label>
										</p>
									</div>
								</td>
								<td class="center">{{ $atom->id }}</td>
								<td class="center">{{ App\Toolbox::string_truncate($atom->title, 34) }}</td>
								<td class="center">{{ App\Toolbox::string_truncate(('(ID ' . $atom->molecule . ') ' . App\Models\Content\Molecule::find($atom->molecule)->title), 15) }}</td>
								<td class="center"><a href="{{ url('/admin/manage_atoms/edit') }}/{{ $atom->id }}" class="btn {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} waves-effect waves-light hoverable"><i class="material-icons white-text left">create</i>{{ trans('synthesiscms/atom.edit') }}</a></td>
								<div id="modalDelete{{ $atom->id }}" class="modal">
									<div class="modal-content">
										<h3>{{ trans('synthesiscms/admin.modal_delete_atom_header') }}</h3>
										<div class="row col s12"><div class="divider red col s10 offset-s1" style="height: 2px;"></div></div>
										<h5>{{ trans('synthesiscms/admin.modal_delete_atom_content', ['atom' => $atom->title]) }}</h5>
										<h5 class="red-text darken-1"><strong>{{ trans('synthesiscms/admin.modal_delete_atom_content_2') }}</strong></h5>
									</div>
									<div class="modal-footer">
										<a style="margin-right: 9%;" onclick="$('#modalDelete{{ $atom->id }}').modal('close');" class="modal-action modal-close waves-effect waves-green btn-flat right">{{ trans('synthesiscms/admin.modal_delete_atom_btn_no') }}</a>
										<a style="margin-left: 9%;" href="{{ url('/admin/manage_atoms/delete') }}/{{ $atom->id }}" class="modal-action red white-text modal-close waves-effect waves-light btn-flat left">{{ trans('synthesiscms/admin.modal_delete_atom_btn_yes') }}</a>
									</div>
								</div>
								<td class="center"><button data-target="modalDelete{{ $atom->id }}" class="btn {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} waves-effect waves-light hoverable"><i class="material-icons white-text left">delete</i>{{ trans('synthesiscms/atom.delete_atom') }}</button></td>
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
