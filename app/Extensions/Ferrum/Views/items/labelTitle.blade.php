@if($mode == 'editor-new-item')
	<div class="card-panel ferrum-draggable ferrum-label-element col s12 row ferrum-tooltipped"
		 data-tooltip="{{ trans('Ferrum::items.item_label_name') }}" data-position="left">
		<h5 class="ferrum-inline-editable">{{ trans('Ferrum::items.item_label_title') }}</h5>
	</div>
	<script>
        $('.ferrum-tooltipped').tooltip();
	</script>
@elseif($mode == 'editor-load-item')
	<div class="card-panel ferrum-draggable ferrum-label-element col s12 row">
		<h5 class="ferrum-inline-editable">{{ $itemTitle }}</h5>
	</div>
@else
	<div class="card-panel ferrum-draggable ferrum-label-element col s12 row">
		<h5>{{ $itemTitle }}</h5>
	</div>
@endif