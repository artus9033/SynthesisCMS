@extends('layouts.admin')

@section('title')
	{{ trans('synthesiscms/admin.manage_routes')}}
@endsection

@section('side-nav-active-zero-indexed', 2)

@section('breadcrumbs')
	<a href="{{ route('admin') }}" class="breadcrumb">{{ trans('synthesiscms/admin.backend') }}</a>
	<a href="{{ route('manage_routes') }}" class="breadcrumb">{{ trans('synthesiscms/admin.manage_routes') }}</a>
@endsection

@section('main')
	<div>
		<div class="card-content no-padding">
			<div class="card-title col s12">
				<h3 class="{{ $synthesiscmsMainColor }}-text valign-wrapper"><i
							class="material-icons prefix {{ $synthesiscmsMainColor }}-text medium valign">pages</i>&nbsp;{{ trans('synthesiscms/admin.manage_routes') }}
				</h3>
			</div>
			<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12"></div>
			<div class="col s12 row"></div>
			<a href="{{ route('create_route') }}"
			   class="btn {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} waves-effect waves-light hoverable"><i
						class="material-icons white-text left">add</i>{{ trans('synthesiscms/admin.create_route') }}</a>
			<div class="col s12 row"></div>
			<div class="col s12 row">
				<table class="bordered col s12">
					<thead>
					<tr>
						<th data-field="id" class="center">{{ trans('synthesiscms/page.id') }}</th>
						<th data-field="slug" class="center">{{ trans('synthesiscms/page.slug') }}</th>
						<th data-field="title" class="center">{{ trans('synthesiscms/page.title') }}</th>
						<th data-field="extension" class="center">{{ trans('synthesiscms/page.extension_name') }}</th>
						<th data-field="edit"
							class="center">{{ trans('synthesiscms/admin.edit_route') }}</th>
						<th data-field="delete" class="center">{{ trans('synthesiscms/admin.delete_route') }}</th>
					</tr>
					</thead>
					<tbody>
					@php
						use \App\Models\Content\Page;
						$all_routes = Page::all();
						$all_routes_count = $all_routes->count();
					@endphp
					@foreach ($all_routes as $route)
						@php
							$kpath = 'App\\Extensions\\' . $route->extension . '\\ExtensionKernel';
							$kernel = new $kpath;
						@endphp
						<tr>
							<td class="center">{{ $route->id }}</td>
							<td class="center">{{ $route->slug }}</td>
							<td class="center">{{ $route->page_title }}</td>
							<td class="center tooltipped truncate" data-position="top" data-delay="50"
								data-tooltip="{{ $kernel->getExtensionName() }}">{{ $kernel->getExtensionName() }}</td>
							<td class="center">
								<a href="{{ route('manage_routes_edit', ['id' => $route->id]) }}"
								   class="btn {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} waves-effect waves-light hoverable truncate">
									<i class="material-icons white-text left">
										create
									</i>
									{{ trans('synthesiscms/admin.edit_route') }}
								</a>
							</td>
							<div id="modalDelete{{ $route->id }}" class="modal">
								<div class="modal-content">
									<h3>{{ trans('synthesiscms/admin.modal_delete_route_header') }}</h3>
									<div class="row col s12">
										<div class="divider red col s10 offset-s1" style="height: 2px;"></div>
									</div>
									<h5>{{ trans('synthesiscms/admin.modal_delete_route_content', ['route' => $route->slug]) }}</h5>
									<h5 class="red-text darken-1">
										<strong>{{ trans('synthesiscms/admin.modal_delete_route_content_2') }}</strong>
									</h5>
								</div>
								<div class="modal-footer">
									<a style="margin-right: 9%;" onclick="$('#modalDelete').modal('close');"
									   class="modal-action modal-close waves-effect waves-green btn-flat right">{{ trans('synthesiscms/admin.modal_delete_route_btn_no') }}</a>
									<a style="margin-left: 9%;"
									   href="{{ route('manage_routes_delete', ['id' => $route->id]) }}"
									   class="modal-action red white-text modal-close waves-effect waves-light btn-flat left">{{ trans('synthesiscms/admin.modal_delete_route_btn_yes') }}</a>
								</div>
							</div>
							<td class="center">
								<button onclick="$('#modalDelete{{ $route->id }}').modal('open');"
										class="btn {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} waves-effect waves-light hoverable">
									<i class="material-icons white-text left">security</i>{{ trans('synthesiscms/admin.delete_route') }}
								</button>
							</td>
						</tr>
					@endforeach
					@if ($all_routes_count == 0)
						<tr>
							<td colspan="6" class="center">{{ trans('synthesiscms/admin.no_routes') }}</td>
						</tr>
						@endif
						</tr>
					</tbody>
				</table>
			</div>
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
