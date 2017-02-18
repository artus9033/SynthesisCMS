@extends('layouts/only_empty_body_head')

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

label{
	text-align: left !important;
}
</style>
@endsection

@section('main')
	<div class="col s12 z-depth-1 lighten-4 row card" style="display: inline-block; padding: 0px 48px 0px 48px; border: 1px solid #EEE;">
		<div class="card-content">
			<div class="card-title col s12">
				<h3 class="{{ $synthesiscmsMainColor }}-text valign-wrapper"><i class="material-icons prefix {{ $synthesiscmsMainColor }}-text medium valign">settings</i>&nbsp;{{ trans('synthesiscms/admin.applet_settings', ['applet' => $kernel->getExtensionName()]) }}</h3>
			</div>
			<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12"></div>
			<form id="form" class="col s12 row" method="post" action="">
				{{ csrf_field() }}
				<div class="input-field col s6">
					<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">title</i>
					<input name="title" id="title" type="text" value="{{ $item->title }}">
					<label for="title">{{ trans("Berylium::berylium.item_title") }}</label>
				</div>
				<div class="input-field col s6 applet-source-input" id="applet-link">
					<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">link</i>
					<input name="link" id="link" type="text" @if($item->type == 1) value="{{ $item->data }}" @endif>
					<label for="link">{{ trans("Berylium::berylium.item_link") }}</label>
				</div>
				<div class="col s6 applet-source-input" id="applet-molecule" style="display: none;">
					<a class="waves-effect waves-light {{ $synthesiscmsMainColorClass }} btn-large">
						<i class="material-icons white-text left">group_work</i>
						{{ trans("Berylium::berylium.item_molecule") }}
					</a>
					<input name="molecule" id="molecule" type="text" hidden="hidden" @if($item->type == 3) value="{{ $item->data }}" @endif>
				</div>
				<div class="input-field col s6 applet-source-input" id="applet-atom" style="display: none;">
					<a class="waves-effect waves-light {{ $synthesiscmsMainColorClass }} btn-large">
						<i class="material-icons white-text left">donut_large</i>
						{{ trans("Berylium::berylium.item_atom") }}
					</a>
					<input name="atom" id="atom" type="text" hidden="hidden" @if($item->type == 2) value="{{ $item->data }}" @endif>
				</div>
				<div class="input-field col s6 applet-source-input" id="applet-placeholder" style="display: none;">
				</div>
				<div class="input-field col s12 {{ $synthesiscmsMainColor }}-text" id="molecule-div">
					<select id="category" name="category">
						@php
						$categoryClass = new \ReflectionClass('App\\Extensions\\Berylium\\BeryliumItemCategory');
						$categoryClassConstants = $categoryClass->getConstants();
						@endphp
						@foreach ($categoryClassConstants as $key => $cat)
							<option @if($item->category == $cat) selected @endif value="{{ $cat }}">{{ trans("Berylium::berylium.category_" . $cat) }}</option>
						@endforeach
					</select>
					<label>{{ trans("Berylium::berylium.item_category") }}</label>
				</div>
				<div class="input-field col s12 {{ $synthesiscmsMainColor }}-text" id="molecule-div">
					<select id="type" name="type">
						@php
						$typeClass = new \ReflectionClass('App\\Extensions\\Berylium\\BeryliumItemType');
						$typeClassConstants = $typeClass->getConstants();
						@endphp
						@foreach ($typeClassConstants as $key => $type)
							<option @if($item->type == $type) selected @endif value="{{ $type }}">{{ trans("Berylium::berylium.type_" . $type) }}</option>
						@endforeach
					</select>
					<label>{{ trans("Berylium::berylium.item_type") }}</label>
				</div>
			</div>
			<script>
			$('#type').on('change', function() {
				if(this.value == 1){
					$('.applet-source-input').css("display", "none");
					$('#applet-link').fadeIn();
				}else if(this.value == 2){
					$('.applet-source-input').css("display", "none");
					$('#applet-atom').fadeIn();
				}else if(this.value == 3){
					$('.applet-source-input').css("display", "none");
					$('#applet-molecule').fadeIn();
				}else if(this.value == 4){
					$('.applet-source-input').css("display", "none");
					$('#applet-placeholder').fadeIn();
				}
			});
			</script>
			<button type="submit" class="col s12 center text-center btn-flat waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}">{{ trans('synthesiscms/admin.save_applet') }}</button>
			<div class="row"></div>
		</form>
	</div>
@endsection
