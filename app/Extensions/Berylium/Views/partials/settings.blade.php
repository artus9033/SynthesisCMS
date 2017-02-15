<div class="col s12 row">
	<div class="row"></div>
	<p class="center text-center" style="margin-bottom: 10px;">{{ trans('Berylium::berylium.applet_enable_header') }}</p>
	<div class="switch center">
		<label>
			{{ trans('Berylium::berylium.disable') }}
			<input type="checkbox" name="enabled" id="enabled" @if($model->enabled) checked @endif>
				<span class="lever"></span>
				{{ trans('Berylium::berylium.enable') }}
			</label>
		</div>
		<div class="row"></div>
		<div class="btn-large btn-floating {{ $synthesiscmsMainColor }} white-text {{ $synthesiscmsMainColorClass }}" style="position: absolute; top: 40px; right: 10px;">
		  <a href="{{ url()->current() }}/create"><i class="material-icons">add</i></a>
		 </div>
		@php
		$ct = 0;
		//TODO: implement reordering of elements
		@endphp
		{{ csrf_field() }}
		<table class="col s12">
			<tbody>
				<tr>
					<td><i class="material-icons {{ $synthesiscmsMainColor }}-text center">delete_sweep</i></td>
					<td><p class="center">{{ trans('Berylium::berylium.header_id') }}</p></td>
					<td><p class="center">{{ trans('Berylium::berylium.header_title') }}</p></td>
					<td><p class="center">{{ trans('Berylium::berylium.header_category') }}</p></td>
					<td><p class="center">{{ trans('Berylium::berylium.header_type') }}</p></td>
					<td><p class="center">{{ trans('Berylium::berylium.delete') }}</p></td>
					<td><p class="center">{{ trans('Berylium::berylium.edit') }}</p></td>
				</tr>

		@foreach (App\Extensions\Berylium\Models\BeryliumItem::where('menu', $model->id)->get() as $key => $item)
			@php
			$ct++;
			@endphp
			<tr>
				<td>
					<input class="item_checkbox filled-in" type="checkbox" id="checkbox{{ $item->id }}" name="item_checkbox{{ $item->id }}">
					<label for="checkbox{{ $item->id }}"></label>
				</td>
				<td>
					<p class="center">{{ $item->id }}</p>
				</td>
				<td>
					<p class="center">@if($item->parent != 0) <i class="material-icons {{ $synthesiscmsMainColor }}-text">chevron_right</i> @endif{{ App\Toolbox::string_truncate($item->title, 7) }}</p>
				</td>
				<td>
					<p class="center">
						<i class="material-icons {{ $synthesiscmsMainColor }}-text">
						@php
							switch($item->category){
								case 1:
								echo "phonelink";
								break;
								case 2:
								echo "smartphone";
								break;
								case 3:
								echo "desktop_windows";
								break;
							}
						@endphp
					</i>
					</p>
				</td>
				<td>
					<p class="center">
						<i class="material-icons {{ $synthesiscmsMainColor }}-text">
						@php
							switch($item->category){
								case 1:
								echo "link";
								break;
								case 2:
								echo "donut_large";
								break;
								case 3:
								echo "group_work";
								break;
								case 3:
								echo "subtitles";
								break;
							}
						@endphp
					</i>
					</p>
				</td>
			<td>
				<a href="{{ url()->current() }}/delete/{{ $item->id }}" type="button" class="center btn btn-floating {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text hoverable waves-effect waves-light">
					<i class="material-icons white-text center">mode_edit</i>
				</a>
			</td>
			<td>
				<a href="{{ url()->current() }}/delete/{{ $item->id }}" type="button" class="center btn btn-floating {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text hoverable waves-effect waves-light">
					<i class="material-icons white-text center">delete</i>
				</a>
			</td>
			</tr>
		@endforeach
</tbody>
</table>
		@if($ct == 0)
			<div class="col s12 center text-center"><h5>{{ trans("Berylium::berylium.empty") }}</h5></div>
		@endif
	</div>
