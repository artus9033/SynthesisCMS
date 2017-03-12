<style id="boron-stylesheet">
#boron-like-box {
	position: fixed;
	z-index: 99;
	top: 350px;
	transition: left 1s ease-out, top 1s ease-out;
}

#boron-like-box:hover {
	bottom: unset;
	top: 150px;
	left: 0px;
}

#boron-like-box .boron-outside {
	position: relative;
	z-index: 1;
	background: #3b5999;
	padding: 2px;
	min-width: 1px;
	float: left;
}

#boron-like-box .boron-inside {
	position: relative;
	z-index: 2;
	background: #fff;
}

#boron-like-box .boron-belt {
	position: relative;
	z-index: 99999;
	transform: rotate(90deg);
	float: left;
	width: 120px;
	height: 40px;
	padding: 5px 0px 0px 20px;
	margin: 50px 0px 0px -46px;
	background: #3b5999;
	color: #fff;
	font-weight: bold;
	font-family: Roboto;
	font-size: 19px;
	border-radius: 6px;
}
</style>
<div id="boron-like-box">
	<div class="boron-outside">
		<div class="boron-inside">
			<iframe src="https://www.facebook.com/plugins/page.php?locale={!! \App\Toolbox::getDoubleLocale(\App::getLocale()) !!}&href={!! $model->url !!}&tabs=timeline%2C%20events&width=340&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="340" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
		</div>
	</div>
	<div class="boron-belt">{{ trans('Boron::Boron.facebook') }}</div>
</div>
<script>
function changeCSS(sheetId, selector, property, value){
        var s = document.getElementById(sheetId).sheet;
        var rules = s.cssRules || s.rules;
        for(var i = rules.length - 1, found = false; i >= 0 && !found; i--){
            var r = rules[i];
            if(r.selectorText == selector){
                r.style.setProperty(property, value);
                found = true;
            }
        }
        if(!found){
            s.insertRule(selector + '{' + property + ':' + value + ';}', rules.length);
        }
    }
$(document).ready(function() {
	changeCSS('boron-stylesheet', '#boron-like-box', 'left', -$('.boron-outside').width() - 3 + "px");
	changeCSS('boron-stylesheet', '#boron-like-box', 'bottom', $('.boron-like-box').height() + "px");
	$.ajaxSetup({ cache: true });
	$.getScript('//connect.facebook.net/{!! \App::getLocale() !!}/sdk.js#xfbml=1&version=v2.8', function(){
		FB.init({
			appId: "{{ $model->facebookAppId }}",
			version: 'v2.7'
		});
		$('#loginbutton,#feedbutton').removeAttr('disabled');
		FB.getLoginStatus(function(){
			//do something
		});
	});
});
</script>
