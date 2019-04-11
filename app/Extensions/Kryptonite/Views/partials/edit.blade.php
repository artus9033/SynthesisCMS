<div class="col s12 row">
	<div class="row"></div>
	<p class="center text-center" style="margin-bottom: 10px;">{{ trans('Kryptonite::kryptonite.url_header') }}</p>
	<div class="row">
		<div class="input-field col s12">
			<i class="material-icons prefix">link</i>
			<input value="{!! $extension_instance->redirect_url !!}" id="redirect_url" name="redirect_url" type="text" class="validate">
			<label for="redirect_url">{{ trans('Kryptonite::kryptonite.url_input_hint') }}</label>
		</div>
	</div>
	<div style="margin-top: 25px;" class="col s12">
		<p class="center">
			<label>
				<input class="filled-in" type="checkbox" id="relativeToRoot"
					name="relativeToRoot"
					@if($extension_instance->url_relative_to_server) checked="checked" @endif>
				<span class="grey-text text-darken-3">
					{!! trans('Kryptonite::kryptonite.url_relative_to_server_root_checkbox') !!}
				</span>
			</label>
		</p>
	</div>
</div>
