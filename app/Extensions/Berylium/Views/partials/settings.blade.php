<div class="col s12 row">
	<div class="row"></div>
	<p class="center text-center" style="margin-bottom: 10px;">{{ trans('berylium::berylium.applet_enable_header') }}</p>
	<div class="switch center">
    <label>
      {{ trans('berylium::berylium.disable') }}
      <input type="checkbox" name="enabled" id="enabled" @if($model->enabled) checked @endif>
      <span class="lever"></span>
      {{ trans('berylium::berylium.enable') }}
    </label>
  </div>
</div>
