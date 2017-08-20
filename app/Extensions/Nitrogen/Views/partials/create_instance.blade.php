@extends('layouts/only_empty_body_head')

@section('main')
	<form id="form" class="col s12 row" method="post" action="">
		{{ csrf_field() }}
		<div class="col s12 row">
			<div class="row"></div>
			<div class="row"></div>
			<div class="input-field col s12 l12">
				<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">text_fields</i>
				<input id="title" name="title" type="text">
				<label for="title">{{ trans("Nitrogen::nitrogen.header_title") }}</label>
			</div>
			<div class="col s12">
				<p class="col s6 center">
					<input class="filled-in" type="checkbox" id="hasButton" name="hasButton">
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
							<input id="button_text" name="button_text" type="text">
							<label for="button_text">{{ trans("Nitrogen::nitrogen.button_text") }}</label>
						</div>
						<div class="input-field col s12 l6">
							<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">link</i>
							<input id="button_link" name="button_link" type="text">
							<label for="button_link">{{ trans("Nitrogen::nitrogen.button_link") }}</label>
						</div>
						<div class="input-field col s12 l6">
							<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">invert_colors</i>
							<input id="button_waves_color" name="button_waves_color" type="text">
							<label for="button_waves_color">{{ trans("Nitrogen::nitrogen.button_waves_color") }}</label>
						</div>
						<div class="input-field col s12 l6">
							<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">format_color_fill</i>
							<input id="button_color" name="button_color" type="text">
							<label for="button_color">{{ trans("Nitrogen::nitrogen.button_color") }}</label>
						</div>
						<div class="input-field col s12 l6">
							<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">border_color</i>
							<input id="button_text_color" name="button_text_color" type="text">
							<label for="button_text_color">{{ trans("Nitrogen::nitrogen.button_text_color") }}</label>
						</div>
						<div class="input-field col s12 l6">
							<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">class</i>
							<input id="button_class" name="button_class" type="text">
							<label for="button_class">{{ trans("Nitrogen::nitrogen.button_class") }}</label>
						</div>
					</div>
				</li>
			</ul>
			<div class="col s12">
				<p class="col s6 center">
					<input class="filled-in" type="checkbox" id="assignedToAllPages" name="assignedToAllPages">
					<label for="assignedToAllPages"
						   class="{{ $synthesiscmsMainColor }}-text">{{ trans("Nitrogen::nitrogen.assigned_to_all_pages") }}</label>
				</p>
			</div>
			<style>
				#page-div .caret {
					color: {{ $synthesiscmsMainColor }} !important;
				}

				#page-div .select-dropdown {
					border-bottom-color: {{ $synthesiscmsMainColor }} !important;
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
								@foreach(\App\Models\Content\Page::all() as $page)
									<option class="truncate"
											value="{{ $page->id }}">{{ $page->page_title . " (ID " . $page->id . ")" }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</li>
			</ul>
			<div class="col s12">
				<p class="col s6 center">
					<input class="filled-in" type="checkbox" id="autoplay" name="autoplay">
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
							<input min="500" step="500" type="number" id="interval" name="interval" type="text">
							<label for="interval">{{ trans("Nitrogen::nitrogen.interval") }}</label>
						</div>
					</div>
				</li>
			</ul>
			<div class="col s12">
				<p class="col s6 center">
					<input class="filled-in" type="checkbox" id="buttons" name="buttons">
					<label for="buttons"
						   class="{{ $synthesiscmsMainColor }}-text">{{ trans("Nitrogen::nitrogen.header_buttons") }}</label>
				</p>
			</div>
			<script>
                var buttonCollapsible = false;
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
                    $("#pagesCollapsible").click();
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
		</div>
		<div class="row"></div>
		<a href="{{ url()->previous() }}"
		   class="col s6 center text-center btn-flat waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}">{{ trans('synthesiscms/admin.applet_return') }}</a>
		<button type="submit"
				class="col s6 center text-center btn-flat waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}">{{ trans('synthesiscms/admin.save_applet') }}</button>
	</form>
@endsection