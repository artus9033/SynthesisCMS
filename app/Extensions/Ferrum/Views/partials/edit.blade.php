<div class="col s12 grey-text text-darken-2">{{ trans("Ferrum::messages.show_header") }}</div>
<div class="switch col s12 row">
	<label>
		{!! trans("Ferrum::ferrum.switch_off") !!}
		<input type="checkbox" name="showHeader" @if($extension_instance->showHeader) checked @endif>
		<span class="lever"></span>
		{!! trans("Ferrum::ferrum.switch_on") !!}
	</label>
</div>
@php
	$applicationsCount = (strlen($extension_instance->applicationsInJson) > 0) ? count(json_decode($extension_instance->applicationsInJson)) : 0;
@endphp
<div class="card-panel col s12 center row">
	<h5 class="center">{{ trans('Ferrum::ferrum.label_applications_submitted_count', ['count' => $applicationsCount]) }}</h5>
</div>
<div class="col s12 l4 offset-l2 center row">
	<a id="ferrum-download-csv-button" class="col s12 btn-large {{ $synthesiscmsMainColor }} waves-effect waves-light"
	   href="{{ url($page->slug . '/download-csv') }}" target="_blank"
	   class="btn-large {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} waves-effect waves-light hoverable tooltipped"
	   data-tooltip="{{ trans('Ferrum::ferrum.btn_download_applications_csv_full') }}" data-position="top"
	   data-delay="50">
		<i class="material-icons white-text left"
		   style="line-height: unset !important; font-size: 1.8rem;">file_download</i>{{ trans('Ferrum::ferrum.btn_download_applications_csv_short') }}
	</a>
</div>
<div class="col s12 l4 center row">
	<a id="ferrum-download-pdf-button" class="col s12 btn-large {{ $synthesiscmsMainColor }} waves-effect waves-light"
	   href="{{ url($page->slug . '/download-pdf') }}" target="_blank"
	   class="btn-large {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} waves-effect waves-light hoverable tooltipped"
	   data-tooltip="{{ trans('Ferrum::ferrum.btn_download_applications_pdf_full') }}" data-position="top"
	   data-delay="50">
		<i class="material-icons white-text left"
		   style="line-height: unset !important; font-size: 1.8rem;">picture_as_pdf</i>{{ trans('Ferrum::ferrum.btn_download_applications_pdf_short') }}
	</a>
</div>
<div class="col s12 row"></div>
<div class="col s12 grey-text text-darken-2">{{ trans("Ferrum::messages.edit_form") }}</div>
@php($formInJson = $extension_instance->formInJson)
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
        $('#ferrum-download-csv-button').tooltip();
        $('#ferrum-download-pdf-button').tooltip();
        $('#applicationsCloseDate').datepicker({
            selectMonths: true,
            selectYears: 100,
            today: "{{ trans('Ferrum::ferrum.btn_date_picker_today') }}",
            i18n: {
                clear: "",
                done: "{{ trans('Ferrum::ferrum.btn_date_picker_ok') }}"
            },
            closeOnSelect: false,
        });

        $('#applicationsCloseTime').pickatime({
            defaultTime: 'now',
            fromNow: 0,
            twelveHour: false,
            i18n: {
                done: "{{ trans('Ferrum::ferrum.btn_time_picker_ok') }}",
                clear: "",
                cancel: "{{ trans('Ferrum::ferrum.btn_time_picker_cancel') }}",
            },
            autoClose: false
        });

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
<div class="col s12 row divider {{ $synthesiscmsMainColor }}"></div>
@php($dateFormatted = new DateTime(\Carbon\Carbon::parse($extension_instance->applicationsCloseDateTime)->toDateString()))
<div class="input-field col s12">
	<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">today</i>
	<input class="datepicker" id="applicationsCloseDate" type="text" name="applicationsCloseDate"
		   value="{{ $dateFormatted->format('d F, Y') }}">
	<label for="applicationsCloseDate">{{ trans('Ferrum::ferrum.label_applications_close_date') }}</label>
</div>
<div class="input-field col s12">
	<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">access_time</i>
	<input class="timepicker" id="applicationsCloseTime" type="text" name="applicationsCloseTime"
		   value="{{ \Carbon\Carbon::parse($extension_instance->applicationsCloseDateTime)->toTimeString() }}">
	<label for="applicationsCloseTime">{{ trans('Ferrum::ferrum.label_applications_close_time') }}</label>
</div>
<div class="col s12 row divider {{ $synthesiscmsMainColor }}"></div>
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
<div class="input-field col s12">
	<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text">event_busy</i>
	<input id="applicationsClosedText" type="text" name="applicationsClosedText"
		   value="{{ $extension_instance->applicationsClosedText }}">
	<label for="applicationsClosedText">{{ trans('Ferrum::ferrum.label_applications_closed_text') }}</label>
</div>
