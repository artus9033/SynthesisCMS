<div class="col s12 grey-text text-darken-2">{{ trans("Lithium::messages.showHeader") }}</div>
<div class="switch col s12">
	<label>
		{!! trans("Lithium::lithium.switch_off") !!}
		<input type="checkbox" name="showHeader" @if($extension_instance->showHeader) checked @endif>
		<span class="lever"></span>
		{!! trans("Lithium::lithium.switch_on") !!}
	</label>
</div>
<div class="input-field col s8 offset-s2 valign" id="molecule-div">
	<select id="lithium-article" name="lithium-article" class="{{ $synthesiscmsMainColor }}-text">
		@foreach (\App\Models\Content\Article::all() as $key => $value)
			@php
				if($value->id == \App\Extensions\Lithium\Models\LithiumExtension::where('id', $page->id)->first()->article){
					$selected = "selected";
				}else{
					$selected = "";
				}
			@endphp
			<option {{ $selected }} value="{{ $value->id }}" class="card-panel col s10 offset-s1 red white-text"><h5>{{ App\Toolbox::string_truncate($value->title, 40) }}&nbsp;(ID&nbsp;{{ $value->id }})</h5></option>
		@endforeach
	</select>
	<label>{{ trans("Lithium::messages.choose_article") }}</label>
</div>