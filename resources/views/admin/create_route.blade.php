@extends('layouts.admin')

@section('title')
	{{ trans('synthesiscms/admin.create_route')}}
@endsection

@section('head')
<style>
	.caret {
	  color: teal !important;
	}

	.select-dropdown {
	  border-bottom-color: teal !important;
	}

	.select-wrapper {
	  margin-top: 5px !important;
	}
</style>
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
				//TODO: dynamically check if route free:
					$routes = \Route::getRoutes();
					$request = Request::create("/p/1/123/weii21-j-rfi02fn.flkergi-efw+2");
					try {
					    $routes->match($request);
					    //echo("yes");
					}
					catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e){
					    //echo("no");
					}
				@endphp
				{!! Form::open(array('class' => 'form')) !!}
					<div class="input-field col s12 tooltipped" data-position="top" data-delay="50" data-tooltip="{{ trans('synthesiscms/admin.create_route_slug_tooltip') }}">
						<i class="material-icons prefix teal-text">label_outline</i>
				          <input id="route" type="text" name="route" class="validate">
				          <label for="route">{{ trans('synthesiscms/admin.create_route_slug_label') }}</label>
			        	</div>
				<div class="input-field col s8 valign">
					<select id="module" name="module" class="teal-text">
						<optgroup label="{{ trans('synthesiscms/modules.synthesiscms_modules') }}">
						<option value="Hydrogen">{{ trans('synthesiscms/modules.hydrogen') }}</option>
						<option value="Lithium">{{ trans('synthesiscms/modules.lithium') }}</option>
					</optgroup>
					</select>
					<label>{{ trans('synthesiscms/modules.choose_module') }}</label>
				</div>
				<button type="submit" class="valign col s4 text-center btn btn-large waves-effect waves-light teal"><i class="material-icons white-text right">send</i>{{ trans('synthesiscms/admin.create_route') }}</button>
			{!! Form::close() !!}
			</div>
		</div>
	@endsection
