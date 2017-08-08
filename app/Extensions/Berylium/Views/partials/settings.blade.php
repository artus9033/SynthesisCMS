<div class="col s12 row">
	<div class="row"></div>
	<p class="center text-center col s10"
	   style="margin-bottom: 10px;">{{ trans('Berylium::berylium.applet_enable_header') }}</p>
	<div class="switch center col s10">
		<label>
			{{ trans('Berylium::berylium.disable') }}
			<input type="checkbox" name="enabled" id="enabled" @if($model->enabled) checked @endif>
			<span class="lever"></span>
			{{ trans('Berylium::berylium.enable') }}
		</label>
	</div>
	<a href="{{ url()->current() }}/create"
	   class="waves-effect waves-light btn-large btn-floating {{ $synthesiscmsMainColor }} white-text {{ $synthesiscmsMainColorClass }}">
		<i class="material-icons">add</i>
	</a>
	<div class="row"></div>
	@php
		$ct = 0;
	@endphp
	{{ csrf_field() }}
	<table class="col s12 highlight centered">
		<thead>
		<tr>
			<th class="center"><i class="material-icons {{ $synthesiscmsMainColor }}-text center">delete_sweep</i>
			</td>
			<th class="center"><p class="center">{{ trans('Berylium::berylium.header_id') }}</p>
			</td>
			<th class="center"><p class="center">{{ trans('Berylium::berylium.header_title') }}</p>
			</td>
			<th class="center"><p class="center">{{ trans('Berylium::berylium.header_category') }}</p>
			</td>
			<th class="center"><p class="center">{{ trans('Berylium::berylium.header_type') }}</p>
			</td>
			<th class="center"><p class="center">{{ trans('Berylium::berylium.edit') }}</p>
			</td>
			<th class="center"><p class="center">{{ trans('Berylium::berylium.delete') }}</p>
			</td>
			<th class="center"><p class="center">{{ trans('Berylium::berylium.order') }}</p>
			</td>
		</tr>
		</thead>
		<tbody>
		@php
			use App\Extensions\Berylium\Models\BeryliumItem;
			$items_raw = BeryliumItem::where('menu', $model->id);
			$items_count = $items_raw->count();
			$array = array();
			$posctr = 0;
			for($id = 0; $posctr < $items_count; $posctr++){
				$itm = BeryliumItem::where(['menu' => $model->id, 'before' => $id])->first();
				array_push($array, $itm);
				$id = $itm->id;
			}
			$items = collect($array);
			$mainctr = 0;
			function printItem($item, $ct, $items_count, $model, $first, $last){
				return view()->make('Berylium::partials.item')->with(['item' => $item, 'ct' => $ct, 'items_count' => $items_count, 'model' => $model, 'first' => $first, 'last' => $last]);
			}
			function printItemWithChildren($item, $ct, $items_count, $model, &$mainctr){
				$out = "";
				$mainctr++;
				$out .= printItem($item, $ct, $items_count, $model, $mainctr == 1, $mainctr == $items_count);
				$query = BeryliumItem::where(['menu' => $item->parentOf]);
				$childrenctr = 0;
				$children_count = $query->count();
				if($children_count){
					foreach($query->get() as $key => $itm){
						$childrenctr++;
						$out .= printItem($itm, $ct, $items_count, $model, $childrenctr == 1, $childrenctr == $children_count);
					}
				}
				echo $out;
			}
		@endphp
		@foreach ($items as $key => $item)
			@php
				$ct++;
				echo printItemWithChildren($item, $ct, $items_count, $model, $mainctr);
			@endphp
		@endforeach
		@if($ct == 0)
			<tr>
				<td colspan="8">
					<div class="col s12 center text-center"><h5>{{ trans("Berylium::berylium.empty") }}</h5></div>
				</td>
			</tr>
		@endif
		</tbody>
	</table>
</div>
