<tr>
	<td class="center">
		<input class="item_checkbox filled-in" type="checkbox" id="checkbox{{ $item->id }}" name="item_checkbox{{ $item->id }}">
		<label for="checkbox{{ $item->id }}"></label>
	</td>
	<td class="center">
		<p class="center">{{ $item->id }}</p>
	</td>
	<td class="center">
		<p class="center">{{ $item->title }}</p>
	</td>
	<td class="center">
		<a href="{{ url()->current() }}/{{ $item->id }}"
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
</tr>
