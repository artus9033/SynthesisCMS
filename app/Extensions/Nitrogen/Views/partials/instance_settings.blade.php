@extends('layouts/only_empty_body_head')

@section('main')
	<div class="col s12 row">
		<form id="form" class="col s12 row" method="post" action="">
			{{ csrf_field() }}
			<div class="row"></div>
			<p class="center text-center"
			   style="margin-bottom: 10px;">{{ trans('Nitrogen::nitrogen.applet_enable_header') }}</p>
			<div class="switch center">
				<label>
					{{ trans('Nitrogen::nitrogen.disable') }}
					<input type="checkbox" name="enabled" id="enabled" @if($model->enabled) checked @endif>
					<span class="lever"></span>
					{{ trans('Nitrogen::nitrogen.enable') }}
				</label>
			</div>
			<div class="input-field col s12 l12">
				<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">text_fields</i>
				<input id="title" name="title" type="text" value="{{ $model->title }}">
				<label for="title">{{ trans("Nitrogen::nitrogen.header_title") }}</label>
			</div>
			<div class="row"></div>
			@php
				$ct = 0;
			@endphp
			<div class="col s12">
				<p class="col s6 center">
					<input class="filled-in" type="checkbox" id="hasButton" name="hasButton"
						   @if($model->hasButton) checked="checked" @endif>
					<label for="hasButton"
						   class="{{ $synthesiscmsMainColor }}-text">{{ trans("Nitrogen::nitrogen.header_hasButton") }}</label>
				</p>
			</div>
			<ul class="collapsible popout col s12 row" data-collapsible="accordion">
				<li>
					<div class="collapsible-header {{ $synthesiscmsMainColor }}-text" id="buttonCollapsible"
						 style="pointer-events: none;"><i
								class="material-icons {{ $synthesiscmsMainColor }}-text center">radio_button_checked</i>{{ trans("Nitrogen::nitrogen.item_hasButton") }}
					</div>
					<div class="collapsible-body col s12 card-panel z-depth-3">
						<div class="input-field col s12 l6">
							<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">text_fields</i>
							<input id="button_text" name="button_text" type="text" value="{{ $model->buttonText }}">
							<label for="button_text">{{ trans("Nitrogen::nitrogen.button_text") }}</label>
						</div>
						<div class="input-field col s12 l6">
							<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">link</i>
							<input id="button_link" name="button_link" type="text" value="{{ $model->buttonLink }}">
							<label for="button_link">{{ trans("Nitrogen::nitrogen.button_link") }}</label>
						</div>
						<div class="input-field col s12 l6">
							<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">invert_colors</i>
							<input id="button_waves_color" name="button_waves_color" type="text"
								   value="{{ $model->buttonWavesColor }}">
							<label for="button_waves_color">{{ trans("Nitrogen::nitrogen.button_waves_color") }}</label>
						</div>
						<div class="input-field col s12 l6">
							<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">format_color_fill</i>
							<input id="button_color" name="button_color" type="text" value="{{ $model->buttonColor }}">
							<label for="button_color">{{ trans("Nitrogen::nitrogen.button_color") }}</label>
						</div>
						<div class="input-field col s12 l6">
							<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">border_color</i>
							<input id="button_text_color" name="button_text_color" type="text"
								   value="{{ $model->buttonTextColor }}">
							<label for="button_text_color">{{ trans("Nitrogen::nitrogen.button_text_color") }}</label>
						</div>
						<div class="input-field col s12 l6">
							<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">class</i>
							<input id="button_class" name="button_class" type="text" value="{{ $model->buttonClass }}">
							<label for="button_class">{{ trans("Nitrogen::nitrogen.button_class") }}</label>
						</div>
					</div>
				</li>
			</ul>
			<div class="col s12">
				<p class="col s6 center">
					<input class="filled-in" type="checkbox" id="assignedToAllPages" name="assignedToAllPages"
						   @if($model->assignedToAllPages) checked="checked" @endif>
					<label for="assignedToAllPages"
						   class="{{ $synthesiscmsMainColor }}-text">{{ trans("Nitrogen::nitrogen.assigned_to_all_pages") }}</label>
				</p>
			</div>
			<style>
				#page-div .caret {
					color: {{ $synthesiscmsMainColor }}    !important;
				}

				#page-div .select-dropdown {
					border-bottom-color: {{ $synthesiscmsMainColor }}    !important;
				}

				#page-div .select-wrapper {
					margin-top: 5px !important;
				}

				label {
					text-align: left !important;
				}
			</style>
			<ul class="collapsible popout col s12 row" data-collapsible="accordion">
				<li>
					<div class="collapsible-header {{ $synthesiscmsMainColor }}-text" id="pagesCollapsible"
						 style="pointer-events: none;"><i
								class="material-icons {{ $synthesiscmsMainColor }}-text center">done_all</i>{{ trans("Nitrogen::nitrogen.assigned_pages") }}
					</div>
					<div class="collapsible-body col s12 card-panel z-depth-3">
						<div class="input-field col s12" id="page-div">
							<select multiple name="assigned_pages[]">
								<option value="" disabled
										selected>{{ trans("Nitrogen::nitrogen.choose_pages") }}</option>
								@php
									$pages_assigned = $model->assignedPages;
									$pages_assigned_array = explode(";", $pages_assigned);
								@endphp
								@foreach(\App\Models\Content\Page::all() as $page)
									<option class="truncate" value="{{ $page->id }}"
											@if(in_array($page->id, $pages_assigned_array)) selected @endif>{{ $page->page_title . " (ID " . $page->id . ")" }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</li>
			</ul>
			<div class="col s12">
				<p class="col s6 center">
					<input class="filled-in" type="checkbox" id="autoplay" name="autoplay"
						   @if($model->autoplay) checked="checked" @endif>
					<label for="autoplay"
						   class="{{ $synthesiscmsMainColor }}-text">{{ trans("Nitrogen::nitrogen.header_autoplay") }}</label>
				</p>
			</div>
			<ul class="collapsible popout col s12 row" data-collapsible="accordion">
				<li>
					<div class="collapsible-header {{ $synthesiscmsMainColor }}-text" id="autoplayCollapsible"
						 style="pointer-events: none;"><i
								class="material-icons {{ $synthesiscmsMainColor }}-text center">fast_forward</i>{{ trans("Nitrogen::nitrogen.item_autoplay") }}
					</div>
					<div class="collapsible-body col s12 card-panel z-depth-3">
						<div class="input-field col s12 l6">
							<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">timelapse</i>
							<input min="500" step="500" type="number" id="interval" name="interval" type="text"
								   value="{{ $model->interval }}">
							<label for="interval">{{ trans("Nitrogen::nitrogen.interval") }}</label>
						</div>
					</div>
				</li>
			</ul>
			<div class="col s12">
				<p class="col s6 center">
					<input class="filled-in" type="checkbox" id="buttons" name="buttons"
						   @if($model->buttons) checked="checked" @endif>
					<label for="buttons"
						   class="{{ $synthesiscmsMainColor }}-text">{{ trans("Nitrogen::nitrogen.header_buttons") }}</label>
				</p>
			</div>
			<script>
                var buttonCollapsible = false;
                $(document).ready(function () {
                    if ({!! json_encode($model->hasButton) !!}) {
                        buttonCollapsible = true;
                        $("#buttonCollapsible").click();
                        buttonCollapsible = false;
                    }
                });
                $("#hasButton").click(function () {
                    buttonCollapsible = true;
                    $("#buttonCollapsible").click();
                    buttonCollapsible = false;
                });
                $("#buttonCollapsible").click(function (event) {
                    if (!buttonCollapsible) {
                        event.preventDefault();
                    }
                });
                var pagesCollapsible = false;
                $(document).ready(function () {
                    if (!{!! json_encode($model->assignedToAllPages) !!}) {
                        pagesCollapsible = true;
                        $("#pagesCollapsible").click();
                        pagesCollapsible = false;
                    }
                });
                $("#assignedToAllPages").click(function () {
                    pagesCollapsible = true;
                    $("#pagesCollapsible").click();
                    pagesCollapsible = false;
                });
                $("#pagesCollapsible").click(function (event) {
                    if (!pagesCollapsible) {
                        event.preventDefault();
                    }
                });
                var autoplayCollapsible = false;
                $(document).ready(function () {
                    if ({!! json_encode($model->autoplay) !!}) {
                        autoplayCollapsible = true;
                        $("#autoplayCollapsible").click();
                        autoplayCollapsible = false;
                    }
                });
                $("#autoplay").click(function () {
                    autoplayCollapsible = true;
                    $("#autoplayCollapsible").click();
                    autoplayCollapsible = false;
                });
                $("#autoplayCollapsible").click(function (event) {
                    if (!autoplayCollapsible) {
                        event.preventDefault();
                    }
                });
			</script>
			<div class="row"></div>
			<a href="{{ url()->current() }}/create"
			   class="waves-effect waves-light btn-large btn-floating {{ $synthesiscmsMainColor }} white-text {{ $synthesiscmsMainColorClass }}"
			   style="position: absolute; right: 40px;">
				<i class="material-icons">add</i>
			</a>
			<table class="col s12 highlight centered">
				<thead>
				<tr>
					<td class="center"><i
								class="material-icons {{ $synthesiscmsMainColor }}-text center">delete_sweep</i></td>
					<td class="center"><p class="center">{{ trans('Nitrogen::nitrogen.header_id') }}</p></td>
					<td class="center"><p class="center">{{ trans('Nitrogen::nitrogen.header_title') }}</p></td>
					<td class="center"><p class="center">{{ trans('Nitrogen::nitrogen.edit') }}</p></td>
					<td class="center"><p class="center">{{ trans('Nitrogen::nitrogen.delete') }}</p></td>
					<td class="center"><p class="center">{{ trans('Nitrogen::nitrogen.order') }}</p></td>
				</tr>
				</thead>
				<tbody>
				@php
					use App\Extensions\Nitrogen\Models\NitrogenItem;
					$items_raw = NitrogenItem::where(['slider' => $model->id, 'parentInstance' => $nr]);
					$items_count = $items_raw->count();
					$array = array();
					$posctr = 0;
					for($id = 0; $posctr < $items_count; $posctr++){
					$itm = NitrogenItem::where(['slider' => $model->id, 'before' => $id, 'parentInstance' => $nr])->first();
					array_push($array, $itm);
					$id = $itm->id;
					}
					$items = collect($array);
					$mainctr = 0;
					function printItemWorker($item, $ct, $items_count, $model, $first, $last){
					return view()->make('Nitrogen::partials.instance_item')->with(['item' => $item, 'ct' => $ct, 'items_count' => $items_count, 'model' => $model, 'first' => $first, 'last' => $last]);
					}
					function printItem($item, $ct, $items_count, $model, &$mainctr){
					$out = "";
					$mainctr++;
					$out .= printItemWorker($item, $ct, $items_count, $model, $mainctr == 1, $mainctr == $items_count);
					echo $out;
					}
				@endphp
				@foreach ($items as $key => $item)
					@php
						$ct++;
						echo printItem($item, $ct, $items_count, $model, $mainctr);
					@endphp
				@endforeach
				@if($ct == 0)
					<tr>
						<td colspan="8">
							<div class="col s12 center text-center"><h5>{{ trans("Nitrogen::nitrogen.empty") }}</h5>
							</div>
						</td>
					</tr>
				@endif
				</tbody>
			</table>
			<a href="{{ url()->previous() }}"
			   class="col s6 center text-center btn-flat waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}">{{ trans('synthesiscms/admin.applet_return') }}</a>
			<button onclick="$('form').submit()"
					class="col s12 center text-center btn-flat waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}">{{ trans('synthesiscms/admin.save_applet') }}</button>
		</form>
	</div>
@endsection