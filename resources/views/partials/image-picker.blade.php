<div id="{{ $picker_modal_id }}" class="modal modal-fixed-footer">
	<div class="modal-content">
		<div class="col s12 row">
			<h4><i class="material-icons medium valign {{ $synthesiscmsMainColor }}-text">cloud</i>&nbsp;&nbsp;{{ trans('synthesiscms/admin.choose_image') }}</h4>
			<nav>
				<div class="nav-wrapper">
					<div class="col s12" id="{{ $picker_modal_id }}_path">
						<a class="white-text breadcrumb"
						   onclick="{{ $picker_modal_id }}_setPickerPath('/')">{{ trans('synthesiscms/admin.chooser_path') }}
							&nbsp;{{ trans('synthesiscms/admin.chooser_path_root') }}</a>
					</div>
				</div>
			</nav>
			<div class="progress">
				<div id="{{ $picker_modal_id }}_loading" class="indeterminate"></div>
			</div>
		</div>
		<div class="col s12 row divider {{ $synthesiscmsMainColor }}"></div>
			<div class="file-field input-field col s12 row">
				<div class="btn {{ $synthesiscmsMainColor }}">
					<i class="material-icons white-text">attachment</i>
					<input type="file" id="{{ $picker_modal_id }}_fileinput">
				</div>
				<div class="file-path-wrapper">
					<input class="file-path validate" type="text" placeholder="{{ trans('synthesiscms/admin.chooser_upload') }}">
				</div>
				<a class="btn {{ $synthesiscmsMainColor }} col s12 waves-effect waves-light"
				   onclick="{{ $picker_modal_id }}_uploadPickerNow()">{{ trans('synthesiscms/admin.chooser_upload') }}</a>
			</div>
		<script>
		function uploadPickerNow(){
			var formData = new FormData();
            formData.append('file', $("#{{ $picker_modal_id }}_fileinput")[0].files[0])
			$.ajax({
				url: {!! json_encode(url('/admin/upload')) !!},
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type: 'POST',
				data: formData,
				async: false,
				cache: false,
				contentType: false,
				enctype: 'multipart/form-data',
				processData: false,
				success: function (response) {
                    {{ $picker_modal_id }}_setPickerPath("/");
				}
			});
		}
		</script>
		<div class="col s12 row divider {{ $synthesiscmsMainColor }}"></div>
		<div class="col s12 row" id="{{ $picker_modal_id }}_manager"></div>
	</div>
	<div class="modal-footer">
		<div class="col s12 divider {{ $synthesiscmsMainColor }}"></div>
		<span class="valign">{{ trans('synthesiscms/admin.chosen_image') }}<span
					id="{{ $picker_modal_id }}_chosen-image">{{ trans('synthesiscms/admin.chosen_image_none') }}</span><span
					style="display: none;" id="{{ $picker_modal_id }}_chosen-image-data"></span></span>
		<a class="modal-action modal-close waves-effect waves-red btn-flat">{{ trans('synthesiscms/admin.chooser_cancel') }}</a>
		<a onclick="{{ $callback_function_name }}($('#{{ $picker_modal_id }}_chosen-image-data').text())"
		   class="modal-action modal-close waves-effect waves-green btn-flat">{{ trans('synthesiscms/admin.choose') }}</a>
	</div>
</div>
<script>
			@if(isset($followIframeParentHeight))
			@if($followIframeParentHeight)
    var mNitrogenHeight = $(window.parent).height() / 3;
    if (mNitrogenHeight < 650) {
        mNitrogenHeight = 650;
    }
    $('#{{ $picker_modal_id }}').css('height', mNitrogenHeight);
    @endif
@endif
$(document).ready(function(){
        $('#{{ $picker_modal_id }}').modal({
		ready: function(modal, trigger) {
            {{ $picker_modal_id }}_setPickerPath('/');
		}
	});
});//folder_open
    function {{ $picker_modal_id }}_selectImage(name, path) {
        $("#{{ $picker_modal_id }}_chosen-image").text(name);
        $("#{{ $picker_modal_id }}_chosen-image-data").text(path);
}
    function {{ $picker_modal_id }}_setPickerPath(path) {
	//TODO: add path handling in fsctrl and implement exploding the path string in js ad showing in breadcrumbs
	//TODO: implement dirs navigation on icons
        $('#{{ $picker_modal_id }}_loading').css('display', 'block');
	$.ajax(
		{
			url: {!! json_encode(url('/admin/uploads_list')) !!},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				path: path,
			},
			success: function(dane) {
				var mgrHtml = "";
				$.each(dane['imgs'], function(index, value){
                    mgrHtml += "<div class='col s4' onclick=\"{{ $picker_modal_id }}_selectImage('";
					mgrHtml += value['name'] + "', '";
					mgrHtml += value['path'] + "')\"><div class='card'><div class='card-image'><img src='" + value['path'] + "'><span class='card-title card-panel truncate no-padding white {{ $synthesiscmsMainColor }}-text'>" + value['name'] + "</span></div></div></div>"
				});
                $('#{{ $picker_modal_id }}_manager').html(mgrHtml);
                $('#{{ $picker_modal_id }}_loading').css('display', 'none');
			},
			error: function() {
				alert("Error");
			}
		}
	);
}
</script>
