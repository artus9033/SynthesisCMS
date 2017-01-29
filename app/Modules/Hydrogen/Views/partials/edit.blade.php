<div class="input-field col s8 offset-s2 valign" id="molecule-div">
	<select id="hydrogen-molecule" name="hydrogen-molecule" class="{{ $synthesiscmsMainColor }}-text">
		@foreach (\App\Molecule::all() as $key => $value)
			@php
				if($value->id == \App\Modules\Hydrogen\Models\HydrogenModule::where('id', $page->id)->first()->molecule){
					$selected = "selected";
				}else{
					$selected = "";
				}
			@endphp
			<option {{ $selected }} value="{{ $value->id }}" class="card-panel col s10 offset-s1 red white-text"><h5>{{ App\Toolbox::string_truncate($value->title, 40) }}&nbsp;(ID&nbsp;{{ $value->id }})</h5></option>
		@endforeach
	</select>
	<label>{{ trans("hydrogen::messages.choose_molecule") }}</label>
</div>
