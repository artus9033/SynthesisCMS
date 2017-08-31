class SynthesisCmsJsUtils {
    static includeFilePickerDynamically(picker_modal_id, callback_function_name, followIframeParentHeight = false, fileExtensions = ['jpg', 'png', 'gif', 'jpeg']) {
        var selfRef = this;
        var mUrl = this.getSiteRootUrl() + '/admin/file-picker';
        $.ajax(
            {
                url: mUrl,
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': this.getCsrfTokenValue()
                },
                data: {
                    picker_modal_id: picker_modal_id,
                    callback_function_name: callback_function_name,
                    followIframeParentHeight: followIframeParentHeight,
                    fileExtensions: fileExtensions
                },
                success: function (data) {
                    $("body").append(data);
                    console.log("SynthesisCmsJsUtils succesfully loaded a file picker element and injected it to the page!");
                },
                error: function () {
                    selfRef.showToast("Error while retrieving the SynthesisCMS file picker! Please reload the page...", 4000);
                }
            }
        );
    }

    static randomIntegerBetween(min, max) {
        return Math.floor((Math.random() * max) + min);
    }

    static hsvToRgbArray(h, s, v) {
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
            if (isNaN(h)) {
                h = 0; // This fixes an error if colorCont = 0
            }
            r.push(this.hsvToRgbArray(h, this.randomIntegerBetween(35, 80), this.randomIntegerBetween(35, 80)));
        }
        return r;
    }

    static hexToRgbaArray(hex, alpha) {
        var c;
        if (/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)) {
            c = hex.substring(1).split('');
            if (c.length == 3) {
                c = [c[0], c[0], c[1], c[1], c[2], c[2]];
            }
            c = '0x' + c.join('');
            return new Array((c >> 16) & 255, (c >> 8) & 255, c & 255, alpha);
        }
        return Array(0, 0, 0, 1);
    }

    static rgbaArrayToRgbaString(rgbaArray){
        return ('rgba(' + rgbaArray[0] + ',' + rgbaArray[1] + ',' + rgbaArray[2] + ',' + rgbaArray[3] + ')');
    }

    static hexToRgbaString(hex, alpha) {
        var rgbaArray = this.hexToRgbaArray(hex, alpha);
        return ('rgba(' + rgbaArray[0] + ',' + rgbaArray[1] + ',' + rgbaArray[2] + ',' + rgbaArray[3] + ')');
    }

    static showToast(content, duration = 3000, toastCallback, bRounded = false) {
        if (!(toastCallback)) {
            toastCallback = function () {
                // Do nothing
            }
        }
        if (!content) {
            content = '';
        }
        Materialize.toast(content, duration, (bRounded ? 'rounded' : ''), toastCallback);
    }

    static showToastWithButton(toastContent, buttonContent, duration = 3000, toastCallback = null, buttonClickCallback = null, bRounded = false) {
        if (!(toastCallback)) {
            toastCallback = function () {
                // Do nothing
            }
        }
        if (!(buttonClickCallback)) {
            buttonClickCallback = function () {
                // Do nothing
            }
        }
        if (!(toastContent)) {
            toastContent = '';
        }
        var selfRef = this;
        var htmlContent = $("<span>" + toastContent + "</span>").add($("<button class='btn-flat waves-effect waves-light toast-action'>" + buttonContent + "</button>").click(function () {
            buttonClickCallback();
            selfRef.dismissAllToasts();
        }));
        Materialize.toast(htmlContent, duration, (bRounded ? 'rounded' : ''), toastCallback);
    }

    static dismissAllToasts() {
        Materialize.Toast.removeAll();
    }

    static getAssetRootUrl() {
        return $('meta[name="synthesiscms-asset-root"]').attr('content')
    }

    static getSiteRootUrl() {
        return $('meta[name="synthesiscms-public-root"]').attr('content');
    }

    static getCsrfTokenValue() {
        return $('meta[name="csrf-token"]').attr('content');
    }

    static getSynthesisDynamicUrlStartTag() {
        return $('meta[name="synthesiscms-dynamic-url-handler-start-tag"]').attr('content');
    }

    static getSynthesisDynamicUrlEndTag() {
        return $('meta[name="synthesiscms-dynamic-url-handler-end-tag"]').attr('content');
    }

    static getRealUrlFromDynamicSynthesisUrl(relativeUrl) {
        return this.getSiteRootUrl() + (relativeUrl.startsWith('/') ? relativeUrl : ("/" + relativeUrl));
    }

    static packDynamicSynthesisUrlIntoServerSideProcessableTags(relativeUrl) {
        return this.getSynthesisDynamicUrlStartTag() + relativeUrl + this.getSynthesisDynamicUrlEndTag();
    }

    static addDynamicSynthesisUrlClientSideProcessableAttributesToElement(elementOrSelector, dynamicUrlValueTagValue, dynamicUrlTargetPositionTagValue) {
        var element;
        if (elementOrSelector instanceof jQuery) {
            element = elementOrSelector;
        } else {
            element = $(elementOrSelector);
        }
        element.attr(this.getSynthesisDynamicUrlPositionTagName(), dynamicUrlTargetPositionTagValue);
        element.attr(this.getSynthesisDynamicUrlValueTagName(), dynamicUrlValueTagValue);
        return element;
    }

    static getSynthesisDynamicUrlValueTagName() {
        return "data-synthesiscms-dynamic-url";
    }

    static getSynthesisDynamicUrlPositionInsideElementTagValue() {
        return "inside-element-html";
    }

    static getSynthesisDynamicUrlPositionTagName() {
        return "data-synthesiscms-dynamic-url-position";
    }

    static getSynthesisDynamicUrlWasProcessedTagName() {
        return "data-synthesiscms-dynamic-url-processed";
    }

    static triggerSynthesisDynamicUrlsRescanOnDocument() {
        console.log('SynthesisCmsJsUtils triggerSynthesisDynamicUrlsRescanOnDocument() invoked');
        this._substituteSynthesisDynamicUrls(document.documentElement);
    }

    static triggerSynthesisDynamicUrlsRescanOnElement(wrapperElement) {
        console.log('SynthesisCmsJsUtils triggerSynthesisDynamicUrlsRescanOnElement(wrapperElement) invoked with wrapperElement:');
        console.log(wrapperElement);
        if (wrapperElement instanceof jQuery) {
            wrapperElement = wrapperElement;
        } else {
            wrapperElement = $(wrapperElement);
        }
        this._substituteSynthesisDynamicUrls(wrapperElement);
    }

    static _substituteSynthesisDynamicUrls(elem) {
        var synthesiscmsJsUtilsSelfRef = this;
        if(elem instanceof jQuery){
            synthesiscmsJsUtilsSelfRef.__substituteSynthesisDynamicUrls(elem);
        }else if(typeof(elem) ==  typeof("")){
            $(elem).each(function (htmlElement) {
                synthesiscmsJsUtilsSelfRef.__substituteSynthesisDynamicUrls($(htmlElement));
            });
        }else{
            synthesiscmsJsUtilsSelfRef.__substituteSynthesisDynamicUrls($(elem));
        }
    }

    static __substituteSynthesisDynamicUrls(jqueryElement) {
        var synthesiscmsJsUtilsSelfRef = this;
        jqueryElement.find('[' + synthesiscmsJsUtilsSelfRef.getSynthesisDynamicUrlValueTagName() + ']').each(function () {
            var parent = $(this);
            var bAlreadyProcessed = (parent.attr(synthesiscmsJsUtilsSelfRef.getSynthesisDynamicUrlWasProcessedTagName()) ? true : false);
            if (bAlreadyProcessed) {
                console.log('SynthesisCmsJsUtils omitting processing of a dynamic-synthesis-url-tagged element (which is printed below), because it\'s already been processed');
                console.log(parent);
            } else {
                console.log('SynthesisCmsJsUtils processing a dynamic-synthesis-url-tagged element (which is printed below)');
                console.log(parent);
                var positionDataAttribute = parent.attr(synthesiscmsJsUtilsSelfRef.getSynthesisDynamicUrlPositionTagName());
                if (positionDataAttribute && positionDataAttribute.length) {
                    var content = parent.attr(synthesiscmsJsUtilsSelfRef.getSynthesisDynamicUrlValueTagName());

                    content = synthesiscmsJsUtilsSelfRef.getRealUrlFromDynamicSynthesisUrl(content);

                    if (positionDataAttribute == synthesiscmsJsUtilsSelfRef.getSynthesisDynamicUrlPositionInsideElementTagValue()) {
                        parent.html(content);
                    } else {
                        parent.attr(positionDataAttribute, content);
                    }
                    parent.attr(synthesiscmsJsUtilsSelfRef.getSynthesisDynamicUrlWasProcessedTagName(), 'true');
                } else {
                    console.warn('SynthesisCmsJsUtils omitting processing of a dynamic-synthesis-url-tagged element (which is printed below), because it\'s url position attribute value is invalid');
                    console.warn(parent);
                }
            }
        });
    }
}

$(document).ready(function () {
    SynthesisCmsJsUtils._substituteSynthesisDynamicUrls(document.documentElement);
});