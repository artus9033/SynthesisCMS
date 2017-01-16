<div class="input-field col s8 offset-s2 valign" id="molecule-div">
	<select id="molecule" name="molecule" class="teal-text">
			@foreach (App\Molecule::all() as $key => $value)
				<option @php if($value->id == App\Modules\Hydrogen\Models\HydrogenModule::find($page->id)->molecule){ echo("selected"); } @endphp value="{{ $value->id }}" class="card-panel col s10 offset-s1 red white-text"><h5>{{ App\Toolbox::string_truncate($value->title, 40) }}&nbsp;(ID&nbsp;{{ $value->id }})</h5></option>
			@endforeach
	</select>
	<label>{{ trans('synthesiscms/modules.choose_molecule') }}</label>
</div>
