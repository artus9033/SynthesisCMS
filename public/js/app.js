function setLanguage(lang){
	alert(lang);
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
    setLanguage("A");
});
