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
		<table class="col s12 highlight centered">
			<thead>
				<tr>
					<th class="center"><i class="material-icons {{ $synthesiscmsMainColor }}-text center">delete_sweep</i></td>
					<th class="center"><p class="center">{{ trans('Nitrogen::nitrogen.header_id') }}</p></td>
					<th class="center"><p class="center">{{ trans('Nitrogen::nitrogen.header_title') }}</p></td>
					<th class="center"><p class="center">{{ trans('Nitrogen::nitrogen.header_hasButton') }}</p></td>
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
