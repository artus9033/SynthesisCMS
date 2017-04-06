class SynthesisCmsJsUtils {
    static includeImagePickerDynamically(picker_modal_id, callback_function_name, followIframeParentHeight = false) {
        var mUrl = $('meta[name="synthesiscms-public-root"]').attr('content') + '/admin/image-picker';
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
                    followIframeParentHeight: followIframeParentHeight
                },
                success: function (dane) {
                    $("body").append(dane);
                    console.log("SynthesiscmsJsUtils succesfully loaded an image picker element and injected it to the page!");
                },
                error: function () {
                    alert("Error");
                }
            }
        );
    }

}