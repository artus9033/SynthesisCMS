<tr>
	<td class="center">
		<label>
			<input class="item_checkbox filled-in" type="checkbox" id="checkbox{{ $item->id }}"
					name="item_checkbox{{ $item->id }}">
			<span></span>
		</label>
	</td>
	<td class="center">
		<p class="center">{{ $item->id }}</p>
	</td>
	<td class="center">
		<p class="center tooltipped" data-tooltip="{{ $item->title }}" data-position="top">@if($item->menu != $model->id) <i class="material-icons {{ $synthesiscmsMainColor }}-text">subdirectory_arrow_right</i> @endif{{ App\Toolbox::string_truncate($item->title, 7) }}
		</p>
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
					switch($item->type){
						case 1:
						echo "link";
						break;
						case 2:
						echo "pages";
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
		<a href="{{ url()->current() }}/edit/{{ $item->id }}"
		   class="center btn-large btn-floating {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text hoverable waves-effect waves-light">
			<i class="material-icons white-text center">mode_edit</i>
		</a>
	</td>
	<td class="center">
		<a href="{{ url()->current() }}/delete/{{ $item->id }}"
		   class="center btn-large btn-floating {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text hoverable waves-effect waves-light">
			<i class="material-icons white-text center">delete</i>
		</a>
	</td>
	<td class="center">
		<a href="{{ url()->current() }}/up/{{ $item->id }}"
		   class="col s6 btn-flat {{ $synthesiscmsMainColor }}-text hoverable waves-effect waves-{{ $synthesiscmsMainColor }} @if($first) disabled @endif">
			<i class="material-icons center">keyboard_arrow_up</i>
		</a>
		<a href="{{ url()->current() }}/down/{{ $item->id }}"
		   class="col s6 btn-flat {{ $synthesiscmsMainColor }}-text hoverable waves-effect waves-{{ $synthesiscmsMainColor }} @if($last) disabled @endif">
			<i class="material-icons center">keyboard_arrow_down</i>
		</a>
	</td>
</tr>
