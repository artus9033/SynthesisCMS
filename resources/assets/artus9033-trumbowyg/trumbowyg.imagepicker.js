var mImagePickerTrumbowyg;

function trumbowygImagePickerCallback(url, fsize) {
    var div = $("<span><div class='col s12 row'><img class='col s10 offset-s1' src='" + url + "'></div></span>");
    mImagePickerTrumbowyg.range.deleteContents();
    mImagePickerTrumbowyg.range.insertNode(div[0]);
    //mImagePickerTrumbowyg.execCmd('insertImage', url, false, true);
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
                            trumbowyg.saveRange();
                            $("#trumbowyg_image_picker").modal("open");
                        }
                    };
                    trumbowyg.addBtnDef("insertImageFromServer", btnDef);
                }
            }
        }
    });
})(jQuery);