<style>
	/*! X-editable - v1.5.0
* In-place editing with Twitter Bootstrap, jQuery UI or pure jQuery
* http://github.com/vitalets/x-editable
* Copyright (c) 2013 Vitaliy Potapov; Licensed MIT */
	.editableform {
		margin-bottom: 0; /* overwrites bootstrap margin */
	}

	.editableform .control-group {
		margin-bottom: 0; /* overwrites bootstrap margin */
		white-space: nowrap; /* prevent wrapping buttons on new line */
		line-height: 20px; /* overwriting bootstrap line-height. See #133 */
	}

	.editable-buttons {
		display: inline-block; /* should be inline to take effect of parent's white-space: nowrap */
		vertical-align: top;
		margin-left: 7px;
		/* inline-block emulation for IE7*/
		zoom: 1;
		*display: inline;
	}

	.editable-buttons.editable-buttons-bottom {
		display: block;
		margin-top: 7px;
		margin-left: 0;
	}

	.editable-input {
		vertical-align: top;
		display: inline-block; /* should be inline to take effect of parent's white-space: nowrap */
		width: auto; /* bootstrap-responsive has width: 100% that breakes layout */
		white-space: normal; /* reset white-space decalred in parent*/
		/* display-inline emulation for IE7*/
		zoom: 1;
		*display: inline;
	}

	.editable-buttons .editable-cancel {
		margin-left: 7px;
	}

	/*for jquery-ui buttons need set height to look more pretty*/
	.editable-buttons button.ui-button-icon-only {
		height: 24px;
		width: 30px;
	}

	.editableform-loading {
		height: 25px;
		width: auto;
		min-width: 25px;
	}

	.editable-inline .editableform-loading {
		background-position: left 5px;
	}

	.editable-error-block {
		max-width: 300px;
		margin: 5px 0 0 0;
		width: auto;
		white-space: normal;
	}

	/*add padding for jquery ui*/
	.editable-error-block.ui-state-error {
		padding: 3px;
	}

	.editable-error {
		color: red;
	}

	/* ---- For specific types ---- */

	.editableform .editable-date {
		padding: 0;
		margin: 0;
		float: left;
	}

	/* move datepicker icon to center of add-on button. See https://github.com/vitalets/x-editable/issues/183 */
	.editable-inline .add-on .icon-th {
		margin-top: 3px;
		margin-left: 1px;
	}

	/* checklist vertical alignment */
	.editable-checklist label input[type="checkbox"],
	.editable-checklist label span {
		vertical-align: middle;
		margin: 0;
	}

	.editable-checklist label {
		white-space: nowrap;
	}

	/* set exact width of textarea to fit buttons toolbar */
	.editable-wysihtml5 {
		width: 566px;
		height: 250px;
	}

	/* clear button shown as link in date inputs */
	.editable-clear {
		clear: both;
		font-size: 0.9em;
		text-decoration: none;
		text-align: right;
	}

	/* IOS-style clear button for text inputs */
	.editable-clear-x {
		display: block;
		width: 13px;
		height: 13px;
		position: absolute;
		opacity: 0.6;
		z-index: 100;

		top: 50%;
		right: 6px;
		margin-top: -6px;

	}

	.editable-clear-x:hover {
		opacity: 1;
	}

	.editable-pre-wrapped {
		white-space: pre-wrap;
	}

	.editable-container.editable-popup {
		max-width: none !important; /* without this rule poshytip/tooltip does not stretch */
	}

	.editable-container.popover {
		width: auto; /* without this rule popover does not stretch */
	}

	.editable-container.editable-inline {
		display: inline-block;
		vertical-align: middle;
		width: auto;
		/* inline-block emulation for IE7*/
		zoom: 1;
		*display: inline;
	}

	.editable-container.ui-widget {
		font-size: inherit; /* jqueryui widget font 1.1em too big, overwrite it */
		z-index: 9990; /* should be less than select2 dropdown z-index to close dropdown first when click */
	}

	.editable-click,
	a.editable-click,
	a.editable-click:hover {
		text-decoration: none;
		border-bottom: dashed 1px #0088cc;
	}

	.editable-click.editable-disabled,
	a.editable-click.editable-disabled,
	a.editable-click.editable-disabled:hover {
		color: #585858;
		cursor: default;
		border-bottom: none;
	}

	.editable-empty, .editable-empty:hover, .editable-empty:focus {
		font-style: italic;
		color: #DD1144;
		/* border-bottom: none; */
		text-decoration: none;
	}

	.editable-unsaved {
		font-weight: bold;
	}

	.editable-unsaved:after {
		/*    content: '*'*/
	}

	.editable-bg-transition {
		-webkit-transition: background-color 1400ms ease-out;
		-moz-transition: background-color 1400ms ease-out;
		-o-transition: background-color 1400ms ease-out;
		-ms-transition: background-color 1400ms ease-out;
		transition: background-color 1400ms ease-out;
	}

	/*see https://github.com/vitalets/x-editable/issues/139 */
	.form-horizontal .editable {
		padding-top: 5px;
		display: inline-block;
	}

</style>