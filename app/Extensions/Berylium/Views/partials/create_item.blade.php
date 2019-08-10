@extends('layouts/only_empty_body_head')

@section('head')
	<style>
		#articleCategory-div .caret {
			color: {{ $synthesiscmsMainColor }} !important;
		}

		#articleCategory-div .select-dropdown {
			border-bottom-color: {{ $synthesiscmsMainColor }} !important;
		}

		label {
			text-align: left !important;
		}
	</style>
@endsection

@section('main')
	<div class="col s12 z-depth-1 lighten-4 row card"
		 style="display: inline-block; padding: 0px 48px 0px 48px; border: 1px solid #EEE;">
		<div class="card-content">
			<div class="card-title col s12">
				<h3 class="{{ $synthesiscmsMainColor }}-text valign-wrapper center"><i
							class="material-icons prefix {{ $synthesiscmsMainColor }}-text medium valign">settings</i>&nbsp;{{ trans('synthesiscms/admin.applet_settings', ['applet' => $kernel->getExtensionName()]) }}
				</h3>
			</div>
			<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12"></div>
			<form id="form" class="col s12 row" method="post" action="">
				{{ csrf_field() }}
				<div class="input-field col s6">
					<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">title</i>
					<input name="title" id="title" type="text">
					<label for="title">{{ trans("Berylium::berylium.item_title") }}</label>
				</div>
				<div class="input-field col s6 applet-source-input" id="applet-link">
					<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">link</i>
					<input name="link" id="link" type="text">
					<label for="link">{{ trans("Berylium::berylium.item_link") }}</label>
				</div>
				<div class="input-field col s6 applet-source-input" id="applet-page" style="display: none;">
					<a onclick="$('#berylium-modal-choose-page').modal('open');"
					   class="waves-effect waves-light {{ $synthesiscmsMainColorClass }} btn-large">
						<i class="material-icons white-text left">pages</i>
						{{ trans("Berylium::berylium.item_page") }}
					</a>
					<input name="page" id="page" type="text" hidden="hidden">
					<div id="berylium-modal-choose-page" class="modal modal-fixed-footer">
						<div class="modal-content" style="::-webkit-scrollbar { display: none; }">
							<h4>{{ trans("Berylium::berylium.item_page") }}</h4>
							<p>{{ trans("Berylium::berylium.item_page_choose_help") }}</p>
							<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12"></div>
							<style>
								.selected-berylium {
									text-color: white;
									background-color: teal;
								}

								.selectable-berylium {
									cursor: pointer;
								}
							</style>
							<script>
                                var berylium_selected_page_buffer;
                                function beryliumSelectPage(id, ref) {
                                    berylium_selected_page_buffer = id;
                                    $('.selected-berylium').removeClass('selected-berylium');
                                    $(ref).addClass('selected-berylium');
                                }
							</script>
							@php
								$synthesiscmsExtensions = view()->shared("synthesiscmsExtensions");
								$routes_data = Array();
								foreach ($synthesiscmsExtensions as $extensionPack) {
									$kernel = $extensionPack[0];
									foreach($kernel->getRoutesAndSubroutes() as $routes_packed){
										if(!empty($routes_packed)){
											foreach($routes_packed as $routes_unpacked){
												if(!empty($routes_unpacked)){
													array_push($routes_data, $routes_unpacked);
												}
											}
										}
									}
								}
							@endphp
							@foreach($routes_data as $route_pack)
								@if(!empty($route_pack))
									@php
										list($title, $id, $extension) = $route_pack;
										$extension = '(ID ' . $id . ') ' . $extension;
									@endphp
									<div class="col s6 l4 tooltipped" data-position="top" data-delay="50"
										 data-tooltip="{!! $extension !!}"
										 onclick="beryliumSelectPage('{!! $id !!}', this)">
										<div style="width: 100%;"
											 class='card-panel hoverable white waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColor }}-text selectable-berylium'>
											{!! $title !!}
										</div>
									</div>
								@endif
							@endforeach
						</div>
						<div class="modal-footer">
							<a onclick="$('#page').attr('value', berylium_selected_page_buffer);"
							   class="modal-action modal-close waves-effect waves-green btn-flat">{{ trans("Berylium::berylium.page_modal_button_choose") }}</a>
							<a class="modal-action modal-close waves-effect waves-red btn-flat">{{ trans("Berylium::berylium.page_modal_button_cancel") }}</a>
						</div>
					</div>
					<script>
                        $(document).ready(function () {
                            $('.modal').modal({dismissible: false});
                        });
					</script>
				</div>
				<div class="input-field col s6 applet-source-input" id="applet-placeholder"
					 style="display: none;"></div>
				<div class="input-field col s12 {{ $synthesiscmsMainColor }}-text" id="articleCategory-div">
					<select id="category" name="category">
						@php
							$categoryClass = new \ReflectionClass('App\\Extensions\\Berylium\\BeryliumItemCategory');
							$categoryClassConstants = $categoryClass->getConstants();
						@endphp
						@foreach ($categoryClassConstants as $key => $cat)
							<option value="{{ $cat }}">{{ trans("Berylium::berylium.category_" . $cat) }}</option>
						@endforeach
					</select>
					<label>{{ trans("Berylium::berylium.item_category") }}</label>
				</div>
				<div class="input-field col s12 {{ $synthesiscmsMainColor }}-text" id="articleCategory-div">
					<select id="type" name="type">
						@php
							$typeClass = new \ReflectionClass('App\\Extensions\\Berylium\\BeryliumItemType');
							$typeClassConstants = $typeClass->getConstants();
						@endphp
						@foreach ($typeClassConstants as $key => $type)
							<option value="{{ $type }}">{{ trans("Berylium::berylium.type_" . $type) }}</option>
						@endforeach
					</select>
					<label>{{ trans("Berylium::berylium.item_type") }}</label>
				</div>
				<div class="input-field col s12 {{ $synthesiscmsMainColor }}-text" id="articleCategory-div">
					<select id="parent" name="parent">
						<option value="{{ $model->id }};0">{{ trans("Berylium::berylium.option_default_parent") }}</option>
						@foreach (App\Extensions\Berylium\Models\BeryliumItem::where('menu', $model->id)->get() as $key => $item)
							<option class="truncate" value="{{ $item->parentOf }};{{ $item->id }}">{{ $item->title }}</option>
						@endforeach
					</select>
					<label>{{ trans("Berylium::berylium.parent") }}</label>
				</div>
		</div>
		<script>
            $('#type').on('change', function () {
                if (this.value == 1) {
                    $('.applet-source-input').css("display", "none");
                    $('#applet-link').fadeIn();
                } else if (this.value == 2) {
                    $('.applet-source-input').css("display", "none");
                    $('#applet-page').fadeIn();
                } else if (this.value == 3) {
                    $('.applet-source-input').css("display", "none");
                    $('#applet-placeholder').fadeIn();
                }
            });
		</script>
		<a href="{{ url()->previous() }}"
		   class="col s6 center text-center btn-flat waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}">{{ trans('synthesiscms/admin.applet_return') }}</a>
		<button type="submit"
				class="col s6 center text-center btn-flat waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}">{{ trans('synthesiscms/admin.save_applet') }}</button>
		<div class="row"></div>
		</form>
	</div>
@endsection
