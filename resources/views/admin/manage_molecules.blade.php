@extends('layouts.admin')

@section('title')
	{{ trans('synthesiscms/admin.manage_molecules')}}
@endsection

@section('breadcrumbs')
	<a href="/admin" class="breadcrumb">{{ trans('synthesiscms/admin.backend') }}</a>
	<a href="/admin/manage_molecules" class="breadcrumb">{{ trans('synthesiscms/admin.manage_molecules') }}</a>
@endsection

@section('main')
	<div class="fixed-action-btn horizontal">
		<button class="btn-floating btn-large teal white-text waves-effect waves-light z-depth-4 tooltipped" data-position="top" data-delay="50" data-tooltip="{{ trans('synthesiscms/admin.menu_select_actions') }}">
			<i class="large material-icons">menu</i>
		</button>
		<ul>
			<li>
				<button onclick="toggleAll('.molecule_checkbox');" class="btn-floating teal white-text waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="{{ trans('synthesiscms/admin.menu_select_actions_swap_selection') }}">
					<i class="large material-icons">swap_horiz</i>
				</button>
			</li>
			<li>
				<button onclick="unselectAll('.molecule_checkbox');" class="btn-floating teal white-text waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="{{ trans('synthesiscms/admin.menu_select_actions_unselect_all') }}">
					<i class="large material-icons">tab_unselected</i>
				</button>
			</li>
			<li>
				<button onclick="selectAll('.molecule_checkbox');" class="btn-floating teal white-text waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="{{ trans('synthesiscms/admin.menu_select_actions_select_all') }}">
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
			<a style="margin-left: 9%;" onclick="$('#action_form').attr('action', '/admin/manage_atoms/mass_delete').submit();" class="modal-action red white-text modal-close waves-effect waves-light btn-flat left">{{ trans('synthesiscms/admin.modal_mass_delete_atom_btn_yes') }}</a>
		</div>
	</div>
	<div class="col s12 z-depth-1 grey lighten-4 row card" style="display: inline-block; padding: 0px 48px 0px 48px; border: 1px solid #EEE;">
		<div class="card-content">
			<div class="card-title col s12">
				<h3 class="teal-text valign-wrapper"><i class="material-icons prefix teal-text medium valign">content_copy</i>&nbsp;{{ trans('synthesiscms/admin.manage_molecules') }}</h3>
				</div>
				<div class="divider teal col s12"></div>
				<div class="col s12 row"></div>
				<a href="/admin/manage_molecules/create_molecule" class="btn teal waves-effect waves-light hoverable"><i class="material-icons white-text left">add</i>{{ trans('synthesiscms/admin.create_molecule') }}</a>
				&nbsp;&nbsp;&nbsp;
				<button data-target="modalMassDelete" type="button" class="btn teal white-text hoverable waves-effect waves-light"><i class="material-icons white-text left">delete_sweep</i>{{ trans('synthesiscms/atom.delete_selected') }}</button>
				&nbsp;&nbsp;&nbsp;
				<button type="button" onclick="$('#action_form').attr('action', '/admin/manage_atoms/mass_copy').submit();" class="btn teal white-text hoverable waves-effect waves-light"><i class="material-icons white-text left">content_copy</i>{{ trans('synthesiscms/atom.copy_selected') }}</button>
				<div class="col s12 row"></div>
				<div class="col s12 row">
					<table class="bordered col s12">
						<thead>
							<tr>
								<th data-field="check" class="center">{{ trans('synthesiscms/atom.check') }}</th>
								<th data-field="id" class="center">{{ trans('synthesiscms/molecule.id') }}</th>
								<th data-field="title" class="center">{{ trans('synthesiscms/molecule.title') }}</th>
								<th data-field="amount" class="center">{{ trans('synthesiscms/molecule.amount') }}</th>
								<th data-field="edit" class="center">{{ trans('synthesiscms/molecule.edit_molecule') }}</th>
								<th data-field="delete" class="center">{{ trans('synthesiscms/molecule.delete_molecule') }}</th>
							</tr>
						</thead>
						<tbody>
								@php
									use \App\Molecule;
									$all_molecules = Molecule::all();
									$all_molecules_count = $all_molecules->count();
								@endphp
								@foreach ($all_molecules as $molecule)
										<tr>
											<td class="right">
												<div class="col s12">
													<p>
														<input class="molecule_checkbox filled-in" type="checkbox" id="checkbox{{ $molecule->id }}" name="molecule_checkbox{{ $molecule->id }}">
														<label for="checkbox{{ $molecule->id }}"></label>
													</p>
												</div>
											</td>
											<td class="center">{{ $molecule->id }}</td>
											<td class="center">{{ $molecule->title }}</td>
											<td class="center">{{ $molecule->getAmount() }}</td>
											<td class="center"><a href="/admin/manage_molecules/edit/{{ $molecule->id }}" class="btn teal waves-effect waves-light hoverable"><i class="material-icons white-text left">create</i>{{ trans('synthesiscms/molecule.edit') }}</a></td>
											  <div id="modalDelete{{ $molecule->id }}" class="modal">
											    <div class="modal-content">
											      <h3>{{ trans('synthesiscms/admin.modal_delete_molecule_header') }}</h3>
												 <div class="row col s12"><div class="divider red col s10 offset-s1" style="height: 2px;"></div></div>
											      <h5>{{ trans('synthesiscms/admin.modal_delete_molecule_content', ['molecule' => $molecule->title]) }}</h5>
												 <h5 class="red-text darken-1"><strong>{{ trans('synthesiscms/admin.modal_delete_molecule_content_2') }}</strong></h5>
											    </div>
											    <div class="modal-footer">
												 <a style="margin-right: 9%;" onclick="$('#modalDelete{{ $molecule->id }}').modal('close');" class="modal-action modal-close waves-effect waves-green btn-flat right">{{ trans('synthesiscms/admin.modal_delete_molecule_btn_no') }}</a>
												 <a style="margin-left: 9%;" href="/admin/manage_molecules/delete/{{ $molecule->id }}" class="modal-action red white-text modal-close waves-effect waves-light btn-flat left">{{ trans('synthesiscms/admin.modal_delete_molecule_btn_yes') }}</a>
											    </div>
											  </div>
											<td class="center"><button @php if($molecule->id == 1){ echo('disabled'); } @endphp data-target="modalDelete{{ $molecule->id }}" class="btn teal waves-effect waves-light hoverable"><i class="material-icons white-text left">security</i>{{ trans('synthesiscms/molecule.delete_molecule') }}</button></td>
										</tr>
								@endforeach
								@if ($all_molecules_count == 0)
									<tr><td colspan="6" class="center">{{ trans('synthesiscms/admin.no_molecules') }}</td></tr>
								@endif
							</tr>
						</tbody>
					</table>
				</div>
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
