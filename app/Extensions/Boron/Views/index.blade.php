<style>
#like-box {
	position: fixed;
	z-index: 99;
	top: 150px;
	left: -296px;
	transition: left 0.5s ease-out;
}

#like-box:hover {
	left: 0px;
}

#like-box .outside {
	position: relative;
	z-index: 1;
	background: #3b5999;
	padding: 2px;
	min-width: 1px;
	float: left;
}

#like-box .inside {
	position: relative;
	z-index: 2;
	background: #fff;
}

#like-box .belt {
	position: relative;
	z-index: 99999;
	transform: rotate(90deg);
	filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=1);
	float: left;
	width: 120px;
	height: 40px;
	padding: 7px 0px 0px 20px;
	margin: 50px 0px 0px -55px;
	background: #3b5999;
	color: #fff;
	font-weight: bold;
	font-family: Verdana;
	font-size: 16px;
	border-radius: 6px;
}
</style>
<div id="like-box">
	<div class="outside">
		<div class="inside">
			<iframe src="https://www.facebook.com/plugins/page.php?locale={!! \App\Toolbox::getDoubleLocale(\App::getLocale()) !!}&href={!! $model->url !!}&tabs=timeline%2C%20events&width=340&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="340" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
		</div>
	</div>
	<div class="belt">Facebook</div>
</div>
<script>
$(document).ready(function() {
	$.ajaxSetup({ cache: true });
	$.getScript('//connect.facebook.net/{!! \App::getLocale() !!}/sdk.js#xfbml=1&version=v2.8', function(){
		FB.init({
			appId: 'TODO', //TODO: add facebook app id
			version: 'v2.7'
		});
		$('#loginbutton,#feedbutton').removeAttr('disabled');
		FB.getLoginStatus(function(){

		});
	});
});
</script>
