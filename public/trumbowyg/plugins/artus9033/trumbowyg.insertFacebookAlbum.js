(function ($) {
    'use strict';
    $.extend(true, $.trumbowyg, {
        langs: {
            pl: {
                urler: "ID albumu z Facebooka (...&album_id=...)",
                insertFacebookAlbum: 'Wstaw Album Z Facebooka'
            },
            en: {
                urler: "Facebook album ID (...&album_id=...)",
                insertFacebookAlbum: 'Insert Album From Facebook'
            },
            de: {
                urler: "Facebook Album ID (...&album_id=...)",
                insertFacebookAlbum: 'Album vom Facebook einfügen'
            },
            es: {
                urler: "ID de albumo de Facebook (...&album_id=...)",
                insertFacebookAlbum: 'Insertar albumo de Facebook'
            }
        },
        plugins: {
            insertFacebookAlbum: {
                init: function (trumbowyg) {
                    trumbowyg.o.plugins.insertFacebookAlbum = $.extend(true, {}, {}, trumbowyg.o.plugins.insertFacebookAlbum || {});
                    mImagePickerTrumbowyg = trumbowyg;
                    var btnDef = {
                        fn: function () {
                            trumbowyg.saveRange();
                            trumbowyg.openModalInsert(
                                // Title
                                trumbowyg.lang.insertFacebookAlbum,

                                // Fields
                                {
                                    urler: {
                                        type: 'text',
                                        required: true
                                    },
                                },
                                function (v) { // v is value
                                    var frame = $('<iframe class="card-panel z-depth-1 no-padding col s12" src="http://embedsocial.com/facebook_album/album_photos/' + v.urler + '" frameborder="0" scrolling="yes" height="450px" marginheight="0" marginwidth="0"></iframe>');
                                    trumbowyg.range.deleteContents();
                                    trumbowyg.range.insertNode(frame[0]);
                                    return true;
                                });
                        }
                    };
                    trumbowyg.addBtnDef("insertFacebookAlbum", btnDef);
                }
            }
        }
    });
})(jQuery);