var mFileEmbedPickerTrumbowyg;

function trumbowygFilePickerCallback(url, fsize) {
    var fname = url.substring(url.lastIndexOf('/') + 1);
    var mAssetBaseUrl = $('meta[name="synthesiscms-asset-root"]').attr('content')
    var div = $('<iframe srcdoc=\'<html>' +
        '<head>' +
        '<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">' +
        '<link type="text/css" rel="stylesheet" href="' + mAssetBaseUrl + 'css/materialize.css" media="screen,projection"/>' +
        '<link href="' + mAssetBaseUrl + 'css/app.css" rel="stylesheet">' +
        '<script type="text/javascript" src="' + mAssetBaseUrl + 'js/jquery-3.1.1.min.js"></script>' +
        '<script type="text/javascript" src="' + mAssetBaseUrl + 'js/materialize.js"></script>' +
        '<script type="text/javascript" src="' + mAssetBaseUrl + 'js/app.js"></script>' +
        '<script type="text/javascript" src="' + mAssetBaseUrl + 'js/clipboard.min.js"></script>' +
        '<script type="text/javascript" src="' + mAssetBaseUrl + 'js/synthesiscms-js-utils.js"></script>' +
        '</head>' +
        '<body>' +
        '<div class="card">' +
        '<div class="card-content">' +
        '<p>content</p>' +
        '</div>' +
        '<div class="card-action">' +
        '<a class="truncate" href="url"><i class="material-icons">file_download</i>name</a>' +
        '</div>' +
        '</div>' +
        '</body>' +
        '</html>\'></iframe>');
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