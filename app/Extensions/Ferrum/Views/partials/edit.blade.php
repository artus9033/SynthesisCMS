<div class="col s12 grey-text text-darken-2">{{ trans("Ferrum::messages.show_header") }}</div>
<div class="switch col s12">
	<label>
		{!! trans("Ferrum::ferrum.switch_off") !!}
		<input type="checkbox" name="showHeader" @if($extension_instance->showHeader) checked @endif>
		<span class="lever"></span>
		{!! trans("Ferrum::ferrum.switch_on") !!}
	</label>
</div>
<div class="col s12 row"></div>
<div class="col s12 grey-text text-darken-2">{{ trans("Ferrum::messages.edit_form") }}</div>
@php($formInJson = $extension_instance->formInJson)
@php
	use App\Extensions\Ferrum\FerrumIdManager;
	$ferrumIdManager = new FerrumIdManager();
@endphp
@include('Ferrum::x-editable/x-editable-jqueryui-css')
@include('Ferrum::x-editable/x-editable-jqueryui-min-js')
<script>
    function FerrumVisualEditorFormJsonNode() {
        this.elementType = '';
        this.elementDatabaseFieldName = '';
        this.elementValuesArray = [];
    }

    function initFerrumInlineEditables() {
        $('.ferrum-inline-editable').editable({
            url: '', //this prevents the live-save AJAX functionality
        });
        updateFerrumJsonTree();
    }

    function handleFerrumDraggableElementToJsonNode(element) {
        var returnNode;
        if (element.hasClass('ferrum-label-element')) {
            element.find('.ferrum-inline-editable').each(function () {
                returnNode = new FerrumVisualEditorFormJsonNode;
                returnNode.elementType = 'ferrum-label-element';
                returnNode.elementDatabaseFieldName = '';
                returnNode.elementValuesArray.push($(this).html());
            });
        } else if (element.hasClass('ferrum-label-with-description-element')) {
            returnNode = new FerrumVisualEditorFormJsonNode;
            returnNode.elementType = 'ferrum-label-with-description-element';
            returnNode.elementDatabaseFieldName = '';
            element.find('h5.ferrum-inline-editable').each(function () {
                returnNode.elementValuesArray.push($(this).html());
            });
            element.find('p.ferrum-inline-editable').each(function () {
                returnNode.elementValuesArray.push($(this).html());
            });
        } else if (element.hasClass('ferrum-text-input-with-hint-element')) {
            returnNode = new FerrumVisualEditorFormJsonNode;
            returnNode.elementType = 'ferrum-text-input-with-hint-element';
            element.find('[data-ferrum-tree-role="field-name-editor"]').each(function () {
                returnNode.elementDatabaseFieldName = $(this).val();
            });
            element.find('[data-ferrum-tree-role="label-editor"]').each(function () {
                returnNode.elementValuesArray.push($(this).val());
            });
        } else if (element.hasClass('ferrum-number-input-with-hint-element')) {
            returnNode = new FerrumVisualEditorFormJsonNode;
            returnNode.elementType = 'ferrum-number-input-with-hint-element';
            returnNode.elementDatabaseFieldName = '';
            element.find('[data-ferrum-tree-role="field-name-editor"]').each(function () {
                returnNode.elementDatabaseFieldName = $(this).val();
            });
            element.find('[data-ferrum-tree-role="label-editor"]').each(function () {
                returnNode.elementValuesArray.push($(this).val());
            });
        }
        return returnNode;
    }

    function updateFerrumJsonTree() {
        var json = {};
        var jsonKey = -1;
        $('#ferrum-tree-{!! $ferrumIdManager->ferrumGetCurrentUniqueId() !!} > .ferrum-draggable').each(function () {
            var node = handleFerrumDraggableElementToJsonNode($(this));
            if (node != null) {
                jsonKey++;
                json[jsonKey] = node;
            }
        });
        console.log(json);
        $('#ferrumJsonifiedFormFromEditor').val(JSON.stringify(json));
    }

    //set X-editable mode to inline
    $.fn.editable.defaults.mode = 'inline';

    var ferrumScriptIsDragging = false;

    window.onload = function () {
        initFerrumInlineEditables();
        dragula([document.getElementById('ferrum-items'), document.getElementById('ferrum-tree-{!! $ferrumIdManager->ferrumGetCurrentUniqueId() !!}')], {
            removeOnSpill: true,
            copy: function (el, source) {
                return source === document.getElementById('ferrum-items');
            },
            accepts: function (el, target) {
                return target !== document.getElementById('ferrum-items');
            },
        }).on('drag', function (el) {
            ferrumScriptIsDragging = true;
        }).on('drop', function (el) {
            ferrumScriptIsDragging = false;
            initFerrumInlineEditables();
            updateFerrumJsonTree();
        }).on('remove', function (el, container, source) {
            updateFerrumJsonTree();
        });

        $('#ferrum-tree-{!! $ferrumIdManager->ferrumGetCurrentUniqueId() !!}').change(function () {
            updateFerrumJsonTree();
        });

        $('body').on('DOMNodeInserted', '.editable-container', function () {
            $('.editable-submit').addClass('btn waves-effect waves-light white-text {!! $synthesiscmsMainColor !!} {!! $synthesiscmsMainColorClass !!}');
            $('.editable-cancel').css('display', 'none');
        });
    }
</script>
<style>
	.ferrum-draggable {
		cursor: move; /* fallback if grab cursor is unsupported */
		cursor: grab;
	}

	.ferrum-inline-editable {
		cursor: text;
	}

	.ferrum-editable {
		cursor: text;
	}

	.editable-unsaved {
		font-weight: normal; /* override the bold text added by this class from x-editable */
	}
</style>
<body>
<input style="display: none;" id="ferrumJsonifiedFormFromEditor" name="ferrumJsonifiedFormFromEditor">
<div class="col s12 row" style="height: 500px;"
	 id="ferrumVisualFormEditorContainer">
	<div class="col s7 card-panel container" style="height: 100%; overflow: scroll; overflow-x: hidden;"
		 id="ferrum-tree-{!! $ferrumIdManager->ferrumGetCurrentUniqueId() !!}">
		@if(strlen($formInJson) > 0)
			@php($parsedJson = json_decode($formInJson))
			@foreach($parsedJson as $node)
				@if($node->elementType == "ferrum-label-element")
					@include('Ferrum::items/labelTitle', ['mode' => 'editor-load-item', 'ferrumIdManagerInstance' => $ferrumIdManager, 'itemTitle' => $node->elementValuesArray[0]])
				@endif
				@if($node->elementType == "ferrum-label-with-description-element")
					@include('Ferrum::items/labelWithDescription', ['mode' => 'editor-load-item', 'ferrumIdManagerInstance' => $ferrumIdManager, 'itemTitle' => $node->elementValuesArray[0], 'itemDescription' => $node->elementValuesArray[1]])
				@endif
				@if($node->elementType == "ferrum-text-input-with-hint-element")
					@include('Ferrum::items/textInput', ['mode' => 'editor-load-item', 'ferrumIdManagerInstance' => $ferrumIdManager, 'itemFieldName' => $node->elementDatabaseFieldName, 'itemInputLabel' => $node->elementValuesArray[0]])
				@endif
				@if($node->elementType == "ferrum-number-input-with-hint-element")
					@include('Ferrum::items/numberInput', ['mode' => 'editor-load-item', 'ferrumIdManagerInstance' => $ferrumIdManager, 'itemFieldName' => $node->elementDatabaseFieldName, 'itemInputLabel' => $node->elementValuesArray[0]])
				@endif
			@endforeach
		@endif
	</div>
	<div class="col s5 card-panel container" style="height: 100%; overflow: scroll; overflow-x: hidden;"
		 id="ferrum-items">
		@include('Ferrum::items/labelTitle', ['mode' => 'editor-new-item', 'ferrumIdManagerInstance' => $ferrumIdManager])
		@include('Ferrum::items/labelWithDescription', ['mode' => 'editor-new-item', 'ferrumIdManagerInstance' => $ferrumIdManager])
		@include('Ferrum::items/textInput', ['mode' => 'editor-new-item', 'ferrumIdManagerInstance' => $ferrumIdManager])
		@include('Ferrum::items/numberInput', ['mode' => 'editor-new-item', 'ferrumIdManagerInstance' => $ferrumIdManager])
	</div>
</div>
<div class="input-field col s12">
	<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">send</i>
	<input id="ferrum-submit-button-text-editor" type="text" name="ferrum-submit-button-text-editor"
		   value="{{ $extension_instance->submitButtonText }}">
	<label for="ferrum-submit-button-text-editor">{{ trans('Ferrum::ferrum.label_submit_button_text') }}</label>
</div>
<div class="input-field col s12">
	<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">done</i>
	<input id="applicationConfirmationText" type="text" name="applicationConfirmationText"
		   value="{{ $extension_instance->applicationConfirmationText }}">
	<label for="applicationConfirmationText">{{ trans('Ferrum::ferrum.label_application_confirmation_text') }}</label>
</div>