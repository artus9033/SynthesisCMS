<div id="image-picker" class="modal modal-fixed-footer">
	<div class="modal-content">
		<div class="col s12 row">
			<h4><i class="material-icons medium valign {{ $synthesiscmsMainColor }}-text">cloud</i>&nbsp;&nbsp;{{ trans('synthesiscms/admin.choose_image') }}</h4>
			<nav>
				<div class="nav-wrapper">
					<div class="col s12" id="path">
						<a class="white-text breadcrumb" onclick="setPickerPath('/')">{{ trans('synthesiscms/admin.chooser_path') }}&nbsp;{{ trans('synthesiscms/admin.chooser_path_root') }}</a>
					</div>
				</div>
			</nav>
			<div class="progress">
				<div id="loading" class="indeterminate"></div>
			</div>
		</div>
		<div class="col s12 row divider {{ $synthesiscmsMainColor }}"></div>
			<div class="file-field input-field col s12 row">
				<div class="btn {{ $synthesiscmsMainColor }}">
					<i class="material-icons white-text">attachment</i>
					<input type="file" id="fileinput">
				</div>
				<div class="file-path-wrapper">
					<input class="file-path validate" type="text" placeholder="{{ trans('synthesiscms/admin.chooser_upload') }}">
				</div>
				<a class="btn {{ $synthesiscmsMainColor }} col s12 waves-effect waves-light" onclick="uploadPickerNow()">{{ trans('synthesiscms/admin.chooser_upload') }}</a>
			</div>
		<script>
		function uploadPickerNow(){
			var formData = new FormData();
			formData.append('file', $("#fileinput")[0].files[0])
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
					setPickerPath("/");
				}
			});
		}
		</script>
		<div class="col s12 row divider {{ $synthesiscmsMainColor }}"></div>
		<div class="col s12 row" id="manager"></div>
	</div>
	<div class="modal-footer">
		<div class="col s12 divider {{ $synthesiscmsMainColor }}"></div>
		<span class="valign">{{ trans('synthesiscms/admin.chosen_image') }}<span id="chosen-image">{{ trans('synthesiscms/admin.chosen_image_none') }}</span><span style="display: none;" id="chosen-image-data"></span></span>
		<a class="modal-action modal-close waves-effect waves-red btn-flat">{{ trans('synthesiscms/admin.chooser_cancel') }}</a>
		<a onclick="imagePickerCallbackCaller()" class="modal-action modal-close waves-effect waves-green btn-flat">{{ trans('synthesiscms/admin.choose') }}</a>
	</div>
</div>
<script>
function imagePickerCallbackCaller(){
	var txt = $('#chosen-image-data').text();
	imagePickerCallback(txt);
}
$(document).ready(function(){
	$('.modal').modal({
		ready: function(modal, trigger) {
			setPickerPath('/');
		}
	});
});//folder_open
function selectImage(name, path){
	$("#chosen-image").text(name);
	$("#chosen-image-data").text(path);
}
function setPickerPath(path){
	//TODO: add path handling in fsctrl and implement exploding the path string in js ad showing in breadcrumbs
	//TODO: implement dirs navigation on icons
	$('#loading').css('display', 'block');
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
					mgrHtml += "<div class='col s4' onclick=\"selectImage('";
					mgrHtml += value['name'] + "', '";
					mgrHtml += value['path'] + "')\"><div class='card'><div class='card-image'><img src='" + value['path'] + "'><span class='card-title card-panel truncate no-padding white {{ $synthesiscmsMainColor }}-text'>" + value['name'] + "</span></div></div></div>"
				});
				$('#manager').html(mgrHtml);
				$('#loading').css('display', 'none');
			},
			error: function() {
				alert("Error");
			}
		}
	);
}
</script>
