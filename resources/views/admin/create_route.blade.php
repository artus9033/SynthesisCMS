@extends('layouts.admin')

@section('title')
	{{ trans('synthesiscms/admin.manage_users')}}
@endsection

@section('breadcrumbs')
	<a href="/admin" class="breadcrumb">{{ trans('synthesiscms/admin.backend') }}</a>
	<a href="/admin/manage_routes" class="breadcrumb">{{ trans('synthesiscms/admin.manage_routes') }}</a>
	<a class="breadcrumb">{{ trans('synthesiscms/admin.create_route') }}</a>
@endsection

@section('main')
	<div class="col s12 z-depth-1 grey lighten-4 row card" style="display: inline-block; padding: 0px 48px 0px 48px; border: 1px solid #EEE;">
		<div class="card-content">
			<div class="card-title col s12">
				<h3 class="teal-text valign-wrapper"><i class="material-icons prefix teal-text medium valign">create</i>&nbsp;{{ trans('synthesiscms/admin.create_route') }}</h3>
				</div>
				<div class="divider teal col s12"></div>
				<div class="col s12 row"></div>
				@php
					$routes = \Route::getRoutes();
					$request = Request::create("/p/1/123/weii21-j-rfi02fn.flkergi-efw+2");
					try {
					    $routes->match($request);
					    echo("yes");
					}
					catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e){
					    echo("no");
					}
				@endphp
				<form class="form-horizontal col s12 valign-wrapper" role="form" method="POST" action="">
					{{ csrf_field() }}
					<div class="input-field col s12 tooltipped" data-position="top" data-delay="50" data-tooltip="{{ trans('synthesiscms/admin.create_route_slug_tooltip') }}">
				          <input id="create_route" type="text" name="create_route" class="validate">
				          <label for="create_route">{{ trans('synthesiscms/admin.create_route_slug_label') }}</label>
			        	</div>
				<div class="input-field col s8 valign">
					<select id="is_admin" name="is_admin" class="teal-text">
						<option value="false"></option>
						<option value="true"></option>
					</select>
				</div>
				<button type="submit" class="valign col s4 text-center btn btn-large waves-effect waves-light teal"><i class="material-icons white-text right">send</i>{{ trans('synthesiscms/admin.change_user_privileges') }}</button>
			</form>
			</div>
		</div>
	@endsection
