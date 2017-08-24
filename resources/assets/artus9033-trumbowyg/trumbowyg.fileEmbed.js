var mFileEmbedPickerTrumbowyg;

function trumbowygFilePickerCallback(url, fsize) {
    if(url.length) {
        url += '/download';
        var fileName = url.substring(url.lastIndexOf('/') + 1);
        var mAssetBaseUrl = SynthesisCmsJsUtils.getAssetRootUrl();
        var html = $("<html></html>");
        var head = $("<head></head>");
        var body = $("<body></body>");
        var card = $("<div class='synthesis-dynamic-url-file-wrapper col s12 l8 offset-l2 card'></div>");
        var cardContent = $("<div class='card-content'></div>");
        var cardDescription = $("<p>" + fileName + " (" + fsize + ")" + "</p>");
        var cardActionDiv = $("<div class='card-action'></div>");
        var cardActionItem = $("<a target='_blank' class='truncate'><i class='material-icons'>file_download</i>" + fileName + "</a>");
        var script = $("<script>$(document).ready(function(){SynthesisCmsJsUtils.triggerSynthesisDynamicUrlsRescanOnElement('.synthesis-dynamic-url-file-wrapper');});");
        cardActionItem = SynthesisCmsJsUtils.addDynamicSynthesisUrlClientSideProcessableAttributesToElement(cardActionItem, url, "href");
        cardActionDiv.append(cardActionItem);
        cardContent.append(cardDescription);
        card.append(cardContent);
        card.append(cardActionDiv);
        var materializecss = $('<link type="text/css" rel="stylesheet" href="' + mAssetBaseUrl + 'css/materialize.css" media="screen,projection"/>');
        var materialicons = $('<link type="text/css" rel="stylesheet" href="' + mAssetBaseUrl + 'fonts/material-icons/material-icons.css">')
        var appcss = $('<link href="' + mAssetBaseUrl + 'css/app.css" rel="stylesheet">');
        var jqueryscript = $('<script type="text/javascript" src="' + mAssetBaseUrl + 'js/jquery-3.1.1.min.js"></script>');
        var materializescript = $('<script type="text/javascript" src="' + mAssetBaseUrl + 'js/materialize.js"></script>');
        var appscript = $('<script type="text/javascript" src="' + mAssetBaseUrl + 'js/app.js"></script>');
        var clipboardjs = $('<script type="text/javascript" src="' + mAssetBaseUrl + 'js/clipboard.min.js"></script>');
        var synthesiscmsjsutils = $('<script type="text/javascript" src="' + mAssetBaseUrl + 'js/synthesiscms-js-utils.js"></script>');
        var metaSiteRoot = $('<meta name="synthesiscms-public-root" content="' + SynthesisCmsJsUtils.getSiteRootUrl() + '">');
        var metaAssetRoot = $('<meta name="synthesiscms-asset-root" content="' + mAssetBaseUrl + '">');
        head.append(metaSiteRoot, metaAssetRoot);
        head.append(materializecss, materialicons, appcss, jqueryscript, clipboardjs, synthesiscmsjsutils, appscript, materializescript);
        body.append(card);
        body.append(script);
        html.append(head);
        html.append(body);
        var iframe = $('<iframe class="col s12 l8 offset-l2" frameborder="0" scrolling="yes" marginheight="0" marginwidth="0"></iframe>');
        iframe.attr("srcdoc", html.prop('outerHTML'));
        mFileEmbedPickerTrumbowyg.range.deleteContents();
        mFileEmbedPickerTrumbowyg.range.insertNode(iframe[0]);
    }
}

SynthesisCmsJsUtils.includeFilePickerDynamically('trumbowyg_embed_file_picker', 'trumbowygFilePickerCallback', true, ['*']);

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