var mFileEmbedPickerTrumbowyg;

function trumbowygFilePickerCallback(url, fsize) {
    var fname = url.substring(url.lastIndexOf('/') + 1);
    var div = $('<div class="row"><div class="col s12"><div class="card small"><div class="card-content"><p>' + fname + '</p></div><div class="card-action"><a class="truncate" href="' + url + '"><i class="material-icons">file_download</i> ' + fname + '</a></div></div></div></div>');
    mFileEmbedPickerTrumbowyg.range.deleteContents();
    mFileEmbedPickerTrumbowyg.range.insertNode(div[0]);
}

SynthesisCmsJsUtils.includeFilePickerDynamically('trumbowyg_embed_file_picker', 'trumbowygFilePickerCallback', true, ['pdf', 'doc', 'docx', 'odt', 'txt', 'ppt', 'pptx', 'rtf']);

(function ($) {
    'use strict';
    $.extend(true, $.trumbowyg, {
        langs: {
            pl: {
                fileEmbed: 'Wstaw Plik z Serwera'
            },
            en: {
                fileEmbed: 'Insert File From Server'
            },
            de: {
                fileEmbed: 'Datei vom Server einfügen'
            },
            es: {
                fileEmbed: 'Insertar expediente desde el servidor'
            }
        },
        plugins: {
            fileEmbed: {
                init: function (trumbowyg) {
                    trumbowyg.o.plugins.fileEmbed = $.extend(true, {}, {}, trumbowyg.o.plugins.fileEmbed || {});
                    mFileEmbedPickerTrumbowyg = trumbowyg;
                    var btnDef = {
                        fn: function () {
                            trumbowyg.saveRange();
                            $("#trumbowyg_embed_file_picker").modal("open");
                        }
                    };
                    trumbowyg.addBtnDef("fileEmbed", btnDef);
                }
            }
        }
    });
})(jQuery);