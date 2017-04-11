var mImagePickerTrumbowyg;

function trumbowygImagePickerCallback(url, fsize) {
    mImagePickerTrumbowyg.execCmd('insertImage', url, false, true);
}

SynthesisCmsJsUtils.includeFilePickerDynamically('trumbowyg_image_picker', 'trumbowygImagePickerCallback', true, ['jpg', 'png', 'gif', 'jpeg']);

(function ($) {
    'use strict';
    $.extend(true, $.trumbowyg, {
        langs: {
            pl: {
                insertImageFromServer: 'Wstaw Obraz Z Serwera'
            },
            en: {
                insertImageFromServer: 'Insert Image From Server'
            },
            de: {
                insertImageFromServer: 'Bild vom Server einfügen'
            },
            es: {
                insertImageFromServer: 'Insertar imagen desde el servidor'
            }
        },
        plugins: {
            insertImageFromServer: {
                init: function (trumbowyg) {
                    trumbowyg.o.plugins.insertImageFromServer = $.extend(true, {}, {}, trumbowyg.o.plugins.insertImageFromServer || {});
                    mImagePickerTrumbowyg = trumbowyg;
                    var btnDef = {
                        fn: function () {
                            $("#trumbowyg_image_picker").modal("open");
                        }
                    };
                    trumbowyg.addBtnDef("insertImageFromServer", btnDef);
                }
            }
        }
    });
})(jQuery);