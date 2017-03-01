<div class="col s12 row">
	<div class="row"></div>
	<p class="center text-center" style="margin-bottom: 10px;">{{ trans('Nitrogen::nitrogen.applet_enable_header') }}</p>
	<div class="switch center">
		<label>
			{{ trans('Nitrogen::nitrogen.disable') }}
			<input type="checkbox" name="enabled" id="enabled" @if($model->enabled) checked @endif>
				<span class="lever"></span>
				{{ trans('Nitrogen::nitrogen.enable') }}
			</label>
		</div>
		<div class="row"></div>
		<a href="{{ url()->current() }}/create" class="waves-effect waves-light btn-large btn-floating {{ $synthesiscmsMainColor }} white-text {{ $synthesiscmsMainColorClass }}" style="position: absolute; top: 40px; right: 40px;">
			<i class="material-icons">add</i>
		</a>
		@php
		$ct = 0;
		@endphp
		{{ csrf_field() }}
		<div class="col s12">
			<p class="col s6 center">
				<input class="filled-in" type="checkbox" id="hasButton" name="hasButton" @if($model->hasButton) checked="checked" @endif>
				<label for="hasButton" class="{{ $synthesiscmsMainColor }}-text">{{ trans("Nitrogen::nitrogen.item_hasButton") }}</label>
			</p>
		</div>
		<ul class="collapsible popout col s12 row" data-collapsible="accordion">
			<li>
				<div class="collapsible-header {{ $synthesiscmsMainColor }}-text" id="buttonCollapsible" style="pointer-events: none;"><i class="material-icons {{ $synthesiscmsMainColor }}-text center">radio_button_checked</i>{{ trans("Nitrogen::nitrogen.item_hasButton") }}</div>
				<div class="collapsible-body col s12 card-panel z-depth-3">
					<div class="input-field col s12 l6">
						<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">link</i>
						<input id="button_text" name="button_text" type="text" value="{{ $model->buttonText }}">
						<label for="button_text">{{ trans("Nitrogen::nitrogen.button_text") }}</label>
					</div>
					<div class="input-field col s12 l6">
						<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">link</i>
						<input id="button_link" name="button_link" type="text" value="{{ $model->buttonLink }}">
						<label for="button_link">{{ trans("Nitrogen::nitrogen.button_link") }}</label>
					</div>
					<div class="input-field col s12 l6">
						<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">link</i>
						<input id="button_waves_color" name="button_waves_color" type="text" value="{{ $model->buttonWavesColor }}">
						<label for="button_waves_color">{{ trans("Nitrogen::nitrogen.button_waves_color") }}</label>
					</div>
					<div class="input-field col s12 l6">
						<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">link</i>
						<input id="button_color" name="button_color" type="text" value="{{ $model->buttonColor }}">
						<label for="button_color">{{ trans("Nitrogen::nitrogen.button_color") }}</label>
					</div>
					<div class="input-field col s12 l6">
						<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">link</i>
						<input id="button_class" name="button_class" type="text" value="{{ $model->buttonClass }}">
						<label for="button_class">{{ trans("Nitrogen::nitrogen.button_class") }}</label>
					</div>
					<div class="input-field col s12 l6">
						<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">link</i>
						<input id="button_text_color" name="button_text_color" type="text" value="{{ $model->buttonTextColor }}">
						<label for="button_text_color">{{ trans("Nitrogen::nitrogen.button_text_color") }}</label>
					</div>
				</div>
			</li>
		</ul>
		<script>
		var buttonCollapsible = false;
		$(document).ready(function(){
			if({!! json_encode($model->hasButton) !!}){
				buttonCollapsible = true;
				$("#buttonCollapsible").click();
				buttonCollapsible = false;
			}
		});
		$("#hasButton").click(function() {
			buttonCollapsible = true;
			$("#buttonCollapsible").click();
			buttonCollapsible = false;
		});
		$("#buttonCollapsible").click(function( event ) {
			if(!buttonCollapsible){
				event.preventDefault();
			}
		});
		</script>
		<div class="row"></div>
		<table class="col s12 highlight centered">
			<thead>
				<tr>
					<th class="center"><i class="material-icons {{ $synthesiscmsMainColor }}-text center">delete_sweep</i></td>
					<th class="center"><p class="center">{{ trans('Nitrogen::nitrogen.header_id') }}</p></td>
					<th class="center"><p class="center">{{ trans('Nitrogen::nitrogen.header_title') }}</p></td>
					<th class="center"><p class="center">{{ trans('Nitrogen::nitrogen.edit') }}</p></td>
					<th class="center"><p class="center">{{ trans('Nitrogen::nitrogen.delete') }}</p></td>
					<th class="center"><p class="center">{{ trans('Nitrogen::nitrogen.order') }}</p></td>
				</tr>
			</thead>
			<tbody>
				@php
				use App\Extensions\Nitrogen\Models\NitrogenItem;
				$items_raw = NitrogenItem::where('slider', $model->id);
				$items_count = $items_raw->count();
				$array = array();
				$posctr = 0;
				for($id = 0; $posctr < $items_count; $posctr++){
					$itm = NitrogenItem::where(['slider' => $model->id, 'before' => $id])->first();
					array_push($array, $itm);
					$id = $itm->id;
				}
				$items = collect($array);
				$mainctr = 0;
				function printItemWorker($item, $ct, $items_count, $model, $first, $last){
					return view()->make('Nitrogen::partials.item')->with(['item' => $item, 'ct' => $ct, 'items_count' => $items_count, 'model' => $model, 'first' => $first, 'last' => $last]);
				}
				function printItem($item, $ct, $items_count, $model, &$mainctr){
					$out = "";
					$mainctr++;
					$out .= printItemWorker($item, $ct, $items_count, $model, $mainctr == 1, $mainctr == $items_count);
					echo $out;
				}
				@endphp
				@foreach ($items as $key => $item)
					@php
					$ct++;
					echo printItem($item, $ct, $items_count, $model, $mainctr);
					@endphp
				@endforeach
				@if($ct == 0)
					<tr><td colspan="8"><div class="col s12 center text-center"><h5>{{ trans("Nitrogen::nitrogen.empty") }}</h5></div></td></tr>
				@endif
			</tbody>
		</table>
	</div>
