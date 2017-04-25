<a href="{{ url()->current() }}/create"
   class="waves-effect waves-light btn-large btn-floating {{ $synthesiscmsMainColor }} white-text {{ $synthesiscmsMainColorClass }}"
   style="position: absolute; top: 40px; right: 40px;">
	<i class="material-icons">add</i>
</a>
<table class="col s12 highlight centered">
	<thead>
	<tr>
		<td class="center"><i class="material-icons {{ $synthesiscmsMainColor }}-text center">delete_sweep</i></td>
		<td class="center"><p class="center">{{ trans('Nitrogen::nitrogen.header_id') }}</p></td>
		<td class="center"><p class="center">{{ trans('Nitrogen::nitrogen.header_title') }}</p></td>
		<td class="center"><p class="center">{{ trans('Nitrogen::nitrogen.edit') }}</p></td>
		<td class="center"><p class="center">{{ trans('Nitrogen::nitrogen.delete') }}</p></td>
		<td></td>
	</tr>
	</thead>
	<tbody>
	@php
		use App\Extensions\Nitrogen\Models\NitrogenExtension;
		$items = NitrogenExtension::all();
		$items_count = $items->count();
		$mainctr = 0;
		$ct = 0;
		function printItemWorker($item, $ct, $items_count, $first, $last){
			return view()->make('Nitrogen::partials.item')->with(['item' => $item, 'ct' => $ct, 'items_count' => $items_count, 'first' => $first, 'last' => $last]);
		}
		function printItem($item, $ct, $items_count, &$mainctr){
			$out = "";
			$mainctr++;
			$out .= printItemWorker($item, $ct, $items_count, $mainctr == 1, $mainctr == $items_count);
			echo $out;
		}
	@endphp
	@foreach ($items as $key => $item)
		@php
			$ct++;
			echo printItem($item, $ct, $items_count, $mainctr);
		@endphp
	@endforeach
	@if($ct == 0)
		<tr>
			<td colspan="8">
				<div class="col s12 center text-center"><h5>{{ trans("Nitrogen::nitrogen.empty") }}</h5></div>
			</td>
		</tr>
	@endif
	</tbody>
</table>
