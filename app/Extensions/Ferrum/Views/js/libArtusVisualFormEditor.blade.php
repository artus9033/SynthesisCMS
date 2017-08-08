<script>
    var FerrumVisualEditorFormJsonObject = {};

    class FerrumVisualFormEditor {

        constructor(jsonifiedForm) {
            this.mode = {!! json_encode($mode) !!};
            this.jsonifiedForm = jsonifiedForm;
            this.mainContainerElement = document.getElementById('ferrumVisualFormEditorContainer');
            this.visualTreeContainerElement = document.getElementById("ferrumFormEditorVisualTreeContainer");
            this.ferrumFormEditorDraggableElementsContainerElement = document.getElementById("ferrumFormEditorDraggableElementsContainer");
            try {
                this.structure = this.jsonifiedForm.length ? JSON.parse(this.jsonifiedForm) : FerrumVisualEditorFormJsonObject;
            } catch (e) {
                Materialize.toast('During loading of JSONified form from database an error occured: `' + e.toString() + '`. Reseting the form structure to an empty model to avoid future problems.', 6000);
            }
        }

        renderFormForUser() {

        }

        renderEditor() {
            var html = '';
            for (var node in this.jsonifiedForm) {
                html += attributename + ": " + myobject[attributename];
            }
            $(this.visualTreeContainerElement).html(html);
        }

        snapFormFromVisualToJson() {

        }
    }

    window.onload = function () {
        dragula([document.getElementById('items'), document.getElementById('tree')], {
            removeOnSpill: true,
            copy: function (el, source) {
                return source === document.getElementById('items');
            },
            accepts: function (el, target) {
                return target !== document.getElementById('items');
            },
        });
    }
</script>
<style>
	.ferrum-draggable {
		cursor: move; /* fallback if grab cursor is unsupported */
		cursor: grab;
	}
</style>
<body>
<div class="col s12 row" style="height: 500px;"
	 id="ferrumVisualFormEditorContainer">
	<div class="col s7 card-panel container" style="height: 100%; overflow: scroll; overflow-x: hidden;" id="tree">
		<div class="card-panel ferrum-draggable">XD</div>
	</div>
	<div class="col s5 card-panel container" style="height: 100%; overflow: scroll; overflow-x: hidden;" id="items">
		<div class="card-panel ferrum-draggable">ABC</div>
	</div>
</div>
