function setLanguage(lang, base){
	window.location.href = base + "/lang/" + lang;
}

function resizeIframeBasedOnContents(obj) {
    obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
 }

function toggleAll(selector){
	$(selector).each(function(index) {
		$(this).click();
	});
}

function selectAll(selector){
	$(selector).each(function(index) {
		if(!$(this).is(":checked")){
			$(this).click();
		}
	});
}

function unselectAll(selector){
	$(selector).each(function(index) {
		if($(this).is(":checked")){
			$(this).click();
		}
	});
}

$(document).ready(function() {
	$('.dropdown-button').dropdown({
      inDuration: 500,
      outDuration: 350,
      constrain_width: true,
      hover: true,
      gutter: 0,
      belowOrigin: true
    });
    $('select').material_select();
});
