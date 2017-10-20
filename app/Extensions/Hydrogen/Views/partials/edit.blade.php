<style>
	#route-sel .caret {
		color: {{ $synthesiscmsMainColor }}    !important;
	}

	#route-sel .select-dropdown {
		border-bottom-color: {{ $synthesiscmsMainColor }}    !important;
	}

	label {
		text-align: left !important;
	}
</style>
<div class="col s12 grey-text text-darken-2">{{ trans("Hydrogen::messages.showHeader") }}</div>
<div class="switch col s12">
	<label>
		{!! trans("Hydrogen::hydrogen.switch_off") !!}
		<input type="checkbox" name="showHeader" @if($extension_instance->showHeader) checked @endif>
		<span class="lever"></span>
		{!! trans("Hydrogen::hydrogen.switch_on") !!}
	</label>
</div>
<div class="input-field col s8 offset-s2 valign" id="route-sel">
	<select id="hydrogen-articleCategory" name="hydrogen-articleCategory" class="{{ $synthesiscmsMainColor }}-text">
		@foreach (\App\Models\Content\ArticleCategory::all() as $key => $value)
			@php
				if($value->id == $extension_instance->articleCategory){
					$selected = "selected";
				}else{
					$selected = "";
				}
				$optionVal = App\Toolbox::string_truncate($value->title, 40) . "&nbsp;(ID&nbsp;" . $value->id . ")";
			@endphp
			<option {{ $selected }} value="{{ $value->id }}"
					class="card-panel col s10 offset-s1 red white-text">{{ $optionVal }}</option>
		@endforeach
	</select>
	<label>{{ trans("Hydrogen::messages.choose_article_category") }}</label>
</div>
<div class="input-field col s8 offset-s2 valign" id="route-sel">
	<select id="list_column_count" name="list_column_count" class="{{ $synthesiscmsMainColor }}-text">
		@foreach (\App\Models\Content\ArticleCategory::all() as $key => $value)
			@php
				$selected1 = "";
				$selected2 = "";
				$selected3 = "";
				if($extension_instance->list_column_count == 1){
					$selected1 = "selected";
				}else if($extension_instance->list_column_count == 2){
					$selected2 = "selected";
				}else{
					$selected3 = "selected";
				}
			@endphp
		@endforeach
		<option {{ $selected1 }} value="1"
				class="card-panel col s10 offset-s1 red white-text">{{ trans('Hydrogen::hydrogen.one_column') }}</option>
		<option {{ $selected2 }} value="2"
				class="card-panel col s10 offset-s1 red white-text">{{ trans('Hydrogen::hydrogen.two_columns') }}</option>
		<option {{ $selected3 }} value="3"
				class="card-panel col s10 offset-s1 red white-text">{{ trans('Hydrogen::hydrogen.three_columns') }}</option>
	</select>
	<label>{{ trans("Hydrogen::messages.choose_list_column_count") }}</label>
</div>
<div class="input-field col s8 offset-s2">
	<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">view_column</i>
	<input id="articles_on_single_page" onkeypress="return event.charCode >= 48 && event.charCode <= 57"
		   name="articles_on_single_page" type="number" min="1"
		   value="{{ $extension_instance->articles_on_single_page }}">
	<label for="articles_on_single_page">{{ trans("Hydrogen::messages.input_articles_on_single_page") }}</label>
</div>
<div class="input-field col s8 offset-s2 valign" id="route-sel">
	<select id="default_sorting_type" name="default_sorting_type" class="{{ $synthesiscmsMainColor }}-text">
		@foreach (\App\Extensions\Hydrogen\HydrogenSortingType::getConstants() as $key => $value)
			@php
				$selected = "";
				if($extension_instance->default_sorting_type == $value){
					$selected = "selected";
				}else{
					$selected = "";
				}
			@endphp
			<option {{ $selected }} value="{!! $value !!}"
					class="card-panel col s10 offset-s1 red white-text">{!! trans('Hydrogen::hydrogen.default_sorting_type_' . $value) !!}</option>
		@endforeach
	</select>
	<label>{{ trans("Hydrogen::hydrogen.choose_default_sorting_type") }}</label>
</div>
<div class="input-field col s8 offset-s2 valign" id="route-sel">
	<select id="default_sorting_direction" name="default_sorting_direction" class="{{ $synthesiscmsMainColor }}-text">
		@foreach (\App\Extensions\Hydrogen\HydrogenSortingDirection::getConstants() as $key => $value)
			@php
				$selected = "";
				if($extension_instance->default_sorting_direction == $value){
					$selected = "selected";
				}else{
					$selected = "";
				}
			@endphp
			<option {{ $selected }} value="{!! $value !!}"
					class="card-panel col s10 offset-s1 red white-text">{{ trans('Hydrogen::hydrogen.default_sorting_direction_' . $value) }}</option>
		@endforeach

	</select>
	<label>{{ trans("Hydrogen::hydrogen.choose_default_sorting_direction") }}</label>
</div>