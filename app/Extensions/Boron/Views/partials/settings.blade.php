<div class="col s12 row">
	<div class="row"></div>
	<p class="center text-center" style="margin-bottom: 10px;">{{ trans('Boron::boron.applet_enable_header') }}</p>
	<div class="switch center">
		<label>
			{{ trans('Boron::boron.disable') }}
			<input type="checkbox" name="enabled" id="enabled" @if($model->enabled) checked @endif>
				<span class="lever"></span>
				{{ trans('Boron::boron.enable') }}
			</label>
		</div>
		<div class="row">
			<div class="input-field col s12">
				<i class="material-icons prefix">link</i>
				<input value="{!! $model->url !!}" id="url" name="url" type="text" class="validate">
				<label for="url">{{ trans('Boron::boron.url') }}</label>
			</div>
		</div>
	</div>
