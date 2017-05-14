<div class="input-field col s8 offset-s2 valign" id="molecule-div">
	<select id="hydrogen-molecule" name="hydrogen-molecule" class="{{ $synthesiscmsMainColor }}-text">
		@foreach (\App\Models\Content\Molecule::all() as $key => $value)
			@php
			if($value->id == $extension_instance->molecule){
				$selected = "selected";
			}else{
				$selected = "";
			}
			@endphp
			<option {{ $selected }} value="{{ $value->id }}" class="card-panel col s10 offset-s1 red white-text"><h5>{{ App\Toolbox::string_truncate($value->title, 40) }}&nbsp;(ID&nbsp;{{ $value->id }})</h5></option>
		@endforeach
	</select>
	<label>{{ trans("Hydrogen::messages.choose_molecule") }}</label>
</div>
<div class="input-field col s8 offset-s2 valign" id="molecule-div">
	<select id="list_column_count" name="list_column_count" class="{{ $synthesiscmsMainColor }}-text">
		@foreach (\App\Models\Content\Molecule::all() as $key => $value)
			@php
			$selected1 = "";
			$selected2 = "";
			if($extension_instance->list_column_count == 1){
				$selected1 = "selected";
			}else{
				$selected2 = "selected";
			}
			@endphp
		@endforeach
		<option {{ $selected1 }} value="1" class="card-panel col s10 offset-s1 red white-text"><h5>{{ trans('Hydrogen::hydrogen.one_column') }}</h5></option>
		<option {{ $selected2 }} value="2" class="card-panel col s10 offset-s1 red white-text"><h5>{{ trans('Hydrogen::hydrogen.two_columns') }}</h5></option>
	</select>
	<label>{{ trans("Hydrogen::messages.choose_list_column_count") }}</label>
</div>
<div class="input-field col s8 offset-s2">
	<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">view_column</i>
	<input id="atoms_on_single_page" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="atoms_on_single_page" type="number" min="1" value="{{ $extension_instance->atoms_on_single_page }}">
	<label for="atoms_on_single_page">{{ trans("Hydrogen::messages.input_atoms_on_single_page") }}</label>
</div>
<div class="col s12">{{ trans("Hydrogen::messages.showHeader") }}</div>
<div class="switch col s12">
    <label>
		{!! trans("Hydrogen::hydrogen.switch_off") !!}
      <input type="checkbox" name="showHeader" @if($extension_instance->showHeader) checked @endif>
      <span class="lever"></span>
		{!! trans("Hydrogen::hydrogen.switch_on") !!}
    </label>
</div>
