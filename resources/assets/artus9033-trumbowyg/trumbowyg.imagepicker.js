var mImagePickerTrumbowyg;

function trumbowygImagePickerCallback(url, fsize) {
  if (url.length) {
    var img = SynthesisCmsJsUtils.addDynamicSynthesisUrlClientSideProcessableAttributesToElement(
      $("<img class='col s10 offset-s1'>"),
      url,
      "src"
    );
    var wrapper = $(
      "<div class='center synthesis-dynamic-url-img-wrapper'></div>"
    ).append(img);
    mImagePickerTrumbowyg.range.deleteContents();
    mImagePickerTrumbowyg.range.insertNode(wrapper[0]);
    SynthesisCmsJsUtils.triggerSynthesisDynamicUrlsRescanOnElement(
      ".synthesis-dynamic-url-img-wrapper"
    );
  }
}

SynthesisCmsJsUtils.includeFilePickerDynamically(
  "trumbowyg_image_picker",
  "trumbowygImagePickerCallback",
  true,
  ["jpg", "png", "gif", "jpeg", "webp"]
);

(function($) {
  "use strict";
  $.extend(true, $.trumbowyg, {
    langs: {
      pl: {
        insertImageFromServer: "Wstaw Obraz Z Serwera"
      },
      en: {
        insertImageFromServer: "Insert Image From Server"
      },
      de: {
        insertImageFromServer: "Bild vom Server einfügen"
      },
      es: {
        insertImageFromServer: "Insertar imagen desde el servidor"
      }
    },
    plugins: {
      insertImageFromServer: {
        init: function(trumbowyg) {
          trumbowyg.o.plugins.insertImageFromServer = $.extend(
            true,
            {},
            {},
            trumbowyg.o.plugins.insertImageFromServer || {}
          );
          mImagePickerTrumbowyg = trumbowyg;
          var btnDef = {
            fn: function() {
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
