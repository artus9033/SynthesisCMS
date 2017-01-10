@extends('layouts.admin')

@section('title')
	{{ trans('synthesiscms/admin.manage_routes')}}
@endsection

@section('breadcrumbs')
	<a href="/admin" class="breadcrumb">{{ trans('synthesiscms/admin.backend') }}</a>
	<a href="/admin/manage_routes" class="breadcrumb">{{ trans('synthesiscms/admin.manage_routes') }}</a>
@endsection

@section('main')
	<div class="col s12 z-depth-1 grey lighten-4 row card" style="display: inline-block; padding: 0px 48px 0px 48px; border: 1px solid #EEE;">
		<div class="card-content">
			<div class="card-title col s12">
				<h3 class="teal-text valign-wrapper"><i class="material-icons prefix teal-text medium valign">pages</i>&nbsp;{{ trans('synthesiscms/admin.manage_routes') }}</h3>
				</div>
				<div class="divider teal col s12"></div>
				<div class="col s12 row"></div>
				<a href="/admin/manage_routes/create_route" class="btn teal waves-effect waves-light hoverable"><i class="material-icons white-text left">add</i>{{ trans('synthesiscms/admin.create_route') }}</a>
				<div class="col s12 row"></div>
				<div class="col s12 row">
					<table class="bordered col s12">
						<thead>
							<tr>
								<th data-field="id" class="center">{{ trans('synthesiscms/page.id') }}</th>
								<th data-field="slug" class="center">{{ trans('synthesiscms/page.slug') }}</th>
								<th data-field="title" class="center">{{ trans('synthesiscms/page.title') }}</th>
								<th data-field="module" class="center">{{ trans('synthesiscms/page.module_name') }}</th>
								<th data-field="edit" class="center">{{ trans('synthesiscms/admin.edit_route', ['route' => '']) }}</th>
								<th data-field="delete" class="center">{{ trans('synthesiscms/admin.delete_route') }}</th>
							</tr>
						</thead>
						<tbody>
								@php
									use \App\Page;
									$all_routes = Page::all();
									$all_routes_count = $all_routes->count();
								@endphp
								@foreach ($all_routes as $route)
										<tr>
											<td class="center">{{ $route->id }}</td>
											<td class="center">{{ $route->slug }}</td>
											<td class="center">{{ $route->page_title }}</td>
											<td class="center">{{ $route->module }}</td>
											<td class="center"><a href="/admin/manage_routes/edit/{{ $route->id }}" class="btn teal waves-effect waves-light hoverable"><i class="material-icons white-text left">create</i>{{ trans('synthesiscms/admin.edit_route', ['route' => '']) }}</a></td>
											  <div id="modalDelete{{ $route->id }}" class="modal">
											    <div class="modal-content">
											      <h3>{{ trans('synthesiscms/admin.modal_delete_route_header') }}</h3>
												 <div class="row col s12"><div class="divider red col s10 offset-s1" style="height: 2px;"></div></div>
											      <h5>{{ trans('synthesiscms/admin.modal_delete_route_content', ['route' => $route->slug]) }}</h5>
												 <h5 class="red-text darken-1"><strong>{{ trans('synthesiscms/admin.modal_delete_route_content_2') }}</strong></h5>
											    </div>
											    <div class="modal-footer">
												 <a style="margin-right: 9%;" onclick="$('#modalDelete').modal('close');" class="modal-action modal-close waves-effect waves-green btn-flat right">{{ trans('synthesiscms/admin.modal_delete_route_btn_no') }}</a>
												 <a style="margin-left: 9%;" href="/admin/manage_routes/delete/{{ $route->id }}" class="modal-action red white-text modal-close waves-effect waves-light btn-flat left">{{ trans('synthesiscms/admin.modal_delete_route_btn_yes') }}</a>
											    </div>
											  </div>
											<td class="center"><button data-target="modalDelete{{ $route->id }}" class="btn teal waves-effect waves-light hoverable"><i class="material-icons white-text left">security</i>{{ trans('synthesiscms/admin.delete_route') }}</button></td>
										</tr>
								@endforeach
								@if ($all_routes_count == 0)
									<tr><td colspan="6" class="center">{{ trans('synthesiscms/admin.no_routes') }}</td></tr>
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
