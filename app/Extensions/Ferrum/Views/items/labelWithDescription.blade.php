@if($mode == 'editor-new-item')
	<div class="card ferrum-draggable ferrum-label-with-description-element col s12 row ferrum-tooltipped"
		 data-tooltip="{{ trans('Ferrum::items.item_label_with_description_name') }}" data-delay="50"
		 data-position="left">
		<div class="card-content">
			<div class="card-title col s12 no-padding">
				<h5 class="{{ $synthesiscmsMainColor }}-text valign-wrapper ferrum-inline-editable">
					{{ trans('Ferrum::items.item_label_with_description_title') }}
				</h5>
			</div>
			<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12 row"></div>
			<p class="ferrum-inline-editable">{{ trans('Ferrum::items.item_label_with_description_description') }}</p>
		</div>
	</div>
	<script>
        $('.ferrum-tooltipped').tooltip();
	</script>
@elseif($mode == 'editor-load-item')
	<div class="card ferrum-draggable ferrum-label-with-description-element col s12 row">
		<div class="card-content">
			<div class="card-title col s12 no-padding">
				<h5 class="{{ $synthesiscmsMainColor }}-text valign-wrapper ferrum-inline-editable">
					{{ $itemTitle }}
				</h5>
			</div>
			<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12 row"></div>
			<p class="ferrum-inline-editable">{{ $itemDescription }}</p>
		</div>
	</div>
@else
	<div class="card ferrum-draggable ferrum-label-with-description-element col s12 row">
		<div class="card-content">
			<div class="card-title col s12 no-padding">
				<h5 class="{{ $synthesiscmsMainColor }}-text valign-wrapper">
					{{ $itemTitle }}
				</h5>
			</div>
			<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12 row"></div>
			<p>{{ $itemDescription }}</p>
		</div>
	</div>
@endif