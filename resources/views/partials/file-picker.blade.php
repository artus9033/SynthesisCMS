<div id="{{ $picker_modal_id }}" class="modal modal-fixed-footer">
	<div class="modal-content">
		<div class="col s12 row">
			<h4 class="{{ $synthesiscmsMainColor }}-text center">
				<i class="material-icons medium valign">cloud</i>&nbsp;&nbsp;{{ trans('synthesiscms/admin.choose_image') }}
			</h4>
			<nav>
				<div class="nav-wrapper {{ $synthesiscmsMainColor }}">
					<div class="col s12" id="{{ $picker_modal_id }}_path">
					</div>
				</div>
			</nav>
			<div class="progress" style="margin-top: 10px;">
				<div id="{{ $picker_modal_id }}_loading" class="indeterminate"></div>
			</div>
		</div>
        <div class="center col s12 row">
            <a onclick="{{ $picker_modal_id }}_askForCreateDirectory()" class="btn {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} waves-effect waves-light hoverable">
                    <i class="material-icons white-text left">create_new_folder</i>
                    {{ trans('synthesiscms/admin.chooser_create_directory') }}
            </a>
        </div>
        <div class="col s12 row divider {{ $synthesiscmsMainColor }}"></div>
        <div class="col s12 row">
            <h5 class="teal-text center">
                {{ trans('synthesiscms/admin.chooser_upload_header')}}
            </h5>
        </div>
		<div class="file-field input-field col s12 row">
			<div class="btn col {{ $synthesiscmsMainColor }}">
				<i class="material-icons white-text">attachment</i>
				<input type="file" id="{{ $picker_modal_id }}_fileinput">
			</div>
			<div class="file-path-wrapper hide-on-small-only col s10">
				<input class="file-path validate" type="text"
					   placeholder="{{ trans('synthesiscms/admin.chooser_file_hint') }}">
			</div>
			<a class="btn {{ $synthesiscmsMainColor }} col waves-effect waves-light"
			   onclick="{{ $picker_modal_id }}_uploadPickerNow()">{{ trans('synthesiscms/admin.chooser_upload') }}</a>
		</div>
        <script>
            function {{ $picker_modal_id }}_uploadPickerNow() {
                var mCurrentPath = synthesiscmsPicker{{ $picker_modal_id }}CurrentPath;
                var formData = new FormData();
                formData.append('path', mCurrentPath);
                formData.append('synthesiscms-file', $("#{{ $picker_modal_id }}_fileinput")[0].files[0]);
                $.ajax({
                    url: {!! json_encode(route('admin_upload_post')) !!},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: formData,
                    async: true,
                    cache: false,
                    contentType: false,
                    enctype: 'multipart/form-data',
                    processData: false,
                    success: function (response) {
                        if(response.success) {
                            {{ $picker_modal_id }}_setPickerPath(mCurrentPath);
                            SynthesisCmsJsUtils.showToast("{{ trans('synthesiscms/admin.chooser_toast_upload_complete') }}");
                        }else{
                            SynthesisCmsJsUtils.showToast("{{ trans('synthesiscms/admin.chooser_toast_upload_failed') }}");
                            console.error("SynthesisCMS file picker upload error: ");
                            console.error(response);
						}
                    },
					error: function(response){
                        SynthesisCmsJsUtils.showToast("{{ trans('synthesiscms/admin.chooser_toast_upload_failed') }}");
                        console.error("SynthesisCMS file picker upload error: ");
                        console.error(response);
					}
                });
            }

            function {{ $picker_modal_id }}_askForCreateDirectory() {
                var mCurrentPath = synthesiscmsPicker{{ $picker_modal_id }}CurrentPath;
                var formData = new FormData();
                var newDirName = prompt("Podaj nazwę nowego katalogu", "");
                var fullNewDirPath = `${mCurrentPath.endsWith("/") ? mCurrentPath : `${mCurrentPath}/`}${newDirName}`;
                formData.append('path', fullNewDirPath);
                $.ajax({
                    url: {!! json_encode(route('admin_uploads_create_dir')) !!},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: formData,
                    async: true,
                    cache: false,
                    contentType: false,
                    enctype: 'multipart/form-data',
                    processData: false,
                    success: function (response) {
                        if(response.success) {
                            {{ $picker_modal_id }}_setPickerPath(mCurrentPath);
                            SynthesisCmsJsUtils.showToast("{{ trans('synthesiscms/admin.chooser_toast_create_dir_success') }}");
                        }else{
                            SynthesisCmsJsUtils.showToast("{{ trans('synthesiscms/admin.chooser_toast_create_dir_failed') }}");
                            console.error("SynthesisCMS file picker create directory error: ");
                            console.error(response);
						}
                    },
					error: function(response){
                        SynthesisCmsJsUtils.showToast("{{ trans('synthesiscms/admin.chooser_toast_create_dir_failed') }}");
                        console.error("SynthesisCMS file picker create directory error: ");
                        console.error(response);
					}
                });
            }

            function {{ $picker_modal_id }}_moveFile(sourceFile, targetDirectory) {
                var mCurrentPath = synthesiscmsPicker{{ $picker_modal_id }}CurrentPath;
                var formData = new FormData();
                formData.append('sourceFile', sourceFile);
                formData.append('targetDirectory', targetDirectory);
                $.ajax({
                    url: {!! json_encode(route('admin_uploads_move_file')) !!},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: formData,
                    async: true,
                    cache: false,
                    contentType: false,
                    enctype: 'multipart/form-data',
                    processData: false,
                    success: function (response) {
                        if(response.success) {
                            {{ $picker_modal_id }}_setPickerPath(mCurrentPath);
                            SynthesisCmsJsUtils.showToast("{{ trans('synthesiscms/admin.chooser_toast_move_file_success') }}");
                        }else{
                            SynthesisCmsJsUtils.showToast("{{ trans('synthesiscms/admin.chooser_toast_move_file_failed') }}");
                            console.error("SynthesisCMS file picker move file error: ");
                            console.error(response);
						}
                    },
					error: function(response){
                        SynthesisCmsJsUtils.showToast("{{ trans('synthesiscms/admin.chooser_toast_move_file_failed') }}");
                        console.error("SynthesisCMS file picker move file error: ");
                        console.error(response);
					}
                });
            }
		</script>
		<div class="col s12 row divider {{ $synthesiscmsMainColor }}"></div>
		<div class="col s12 row" id="{{ $picker_modal_id }}_manager" style="text-align: center;"></div>
	</div>
	<div class="modal-footer">
		<span class="valign">
			{{ trans('synthesiscms/admin.chosen_image') }}
			<span id="{{ $picker_modal_id }}_chosen-image">{{ trans('synthesiscms/admin.chosen_image_none') }}</span>
			<span style="display: none;" id="{{ $picker_modal_id }}_chosen-image-data"></span>
			<span style="display: none;" id="{{ $picker_modal_id }}_chosen-image-size"></span>
		</span>
		<a class="modal-action modal-close waves-effect waves-red btn-flat">{{ trans('synthesiscms/admin.chooser_cancel') }}</a>
		<a onclick="{{ $callback_function_name }}($('#{{ $picker_modal_id }}_chosen-image-data').text(), $('#{{ $picker_modal_id }}_chosen-image-size').text())"
		   class="modal-action modal-close waves-effect waves-green btn-flat">{{ trans('synthesiscms/admin.choose') }}</a>
	</div>
</div>
<script>
	var synthesiscmsPicker{{ $picker_modal_id }}CurrentPath = '';
    $('#{{ $picker_modal_id }}').modal({
        onOpenEnd: function (modal, trigger) {
            {{ $picker_modal_id }}_setPickerPath('/');
        }
    });

    function {{ $picker_modal_id }}_selectFile(name, path, size) {
        $("#{{ $picker_modal_id }}_chosen-image").text(name);
        $("#{{ $picker_modal_id }}_chosen-image-data").text(path);
        $("#{{ $picker_modal_id }}_chosen-image-size").text(size);
    }

    function {{ $picker_modal_id }}_ondragover(ev) {
        ev.preventDefault();

        var tgt = ev.target;

        if(ev.target.tagName != "DIV"){
            tgt = $(tgt).closest("div");
        }

        $(tgt).css("background-color", "{{ $synthesiscmsMainColor }}");
    }

    function {{ $picker_modal_id }}_ondragleave(ev) {
        ev.preventDefault();

        var tgt = ev.target;

        if(ev.target.tagName != "DIV"){
            tgt = $(tgt).closest("div");
        }

        $(tgt).css("background-color", "");
    }

    function {{ $picker_modal_id }}_drag(ev) {
        ev.dataTransfer.setData("text", ev.target.attributes["data-filepath"].value);
    }

    function {{ $picker_modal_id }}_drop(ev) {
        ev.preventDefault();
        var data = ev.dataTransfer.getData("text");

        var tgt = ev.target;

        if(ev.target.tagName != "DIV"){
            tgt = $(tgt).closest("div");
        }

        $(tgt).css("background-color", "");

        {{ $picker_modal_id }}_moveFile(data, $(tgt).attr("data-dirpath"));
    }

    function {{ $picker_modal_id }}_ondragover_breadcrumbs(ev) {
        ev.preventDefault();

        var tgt = ev.target;

        $(tgt).css("background-color", "white");
    }

    function {{ $picker_modal_id }}_ondragleave_breadcrumbs(ev) {
        ev.preventDefault();

        var tgt = ev.target;

        $(tgt).css("background-color", "");
    }

    function {{ $picker_modal_id }}_drop_breadcrumbs(ev) {
        ev.preventDefault();
        var data = ev.dataTransfer.getData("text");

        var tgt = ev.target;

        $(tgt).css("background-color", "");

        {{ $picker_modal_id }}_moveFile(data, $(tgt).attr("data-dirpath"));
    }

    function {{ $picker_modal_id }}_setPickerPath(path) {
        synthesiscmsPicker{{ $picker_modal_id }}CurrentPath = path;
        $('#{{ $picker_modal_id }}_loading').css('display', 'block');
        $.ajax(
            {
                url: {!! json_encode(route('admin_uploads_list')) !!},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    path: path,
                    extensions: {!! json_encode($fileExtensions) !!}
                },
                success: function (data) {
                    var mgrHtml = "";
                    $.each(data['files'], function (index, value) {
                        if (value['mime_type'].includes('image')) {
                            var imgObject = SynthesisCmsJsUtils.addDynamicSynthesisUrlClientSideProcessableAttributesToElement($("<img style='width: 100%; height: 100%; object-fit: cover'>"), value['path'], 'src');
                            mgrHtml += `<div data-filepath='${value['path']}' draggable='true' ondragstart='{{ $picker_modal_id }}_drag(event)' style='overflow: hidden;' data-position='top' data-delay='50' data-tooltip='${value['name']}' class='col s12 m6 l3 waves-effect waves-light tooltipped synthesis-aspect-ratio card synthesiscms-file-picker-pointer-element hoverable no-padding' onclick=\"{{ $picker_modal_id }}_selectFile('`;
                            mgrHtml += value['name'] + "', '";
                            mgrHtml += value['path'] + "', '" + value['size'] + "')\"><div class='card-image' style='width: 100%; height: 100%;'>" + imgObject.prop('outerHTML') + "<span class='card-title card-panel truncate no-padding col s12 white-text' style='margin: unset !important; background-color: rgba(100, 100, 100, 0.5);text-shadow: -1px -1px 0 #000,1px -1px 0 #000,-1px 1px 0 #000,1px 1px 0 #000;'>" + value['name'] + "</span></div></div>";
                        } else {
                            mgrHtml += `<div data-filepath='${value['path']}' draggable='true' ondragstart='{{ $picker_modal_id }}_drag(event)' style='overflow: hidden;' data-position='top' data-delay='50' data-tooltip='${value['name']}' class='col s12 m6 l3 waves-effect waves-light tooltipped synthesis-aspect-ratio card synthesiscms-file-picker-pointer-element hoverable no-padding' onclick=\"{{ $picker_modal_id }}_selectFile('`;
                            mgrHtml += value['name'] + "', '";
                            mgrHtml += value['path'] + "', '" + value['size'] + "')\"><i style='font-size: 140px;' class='material-icons {{ $synthesiscmsMainColor }}-text {{ $synthesiscmsMainColorClass }}'>insert_drive_file</i><span class='center col s12 row' style='margin-top: 5px; margin-bottom: 5px; height: 100%;'>" + value['name'] + "</div>";
                        }
                    });

                    $.each(data['directories'], function (index, value) {
                        var nameExtracted = value['name'].split("/").slice(-1)[0];

                        mgrHtml += `<div data-filepath='${value['name']}' data-dirpath='${value['name']}' ondrop='{{ $picker_modal_id }}_drop(event)' ondragover='{{ $picker_modal_id }}_ondragover(event)' ondragleave='{{ $picker_modal_id }}_ondragleave(event)' draggable='true' ondragstart='{{ $picker_modal_id }}_drag(event)'  style='overflow: hidden;' data-position='top' data-delay='50' data-tooltip='${nameExtracted}' class='col s12 m6 l3 waves-effect waves-light tooltipped synthesis-aspect-ratio card synthesiscms-file-picker-pointer-element hoverable no-padding' onclick=\"{{ $picker_modal_id }}_setPickerPath('${value['name']}')\"><i style='font-size: 140px;' class='material-icons {{ $synthesiscmsMainColor }}-text {{ $synthesiscmsMainColorClass }}'>folder</i><span class='center col s12 row' style='margin-top: 5px; margin-bottom: 5px; height: 100%;'>${nameExtracted}</div>`;
                    });

                    var breadcrumbsHtml = `<a data-dirpath='/' ondrop='{{ $picker_modal_id }}_drop_breadcrumbs(event)' ondragover='{{ $picker_modal_id }}_ondragover_breadcrumbs(event)' ondragleave='{{ $picker_modal_id }}_ondragleave_breadcrumbs(event)' class='white-text breadcrumb' style='cursor: pointer;' onclick="{!! $picker_modal_id !!}_setPickerPath('/')">
                        {{ trans('synthesiscms/admin.chooser_path') }}
                        &nbsp;{{ trans('synthesiscms/admin.chooser_path_root') }}
                    </a>`;
                    var pathSegments = path.split("/");
                    var pathAccumulated = "/";

                    pathSegments.forEach(function(item, index){
                        if(item.length){
                            var isLastSegment = index == pathSegments.length - 1;

                            breadcrumbsHtml += `<a data-dirpath='${pathAccumulated}${item}' class="white-text breadcrumb" style="${isLastSegment ? "" : `cursor: pointer`};" ${isLastSegment ? "" : `onclick="{{ $picker_modal_id }}_setPickerPath('${pathAccumulated}${item}')`}">
                                ${item}
                            </a>`;

                            pathAccumulated += item + "/";
                        }
                    });

                    $("#{{ $picker_modal_id }}_path").html(breadcrumbsHtml);

                    $('#{{ $picker_modal_id }}_manager').html(mgrHtml);

                    $('#{{ $picker_modal_id }}_loading').css('display', 'none');

                    SynthesisCmsJsUtils.triggerSynthesisDynamicUrlsRescanOnElement($('#{{ $picker_modal_id }}_manager').parent());

                    var synthesiscmsFilePickerResizerFunc = function () {
                        $('.synthesis-aspect-ratio').each(function (e) {
                            $(this).height($(this).width());
                        });
                    };

                    $(window).resize(function () {
                        synthesiscmsFilePickerResizerFunc();
                    });

                    $(document).ready(function(){
                        synthesiscmsFilePickerResizerFunc();
                        $('.synthesis-aspect-ratio').each(function (e) {
                            $(this).width(($(this).width() - 12));
                            $(this).css('margin-left', '5px');
                            $(this).css('margin-right', '5px');
                        });
                        $('.tooltipped').tooltip();
					});
                },
                error: function () {
                    console.error("Error retrieving SynthesisCMS file picker data");
                }
            }
        );
    }
</script>
<style>
	.synthesiscms-file-picker-pointer-element {
		cursor: pointer;
		cursor: hand;
	}
</style>
