@extends('layouts.admin')

@section('title')
	{{ trans('synthesiscms/admin.create_atom')}}
@endsection

@section('side-nav-active', 'manage_atoms')

@section('head')
<style>
	#molecule-div .caret {
	  color: {{ $synthesiscmsMainColor }} !important;
	}

	#molecule-div .select-dropdown {
	  border-bottom-color: {{ $synthesiscmsMainColor }} !important;
	}

	#molecule-div .select-wrapper {
	  margin-top: 5px !important;
	}
</style>
@endsection

@section('breadcrumbs')
	<a href="{{ url('/admin') }}" class="breadcrumb">{{ trans('synthesiscms/admin.backend') }}</a>
	<a href="{{ url('/admin/manage_atoms') }}" class="breadcrumb">{{ trans('synthesiscms/admin.manage_atoms') }}</a>
	<a class="breadcrumb">{{ trans('synthesiscms/admin.create_atom') }}</a>
@endsection

@section('main')
	<div>
		<div class="card-content">
			<div class="card-title col s12">
				<h3 class="{{ $synthesiscmsMainColor }}-text valign-wrapper col s8"><i class="material-icons prefix {{ $synthesiscmsMainColor }}-text medium valign">create</i>&nbsp;{{ trans('synthesiscms/admin.create_atom') }}</h3>
				</div>
				<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12"></div>
				<div class="col s12 row"></div>
				<form class="form" method="POST" action="">
					{{ csrf_field() }}
					<div class="input-field col s12 tooltipped" data-position="top" data-delay="50" data-tooltip="{{ trans('synthesiscms/admin.create_atom_title_tooltip') }}">
						<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">label_outline</i>
				          <input id="title" type="text" name="title" class="validate">
				          <label for="title">{{ trans('synthesiscms/admin.create_atom_title_label') }}</label>
			        	</div>
					<div class="row col s12 container">
						<label for="desc">{{ trans('synthesiscms/atom.content') }}</label>
						<textarea class="editor" id="desc" name="desc"></textarea>
					</div>
					<script>
					$(document).ready(function(){
						$(".editor").trumbowyg('html', ''); //empty content
					});
					</script>
					<div class="col s12 tooltipped" data-position="top" data-delay="50" data-tooltip="{{ trans('synthesiscms/atom.hasImageTooltip') }}">
						<p class="col s6 offset-s4">
							<input class="filled-in" type="checkbox" id="hasImage" name="hasImage">
							<label for="hasImage" class="{{ $synthesiscmsMainColor }}-text">{{ trans('synthesiscms/atom.hasImage') }}</label>
						</p>
					</div>
					<div class="row"></div>
					<ul class="collapsible popout col s12 row" data-collapsible="accordion">
						<li>
							<div class="collapsible-header {{ $synthesiscmsMainColor }}-text" id="collapsible" style="pointer-events: none;"><i class="material-icons {{ $synthesiscmsMainColor }}-text center">photo</i>{{ trans('synthesiscms/atom.atomImage') }}</div>
							<div class="collapsible-body col s12 card-panel z-depth-3">
								<div class="col s12 row"></div>
								<div class="input-field col s6">
									<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">link</i>
									<input id="image" name="image" type="text">
									<label for="image">{{ trans('synthesiscms/atom.imageURL') }}</label>
								</div>
								<script>
                                    function atomImagePickerCallback(url) {
                                        $('#image').val(url);
                                    }
								</script>
								@include('partials/image-picker', ['picker_modal_id' => 'atom_create_item_picker', 'callback_function_name' => 'atomImagePickerCallback', 'followIframeParentHeight' => false])
								<a href="#atom_create_item_picker"
								   class="btn btn-large center col s6 row waves-effect waves-light {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text">
									<i class="material-icons white-text">attachment</i>&nbsp;&nbsp;{{ trans('synthesiscms/atom.imageFile') }}
								</a>
							</div>
						</li>
					</ul>
					<script>
					var imgCollapsible = false;
					$("#hasImage").click(function() {
						imgCollapsible = true;
						$("#collapsible").click();
						imgCollapsible = false;
					});
					$("#collapsible").click(function( event ) {
						if(!imgCollapsible){
							event.preventDefault();
						}
					});
					</script>
					<div class="row col s12 center">
						<div class="input-field col s8 offset-s2 valign" id="molecule-div">
							<select id="molecule" name="molecule" class="{{ $synthesiscmsMainColor }}-text">
									@foreach (App\Models\Content\Molecule::all() as $key => $value)
										<option value="{{ $value->id }}" class="card-panel col s10 offset-s1 red white-text truncate"><h5>{{ $value->title }}</h5></option>
									@endforeach
							</select>
							<label>{{ trans('synthesiscms/extensions.choose_molecule') }}</label>
						</div>
					</div>
				<button type="submit" class="offset-s4 valign col s4 text-center btn btn-large waves-effect waves-light {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}"><i class="material-icons white-text right">send</i>{{ trans('synthesiscms/admin.create_atom') }}</button>
				<div class="col s12 row"></div>
				<a class="btn-flat waves-effect waves-yellow {{ $synthesiscmsMainColor }}-text col s2 offset-s5" href="{{ URL::previous() }}"><i class="material-icons {{ $synthesiscmsMainColor }}-text left">cancel</i>{{ trans('synthesiscms/admin.cancel_atom') }}</a>
				<div class="col s12 row"></div>
			</form>
			</div>
		</div>
	@endsection
