function toggleAll(selector) {
  $(selector).each(function(index) {
    $(this).prop("checked", !$(this).is(":checked"));
  });
}

function selectAll(selector) {
  $(selector).each(function(index) {
    $(this).prop("checked", 1);
  });
}

function unselectAll(selector) {
  $(selector).each(function(index) {
    $(this).prop("checked", 0);
  });
}

$.ajaxSetup({
  headers: {
    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
  }
});

function synthesiscmsResizeBrandLogoMargin() {
  $("#synthesiscms-mobile-brand-logo").css(
    "width",
    $("body").width() - $(".synthesiscms-mobile-btn-wrapper").width()
  );
  $("#synthesiscms-mobile-brand-logo").css(
    "max-width",
    $("body").width() - $(".synthesiscms-mobile-btn-wrapper").width()
  );
  $("#synthesiscms-mobile-brand-logo").css(
    "padding-left",
    $(".synthesiscms-mobile-btn-wrapper").width()
  );
  $("#synthesiscms-desktop-brand-logo").css(
    "max-width",
    $("#synthesiscms-admin-nav-wrapper").width() -
      $("#synthesiscms-large-screens-menu-part-right").width()
  );
}

$(document).ready(function() {
  $(function() {
    $.getScript(
      "//connect.facebook.net/{!! App::getLocale() !!}/sdk.js#xfbml=1&version=v3.0",
      function() {
        FB.init({
          appId: "{{ $model->facebookAppId }}",
          version: "v2.7"
        });

        $("#loginbutton,#feedbutton").removeAttr("disabled");

        FB.getLoginStatus(function() {
          //do something
        });
      }
    );

    synthesiscmsResizeBrandLogoMargin();

    $(".dropdown-trigger").dropdown({
      inDuration: 500,
      outDuration: 350,
      constrain_width: true,
      hover: true,
      gutter: 0,
      coverTrigger: true
    });

    $(".tabs").tabs();

    $(".tooltipped").tooltip();

    $("select").formSelect();

    $(".collapsible").collapsible();

    $(".materialboxed").materialbox();

    try {
      $("body").overlayScrollbars({
        scrollbars: {
          autoHide: "move",
          autoHideDelay: 1500
        }
      });
    } catch (e) {
      // this is needed
    }
  });
});

$(window).resize(function() {
  synthesiscmsResizeBrandLogoMargin();
});

/*
 ThatsNotYoChild.js, by Louis Lazaris
 Explanation: http://www.impressivewebs.com/fixing-parent-child-opacity/
 This is a hacky workaround to let you use opacity on any element and prevent the child elements from inheriting the opacity.
 Works in IE8+.
 If anyone can get line 23 working in IE7, it will be fully cross-browser.
 */
function thatsNotYoChild(parentID) {
  var parent = document.getElementById(parentID),
    children = parent.innerHTML,
    wrappedChildren =
      '<div id="children" class="children">' + children + "</div>",
    x,
    y,
    w,
    newParent,
    clonedChild,
    clonedChildOld;

  parent.innerHTML = wrappedChildren;
  clonedChild = document.getElementById("children").cloneNode(true);
  document.getElementById("children").id = "children-old";
  clonedChildOld = document.getElementById("children-old");
  newParent = parent.parentNode;

  newParent.appendChild(clonedChild);
  clonedChildOld.style.opacity = "0";
  clonedChildOld.style.filter = "alpha(opacity=0)";

  function doCoords() {
    x = clonedChildOld.getBoundingClientRect().left;
    y = clonedChildOld.getBoundingClientRect().top;
    if (clonedChildOld.getBoundingClientRect().width) {
      w = clonedChildOld.getBoundingClientRect().width; // for modern browsers
    } else {
      w = clonedChildOld.offsetWidth; // for oldIE
    }

    clonedChild.style.position = "absolute";
    clonedChild.style.left = x + "px";
    clonedChild.style.top = y + "px";
    clonedChild.style.width = w + "px";
  }

  window.onresize = function() {
    doCoords();
  };

  doCoords();
}

function blendColors() {
  var args = [].slice.call(arguments);
  var base = [0, 0, 0, 0];
  var mix;
  var added;
  while ((added = args.shift())) {
    if (typeof added[3] === "undefined") {
      added[3] = 1;
    }
    // check if both alpha channels exist.
    if (base[3] && added[3]) {
      mix = [0, 0, 0, 0];
      // alpha
      mix[3] = 1 - (1 - added[3]) * (1 - base[3]);
      // red
      mix[0] = Math.round(
        (added[0] * added[3]) / mix[3] +
          (base[0] * base[3] * (1 - added[3])) / mix[3]
      );
      // green
      mix[1] = Math.round(
        (added[1] * added[3]) / mix[3] +
          (base[1] * base[3] * (1 - added[3])) / mix[3]
      );
      // blue
      mix[2] = Math.round(
        (added[2] * added[3]) / mix[3] +
          (base[2] * base[3] * (1 - added[3])) / mix[3]
      );
    } else if (added) {
      mix = added;
    } else {
      mix = base;
    }
    base = mix;
  }

  return mix;
}
