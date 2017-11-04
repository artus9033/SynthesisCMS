<footer class="no-print page-footer {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12">
	<div class="container">
		<div class="row">
			<div class="col l6 s12">
				<h5 class="white-text">{{ $synthesiscmsFooterHeader }}</h5>
				<p class="grey-text text-lighten-4">{{ $synthesiscmsFooterContent }}</p>
			</div>
			<div class="col l4 offset-l2 s12">
				<h5 class="white-text">{{ $synthesiscmsFooterLinksText }}</h5>
				{!! $synthesiscmsFooterLinksContent !!}
			</div>
		</div>
	</div>
	{!! $synthesiscmsPositionManager->getStandard(App\SynthesisCMS\API\Positions\SynthesisPositions::FooterContent, Request::url()) !!}
	<div class="footer-copyright">
		<div class="container">
			<span>&copy;&nbsp;@php echo(date('Y')); @endphp
				&nbsp;{{ $synthesiscmsFooterCopyright }}</span>
			<a class="grey-text text-lighten-4 right valign-wrapper"
			   href="{{ $synthesiscmsFooterMoreLinksBottomHref }}"><i
						class="material-icons">open_in_new</i>&nbsp;{{ $synthesiscmsFooterMoreLinksBottomText }}
			</a>
		</div>
	</div>
	<div class="footer-copyright">
		<div class="container">
			<span class="grey-text text-lighten-4">
				{!! trans('synthesiscms/main.footer_powered_by') !!}
				<a style="text-decoration: underline;" class="grey-text text-lighten-4"
				   href="https://github.com/artus9033/SynthesisCMS">
					SynthesisCMS
				</a>
				{!! trans('synthesiscms/main.footer_description') !!}
				<a style="text-decoration: underline;" class="grey-text text-lighten-4"
				   href="https://github.com/artus9033">
					artus9033
				</a>
			</span>
			<div class="right">
				<!-- NOTE: substituted with hard-coded iframes
				<a style="width: 61px; height: 28px; border: none;" class="github-button" href="https://github.com/artus9033" data-size="large"
				   aria-label="Follow @artus9033 on GitHub">Follow @artus9033</a>
				<a style="width: 61px; height: 28px; border: none;" class="github-button" href="https://github.com/artus9033/SynthesisCMS" data-icon="octicon-star"
				   data-size="large" aria-label="Star artus9033/SynthesisCMS on GitHub">Star</a> -->
			<span class="right">
				<iframe allowtransparency="true" scrolling="no" frameborder="0" src="https://buttons.github.io/buttons.html#href=https%3A%2F%2Fgithub.com%2Fartus9033&amp;aria-label=Follow%20%40artus9033%20%20on%20GitHub&amp;data-text=Follow%20%40artus9033&amp;data-size=large" style="width: 147px; height: 28px; border: none;"></iframe>
				<iframe allowtransparency="true" scrolling="no" frameborder="0" src="https://buttons.github.io/buttons.html#href=https%3A%2F%2Fgithub.com%2Fartus9033%2FSynthesisCMS&amp;aria-label=Star%20artus9033%2FSynthesisCMS%20on%20GitHub&amp;data-icon=octicon-star&amp;data-text=Star&amp;data-size=large" style="width: 61px; height: 28px; border: none;"></iframe>
			</span>
			</div>
		</div>
	</div>
</footer>
<!-- NOTE: substituted with hard-coded iframes
<script async defer src="https://buttons.github.io/buttons.js"></script>-->