<div class="col s12 grey-text text-darken-2">{{ trans("Ferrum::messages.show_header") }}</div>
<div class="switch col s12">
	<label>
		{!! trans("Ferrum::ferrum.switch_off") !!}
		<input type="checkbox" name="showHeader" @if($extension_instance->showHeader) checked @endif>
		<span class="lever"></span>
		{!! trans("Ferrum::ferrum.switch_on") !!}
	</label>
</div>
<div class="col s12 row"></div>
<div class="col s12 grey-text text-darken-2">{{ trans("Ferrum::messages.edit_form") }}</div>
@include('Ferrum::lib/libArtusVisualFormEditor', ['mode' => 'editor', 'formInJson' => $extension_instance->formInJson])