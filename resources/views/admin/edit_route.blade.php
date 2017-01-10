@extends('layouts.admin')

@section('title')
	{{ trans('synthesiscms/admin.edit_route', ['route' => $page->slug]) }}
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
				<button class="col s12 btn-large waves-effect waves-light" data-target="modalDelete{{ $page->id }}" class="btn-large teal waves-effect waves-light hoverable"><i class="material-icons white-text left">open_in_new</i>{{ trans('synthesiscms/admin.view_route') }}</button>
			</div>
		</div>
		<div class="divider teal col s12"></div>
		<div class="col s12 row"></div>
		<div class="row">
			{!! \App::make('\App\Modules\\'.$page->module.'\ModuleKernel')->edit($page) !!}
		</div>
	</div>
	<div class="card-action">
		<a class="btn-flat waves-effect waves-green teal-text"><i class="material-icons teal-text left">save</i>{{ trans('synthesiscms/admin.save_route') }}</a>
		<a class="btn-flat waves-effect waves-yellow teal-text" href="{{ /url()->previous() }}"><i class="material-icons teal-text left">cancel</i>{{ trans('synthesiscms/admin.cancel_route') }}</a>
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
