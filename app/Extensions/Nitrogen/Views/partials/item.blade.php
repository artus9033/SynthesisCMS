<tr>
	<td class="center">
		<input class="item_checkbox filled-in" type="checkbox" id="checkbox{{ $item->id }}" name="item_checkbox{{ $item->id }}">
		<label for="checkbox{{ $item->id }}"></label>
	</td>
	<td class="center">
		<p class="center">{{ $item->id }}</p>
	</td>
	<td class="center">
		<p class="center">@if($item->slider != $model->id) <i class="material-icons {{ $synthesiscmsMainColor }}-text">subdirectory_arrow_right</i> @endif{{ App\Toolbox::string_truncate($item->title, 7) }}</p>
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
			<a href="{{ url()->current() }}/up/{{ $item->id }}" class="col s6 btn-flat {{ $synthesiscmsMainColor }}-text hoverable waves-effect waves-{{ $synthesiscmsMainColor }} @if($first) disabled @endif">
				<i class="material-icons center">keyboard_arrow_up</i>
			</a>
			<a href="{{ url()->current() }}/down/{{ $item->id }}" class="col s6 btn-flat {{ $synthesiscmsMainColor }}-text hoverable waves-effect waves-{{ $synthesiscmsMainColor }} @if($last) disabled @endif">
				<i class="material-icons center">keyboard_arrow_down</i>
			</a>
		</td>
	</tr>
