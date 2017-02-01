<div class="input-field col s8 offset-s2 valign" id="atom-div">
	<select id="lithium-atom" name="lithium-atom" class="{{ $synthesiscmsMainColor }}-text">
		@foreach (\App\Models\Content\Atom::all() as $key => $value)
			@php
				if($value->id == \App\Extensions\Lithium\Models\BeryliumExtension::where('id', $page->id)->first()->atom){
					$selected = "selected";
				}else{
					$selected = "";
				}
			@endphp
			<option {{ $selected }} value="{{ $value->id }}" class="card-panel col s10 offset-s1 red white-text"><h5>{{ App\Toolbox::string_truncate($value->title, 40) }}&nbsp;(ID&nbsp;{{ $value->id }})</h5></option>
		@endforeach
	</select>
	<label>{{ trans("lithium::messages.choose_atom") }}</label>
</div>
