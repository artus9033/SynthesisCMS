@extends('layouts.admin')

@section('title')
	{{ trans('synthesiscms/admin.create_route')}}
@endsection

@section('side-nav-active', 'manage_routes')

@section('head')
<style>
	.caret {
	  color: {{ $synthesiscmsMainColor }} !important;
	}

	.select-dropdown {
	  border-bottom-color: {{ $synthesiscmsMainColor }} !important;
	}

	.select-wrapper {
	  margin-top: 5px !important;
	}
</style>
@endsection

@section('breadcrumbs')
	<a href="{{ url('/admin') }}" class="breadcrumb">{{ trans('synthesiscms/admin.backend') }}</a>
	<a href="{{ url('/admin/manage_routes') }}" class="breadcrumb">{{ trans('synthesiscms/admin.manage_routes') }}</a>
	<a class="breadcrumb">{{ trans('synthesiscms/admin.create_route') }}</a>
@endsection

@section('main')
	<div class="col s12 z-depth-1 grey lighten-4 row card" style="display: inline-block; padding: 0px 48px 0px 48px; border: 1px solid #EEE;">
		<div class="card-content">
			<div class="card-title col s12">
				<h3 class="{{ $synthesiscmsMainColor }}-text valign-wrapper"><i class="material-icons prefix {{ $synthesiscmsMainColor }}-text medium valign">create</i>&nbsp;{{ trans('synthesiscms/admin.create_route') }}</h3>
				</div>
				<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12"></div>
				<div class="col s12 row"></div>
				@php
				//TODO: dynamically check if route free:
					$routes = \Route::getRoutes();
					$request = Request::create("TODO");
					try {
					    $routes->match($request);
					    //echo("yes");
					}
					catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e){
					    //echo("no");
					}
				@endphp
				<form class="form col s12" role="form" method="POST" action="">
					{{ csrf_field() }}
					<div class="input-field col s12 tooltipped" data-position="top" data-delay="50" data-tooltip="{{ trans('synthesiscms/admin.create_route_slug_tooltip') }}">
						<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">label_outline</i>
				          <input id="route" type="text" name="route" class="validate">
				          <label for="route">{{ trans('synthesiscms/admin.create_route_slug_label') }}</label>
			        	</div>
				<div class="input-field col s8 valign">
					<select id="extension" name="extension" class="{{ $synthesiscmsMainColor }}-text">
						<!-- TODO: add extensions groups wiht <optgroup> -->
						@php
						$extensions = config("synthesiscmsextensions.extensions");

						while (list(,$extension) = each($extensions)) {
							$kpath = 'App\\Extensions\\' . $extension . '\\ExtensionKernel';
							$kernel = new $kpath;
							if($kernel->getExtensionType() == App\SynthesisCMS\API\SynthesisExtensionType::Module){
								echo("<option value='" . $extension . "'>" . $kernel->getExtensionName() . "</option>");
							}
						}
						@endphp
					</select>
					<label>{{ trans('synthesiscms/extensions.choose_extension') }}</label>
				</div>
				<button type="submit" class="valign col s4 text-center btn btn-large waves-effect waves-light {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}"><i class="material-icons white-text right">send</i>{{ trans('synthesiscms/admin.create_route') }}</button>
			</form>
			</div>
		</div>
	@endsection
