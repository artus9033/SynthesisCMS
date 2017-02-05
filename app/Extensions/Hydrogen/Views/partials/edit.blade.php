<div class="input-field col s8 offset-s2 valign" id="molecule-div">
	<select id="hydrogen-molecule" name="hydrogen-molecule" class="{{ $synthesiscmsMainColor }}-text">
		@foreach (\App\Models\Content\Molecule::all() as $key => $value)
			@php
				if($value->id == \App\Extensions\Hydrogen\Models\HydrogenExtension::where('id', $page->id)->first()->molecule){
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
				if(\App\Extensions\Hydrogen\Models\HydrogenExtension::where('id', $page->id)->first()->list_column_count == 1){
					$selected1 = "selected";
				}else{
					$selected2 = "selected";
				}
			@endphp
			<option {{ $selected1 }} value="1" class="card-panel col s10 offset-s1 red white-text"><h5>{{ trans('Hydrogen::hydrogen.one_column') }}</h5></option>
			<option {{ $selected2 }} value="2" class="card-panel col s10 offset-s1 red white-text"><h5>{{ trans('Hydrogen::hydrogen.two_columns') }}</h5></option>
		@endforeach
	</select>
	<label>{{ trans("Hydrogen::messages.choose_list_column_count") }}</label>
</div>
