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
		<a href="{{ url()->current() }}/create" class="waves-effect waves-light btn-large btn-floating {{ $synthesiscmsMainColor }} white-text {{ $synthesiscmsMainColorClass }}" style="position: absolute; top: 40px; right: 10px;">
			<i class="material-icons">add</i>
		</a>
		@php
		$ct = 0;
		@endphp
		{{ csrf_field() }}
		<table class="col s12">
			<tbody>
				<tr>
					<td class="center"><i class="material-icons {{ $synthesiscmsMainColor }}-text center">delete_sweep</i></td>
					<td class="center"><p class="center">{{ trans('Berylium::berylium.header_id') }}</p></td>
					<td class="center"><p class="center">{{ trans('Berylium::berylium.header_title') }}</p></td>
					<td class="center"><p class="center">{{ trans('Berylium::berylium.header_category') }}</p></td>
					<td class="center"><p class="center">{{ trans('Berylium::berylium.header_type') }}</p></td>
					<td class="center"><p class="center">{{ trans('Berylium::berylium.edit') }}</p></td>
					<td class="center"><p class="center">{{ trans('Berylium::berylium.delete') }}</p></td>
					<td class="center"><p class="center">{{ trans('Berylium::berylium.order') }}</p></td>
				</tr>
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
			@endphp
			@foreach ($items as $key => $item)
				@php
				$ct++;
				@endphp
				<tr>
					<td class="center">
						<input class="item_checkbox filled-in" type="checkbox" id="checkbox{{ $item->id }}" name="item_checkbox{{ $item->id }}">
						<label for="checkbox{{ $item->id }}"></label>
					</td>
					<td class="center">
						<p class="center">{{ $item->id }}</p>
					</td>
					<td class="center">
						<p class="center">@if($item->parent != 0) <i class="material-icons {{ $synthesiscmsMainColor }}-text">subdirectory_arrow_right</i> @endif{{ App\Toolbox::string_truncate($item->title, 7) }}</p>
						</td>
						<td class="center">
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
						<td class="center">
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
						<td class="center">
							<a href="{{ url()->current() }}/edit/{{ $item->id }}" class="center btn-large btn-floating {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text hoverable waves-effect waves-light">
								<i class="material-icons white-text center">mode_edit</i>
							</a>
						</td>
						<td class="center">
							<a href="{{ url()->current() }}/delete/{{ $item->id }}" class="center btn-large btn-floating {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text hoverable waves-effect waves-light">
								<i class="material-icons white-text center">delete</i>
							</a>
						</td>
						<td class="center">
							<a href="{{ url()->current() }}/up/{{ $item->id }}" class="col s6 btn-flat {{ $synthesiscmsMainColor }}-text hoverable waves-effect waves-{{ $synthesiscmsMainColor }} @if($item->parent == 0) @if($ct == 1) disabled @endif @else @if(App\App\Extensions\Berylium\Model\BeryliumItem::where(['menu' => $model->id, 'parent' => $item->parent, 'id' => $item->before])->count() == 0) disabled @endif @endif">
								<i class="material-icons center">keyboard_arrow_up</i>
							</a>
							<a href="{{ url()->current() }}/down/{{ $item->id }}" class="col s6 btn-flat {{ $synthesiscmsMainColor }}-text hoverable waves-effect waves-{{ $synthesiscmsMainColor }} @if($ct == $items_count) disabled @endif">
								<i class="material-icons center">keyboard_arrow_down</i>
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
