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
</div>
