class SynthesisCmsJsUtils {
    static includeFilePickerDynamically(picker_modal_id, callback_function_name, followIframeParentHeight = false, fileExtensions = ['jpg', 'png', 'gif', 'jpeg']) {
        var mUrl = $('meta[name="synthesiscms-public-root"]').attr('content') + '/admin/file-picker';
        $.ajax(
            {
                url: mUrl,
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    picker_modal_id: picker_modal_id,
                    callback_function_name: callback_function_name,
                    followIframeParentHeight: followIframeParentHeight,
                    fileExtensions: fileExtensions
                },
                success: function (dane) {
                    $("body").append(dane);
                    console.log("SynthesiscmsJsUtils succesfully loaded a file picker element and injected it to the page!");
                },
                error: function () {
                    alert("Error while retrieving the SynthesisCMS file picker!");
                }
            }
        );
    }

}