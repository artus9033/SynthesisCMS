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
		@php
		$ct = 0;
		@endphp
		@foreach (App\Extensions\Berylium\Models\BeryliumItem::where('menu', $model->id) as $key => $item)
			@php
			$ct++;
			@endphp
			<!-- TODO: implement a visual drag-and-drop multi-level menu editor -->
		@endforeach
		@if($ct == 0)
			<div class="col s12 center text-center"><h5>{{ trans("Berylium::berylium.empty") }}</h5></div>
		@endif
	</div>