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
                    Materialize.toast("Error while retrieving the SynthesisCMS file picker! Please reload the page...", 4000);
                }
            }
        );
    }

    static randomIntegerBetween(min, max){
        return Math.floor((Math.random() * max) + min);
    }

    static hsvToRgb(h, s, v) {
        /**
         * HSV to RGB color conversion
         *
         * H runs from 0 to 360 degrees
         * S and V run from 0 to 100
         *
         * Ported from the excellent java algorithm by Eugene Vishnevsky at:
         * http://www.cs.rit.edu/~ncs/color/t_convert.html
         */
        var r, g, b;
        var i;
        var f, p, q, t;

        // Make sure our arguments stay in-range
        h = Math.max(0, Math.min(360, h));
        s = Math.max(0, Math.min(100, s));
        v = Math.max(0, Math.min(100, v));

        // We accept saturation and value arguments from 0 to 100 because that's
        // how Photoshop represents those values. Internally, however, the
        // saturation and value are calculated from a range of 0 to 1. We make
        // That conversion here.
        s /= 100;
        v /= 100;

        if (s == 0) {
            // Achromatic (grey)
            r = g = b = v;
            return [Math.round(r * 255), Math.round(g * 255), Math.round(b * 255)];
        }

        h /= 60; // sector 0 to 5
        i = Math.floor(h);
        f = h - i; // factorial part of h
        p = v * (1 - s);
        q = v * (1 - s * f);
        t = v * (1 - s * (1 - f));

        switch (i) {
            case 0:
                r = v;
                g = t;
                b = p;
                break;

            case 1:
                r = q;
                g = v;
                b = p;
                break;

            case 2:
                r = p;
                g = v;
                b = t;
                break;

            case 3:
                r = p;
                g = q;
                b = v;
                break;

            case 4:
                r = t;
                g = p;
                b = v;
                break;

            default: // case 5:
                r = v;
                g = p;
                b = q;
        }

        return [Math.round(r * 255), Math.round(g * 255), Math.round(b * 255)];
    }

    static generateUniqueRgbColorsArray(colorCount) {
        var i = 360 / (colorCount - 1); // distribute the colors evenly on the hue range
        var r = []; // hold the generated colors
        for (var x = 0; x < colorCount; x++) {
            var h = (i * x);
            if(isNaN(h)){
                h = 0; // This fixes an error if colorCont = 0
            }
            r.push(SynthesisCmsJsUtils.hsvToRgb(h, SynthesisCmsJsUtils.randomIntegerBetween(35, 80), SynthesisCmsJsUtils.randomIntegerBetween(35, 80)));
        }
        return r;
    }
}