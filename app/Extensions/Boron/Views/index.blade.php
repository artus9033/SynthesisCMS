<style id="boron-stylesheet">
	#boron-like-box {
		position: fixed;
		z-index: 99;
		top: 280px;
		transition: left 0.8s ease-out;
	}

	#boron-like-box:hover {
		bottom: unset;
		left: 0;
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
		padding: 5px 0 0 20px;
		margin: 50px 0 0 -46px;
		background: #3b5999;
		color: #fff;
		font-weight: bold;
		font-family: Roboto, serif;
		font-size: 19px;
		border-radius: 6px;
	}
</style>
<div id="boron-like-box">
	@if($synthesiscmsClientIsAnyMobile)
		<a href="{!! $model->url !!}" class="boron-belt">{{ trans('Boron::boron.facebook') }}</a>
	@else
		<div class="boron-outside">
			<div class="boron-inside">
				<iframe src="https://www.facebook.com/plugins/page.php?locale={!! \App\Toolbox::getFullNameLocale(\App::getLocale()) !!}&href={!! $model->url !!}&tabs=timeline%2C%20events&width=340&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId"
						width="340" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0"
						allowTransparency="true"></iframe>
			</div>
		</div>
		<div class="boron-belt">{{ trans('Boron::boron.facebook') }}</div>
	@endif
</div>
<script>
	function changeCSS(sheetId, selector, property, value) {
		var s = document.getElementById(sheetId).sheet;
		var rules = s.cssRules || s.rules;
		for (var i = rules.length - 1, found = false; i >= 0 && !found; i--) {
			var r = rules[i];
			if (r.selectorText == selector) {
				r.style.setProperty(property, value);
				found = true;
			}
		}
		if (!found) {
			s.insertRule(selector + '{' + property + ':' + value + ';}', rules.length);
		}
	}

	function ensureHiddenBoron(){
		changeCSS('boron-stylesheet', '#boron-like-box', 'left', -$('.boron-outside').width() - 3 + "px");
		changeCSS('boron-stylesheet', '#boron-like-box', 'bottom', $('.boron-like-box').height() + "px");
	}

	$(document).ready(function () {
		$.ajaxSetup({cache: true});

		setTimeout(function(){
			ensureHiddenBoron();
		});

		setTimeout(function(){
			ensureHiddenBoron();
		}, 100);

		$(window).resize(function () {
			ensureHiddenBoron();
		});
	});
</script>