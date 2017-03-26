<div class="input-field col s8 offset-s2 valign" id="molecule-div">
	<select id="lithium-atom" name="lithium-atom" class="{{ $synthesiscmsMainColor }}-text">
		@foreach (\App\Models\Content\Atom::all() as $key => $value)
			@php
				if($value->id == \App\Extensions\Lithium\Models\LithiumExtension::where('id', $page->id)->first()->atom){
					$selected = "selected";
				}else{
					$selected = "";
				}
			@endphp
			<option {{ $selected }} value="{{ $value->id }}" class="card-panel col s10 offset-s1 red white-text"><h5>{{ App\Toolbox::string_truncate($value->title, 40) }}&nbsp;(ID&nbsp;{{ $value->id }})</h5></option>
		@endforeach
	</select>
	<label>{{ trans("Lithium::messages.choose_atom") }}</label>
</div>
<div class="col s12">{{ trans("Lithium::messages.showHeader") }}</div>
<div class="switch col s12">
	<label>
		Off
		<input type="checkbox" name="showHeader" @if($extension_instance->showHeader) checked @endif>
		<span class="lever"></span>
		On
	</label>
</div>