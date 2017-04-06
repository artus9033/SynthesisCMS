var mImagePickerTrumbowyg;

function nitrogenImagePickerCallback(url) {
    mImagePickerTrumbowyg.execCmd('insertImage', url, false, true);
}

SynthesisCmsJsUtils.includeImagePickerDynamically('nitrogen_create_item_picker', 'nitrogenImagePickerCallback', true);

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
                            $("#nitrogen_create_item_picker").modal("open");
                        }
                    };
                    trumbowyg.addBtnDef("insertImageFromServer", btnDef);
                }
            }
        }
    });
})(jQuery);