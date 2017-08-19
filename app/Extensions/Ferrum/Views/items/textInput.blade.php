@php($ferrumIdManagerInstance->ferrumGenerateNextUniqueId())
@if($mode == 'editor-new-item')
	<div class="card-panel col s12 ferrum-draggable ferrum-text-input-with-hint-element row ferrum-tooltipped"
		 data-tooltip="{{ trans('Ferrum::items.item_text_input_with_label_name') }}" data-delay="50"
		 data-position="left">
		<div class="input-field col s12">
			<input data-ferrum-tree-role="field-name-editor" class="ferrum-editable"
				   id="ferrum-input-{{ $ferrumIdManagerInstance->ferrumGetCurrentUniqueId() }}-field-name-editor"
				   type="text" value="{{ trans('Ferrum::items.field_name') }}">
			<label for="ferrum-input-{{ $ferrumIdManagerInstance->ferrumGetCurrentUniqueId() }}-field-name-editor"
				   class="ferrum-editable">{{ trans('Ferrum::items.field_name') }}</label>
		</div>
		@php($ferrumIdManagerInstance->ferrumGenerateNextUniqueId())
		<div class="input-field col s12">
			<input data-ferrum-tree-role="label-editor" class="ferrum-editable"
				   id="ferrum-input-{{ $ferrumIdManagerInstance->ferrumGetCurrentUniqueId() }}-label-editor"
				   type="text">
			<label for="ferrum-input-{{ $ferrumIdManagerInstance->ferrumGetCurrentUniqueId() }}-label-editor"
				   class="ferrum-editable">{{ trans('Ferrum::items.item_text_input_with_label_editor_hint') }}</label>
		</div>
		@php($ferrumIdManagerInstance->ferrumGenerateNextUniqueId())
		<div class="input-field col s12">
			<input id="ferrum-input-{{ $ferrumIdManagerInstance->ferrumGetCurrentUniqueId() }}" type="text"
				   name="ferrum-input-{{ $ferrumIdManagerInstance->ferrumGetCurrentUniqueId() }}"
				   value="{{ trans('Ferrum::items.item_text_input_with_label') }}" disabled>
		</div>
	</div>
	<script>
        $('.ferrum-tooltipped').tooltip();
	</script>
@elseif($mode == 'editor-load-item')
	<div class="card-panel col s12 ferrum-draggable ferrum-text-input-with-hint-element row">
		<div class="input-field col s12">
			<input data-ferrum-tree-role="field-name-editor" class="ferrum-editable"
				   id="ferrum-input-{{ $ferrumIdManagerInstance->ferrumGetCurrentUniqueId() }}-field-name-editor"
				   type="text" value="{{ $itemFieldName }}">
			<label for="ferrum-input-{{ $ferrumIdManagerInstance->ferrumGetCurrentUniqueId() }}-field-name-editor"
				   class="ferrum-editable">{{ trans('Ferrum::items.field_name') }}</label>
		</div>
		@php($ferrumIdManagerInstance->ferrumGenerateNextUniqueId())
		<div class="input-field col s12">
			<input data-ferrum-tree-role="label-editor" class="ferrum-editable"
				   id="ferrum-input-{{ $ferrumIdManagerInstance->ferrumGetCurrentUniqueId() }}-label-editor"
				   type="text" value="{{ $itemInputLabel }}">
			<label for="ferrum-input-{{ $ferrumIdManagerInstance->ferrumGetCurrentUniqueId() }}-label-editor"
				   class="ferrum-editable">{{ trans('Ferrum::items.item_text_input_with_label_editor_hint') }}</label>
		</div>
		@php($ferrumIdManagerInstance->ferrumGenerateNextUniqueId())
		<div class="input-field col s12">
			<input id="ferrum-input-{{ $ferrumIdManagerInstance->ferrumGetCurrentUniqueId() }}" type="text"
				   name="ferrum-input-{{ $ferrumIdManagerInstance->ferrumGetCurrentUniqueId() }}"
				   value="{{ trans('Ferrum::items.item_text_input_with_label') }}" disabled>
		</div>
	</div>
@else
	<div class="card-panel col s12 ferrum-draggable ferrum-text-input-with-hint-element row">
		<div class="input-field col s12">
			<input class="ferrum-editable" id="ferrum-input-{{ $ferrumIdManagerInstance->ferrumGetCurrentUniqueId() }}"
				   type="text"
				   name="ferrum-input-{{ $ferrumIdManagerInstance->ferrumGetCurrentUniqueId() }}" required>
			<label for="ferrum-input-{{ $ferrumIdManagerInstance->ferrumGetCurrentUniqueId() }}"
				   class="ferrum-editable">{{ $itemInputLabel }}</label>
		</div>
	</div>
@endif