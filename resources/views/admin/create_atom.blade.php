@extends('layouts.admin')

@section('title')
	{{ trans('synthesiscms/admin.create_atom')}}
@endsection

@section('head')
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
</style>
@endsection

@section('breadcrumbs')
	<a href="/admin" class="breadcrumb">{{ trans('synthesiscms/admin.backend') }}</a>
	<a href="/admin/manage_routes" class="breadcrumb">{{ trans('synthesiscms/admin.manage_atoms') }}</a>
	<a class="breadcrumb">{{ trans('synthesiscms/admin.create_atom') }}</a>
@endsection

@section('main')
	<div class="col s12 z-depth-1 grey lighten-4 row card" style="display: inline-block; padding: 0px 48px 0px 48px; border: 1px solid #EEE;">
		<div class="card-content">
			<div class="card-title col s12">
				<h3 class="teal-text valign-wrapper"><i class="material-icons prefix teal-text medium valign">create</i>&nbsp;{{ trans('synthesiscms/admin.create_atom') }}</h3>
				</div>
				<div class="divider teal col s12"></div>
				<div class="col s12 row"></div>
				{!! Form::open(array('class' => 'form')) !!}
					<div class="input-field col s12 tooltipped" data-position="top" data-delay="50" data-tooltip="{{ trans('synthesiscms/admin.create_atom_title_tooltip') }}">
						<i class="material-icons prefix teal-text">label_outline</i>
				          <input id="title" type="text" name="title" class="validate">
				          <label for="title">{{ trans('synthesiscms/admin.create_atom_title_label') }}</label>
			        	</div>
					<div class="input-field col s12 tooltipped" data-position="top" data-delay="50" data-tooltip="{{ trans('synthesiscms/admin.create_atom_description_tooltip') }}">
						<i class="material-icons prefix teal-text">description</i>
				          <textarea id="description" type="text" name="description" class="materialize-textarea"></textarea>
				          <label for="description">{{ trans('synthesiscms/admin.create_atom_description_label') }}</label>
			        	</div>
					<div class="row col s12 center">
						<div class="input-field col s8 offset-s2 valign" id="molecule-div">
							<select id="molecule" name="molecule" class="teal-text">
									@foreach (App\Molecule::all() as $key => $value)
										<option value="{{ $value->id }}" class="card-panel col s10 offset-s1 red white-text truncate"><h5>{{ $value->title }}</h5></option>
									@endforeach
							</select>
							<label>{{ trans('synthesiscms/modules.choose_molecule') }}</label>
						</div>
					</div>
				<button type="submit" class="offset-s4 valign col s4 text-center btn btn-large waves-effect waves-light teal"><i class="material-icons white-text right">send</i>{{ trans('synthesiscms/admin.create_atom') }}</button>
				<div class="col s12 row"></div>
			{!! Form::close() !!}
			</div>
		</div>
	@endsection
