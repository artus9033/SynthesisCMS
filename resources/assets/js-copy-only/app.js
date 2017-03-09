function setLanguage(lang, base){
	window.location.href = base + "/lang/" + lang;
}

function toggleAll(selector){
	$(selector).each(function(index) {
		$(this).prop('checked', !$(this).is(":checked"));
	});
}

function selectAll(selector){
	$(selector).each(function(index) {
		$(this).prop('checked', 1);
	});
}

function unselectAll(selector){
	$(selector).each(function(index) {
		$(this).prop('checked', 0);
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
	$('.collapsible').collapsible();
});