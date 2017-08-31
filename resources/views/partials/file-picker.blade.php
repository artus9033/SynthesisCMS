<div id="{{ $picker_modal_id }}" class="modal modal-fixed-footer">
	<div class="modal-content">
		<div class="col s12 row">
			<h4>
				<i class="material-icons medium valign {{ $synthesiscmsMainColor }}-text">cloud</i>&nbsp;&nbsp;{{ trans('synthesiscms/admin.choose_image') }}
			</h4>
			<nav>
				<div class="nav-wrapper">
					<div class="col s12" id="{{ $picker_modal_id }}_path">
						<a class="white-text breadcrumb" onclick="{{ $picker_modal_id }}_setPickerPath('/')">
							{{ trans('synthesiscms/admin.chooser_path') }}
							&nbsp;{{ trans('synthesiscms/admin.chooser_path_root') }}
						</a>
					</div>
				</div>
			</nav>
			<div class="progress">
				<div id="{{ $picker_modal_id }}_loading" class="indeterminate"></div>
			</div>
		</div>
		<div class="col s12 row divider {{ $synthesiscmsMainColor }}"></div>
		<div class="file-field input-field col s12 row">
			<div class="btn col s12 m4 l2{{ $synthesiscmsMainColor }}">
				<i class="material-icons white-text">attachment</i>
				<input type="file" id="{{ $picker_modal_id }}_fileinput">
			</div>
			<div class="row col s12 hide-on-med-and-up"></div>
			<div class="file-path-wrapper m8 l10 hide-on-small-only">
				<input class="file-path validate" type="text"
					   placeholder="{{ trans('synthesiscms/admin.chooser_upload') }}">
			</div>
			<a class="btn {{ $synthesiscmsMainColor }} col s12 waves-effect waves-light"
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
		</script>
		<div class="col s12 row divider {{ $synthesiscmsMainColor }}"></div>
		<div class="col s12 row" id="{{ $picker_modal_id }}_manager"></div>
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
			@if(isset($followIframeParentHeight))
			@if($followIframeParentHeight)
    var mNitrogenHeight = $(window.parent).height() / 3;
    if (mNitrogenHeight < 650) {
        mNitrogenHeight = 650;
    }
    $('#{{ $picker_modal_id }}').css('height', mNitrogenHeight);
    @endif
@endif
$('#{{ $picker_modal_id }}').modal({
        ready: function (modal, trigger) {
            {{ $picker_modal_id }}_setPickerPath('/');
        }
    });
//TODO: handle firs here
    function {{ $picker_modal_id }}_selectFile(name, path, size) {
        $("#{{ $picker_modal_id }}_chosen-image").text(name);
        $("#{{ $picker_modal_id }}_chosen-image-data").text(path);
        $("#{{ $picker_modal_id }}_chosen-image-size").text(size);
    }
    function {{ $picker_modal_id }}_setPickerPath(path) {
        //TODO: add path handling in fsctrl and implement exploding the path string in js ad showing in breadcrumbs
        //TODO: implement dirs navigation on icons
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
                            mgrHtml += "<div style='overflow: hidden;' data-position='top' data-delay='50' data-tooltip='" + value['name'] + "' class='col s12 m6 l3 waves-effect waves-light tooltipped synthesis-aspect-ratio card synthesiscms-file-picker-pointer-element hoverable no-padding' onclick=\"{{ $picker_modal_id }}_selectFile('";
                            mgrHtml += value['name'] + "', '";
                            mgrHtml += value['path'] + "', '" + value['size'] + "')\"><div class='card-image' style='width: 100%; height: 100%;'>" + imgObject.prop('outerHTML') + "<span class='card-title card-panel truncate no-padding col s12 white-text' style='margin: unset !important; background-color: rgba(100, 100, 100, 0.5);text-shadow: -1px -1px 0 #000,1px -1px 0 #000,-1px 1px 0 #000,1px 1px 0 #000;'>" + value['name'] + "</span></div></div>";
                        } else {
                            mgrHtml += "<div class='col s12 m6 l3 waves-effect synthesis-aspect-ratio card-panel synthesiscms-file-picker-pointer-element hoverable {{ $synthesiscmsMainColor }}-text center' onclick=\"{{ $picker_modal_id }}_selectFile('";
                            mgrHtml += value['name'] + "', '";
                            mgrHtml += value['path'] + "', '" + value['size'] + "')\"><span class='center col s12 row' style='margin-top: 5px; margin-bottom: 5px; height: 100%;'>" + value['name'] + "</div>";
                        }
                    });
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