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
			<span class="right">
				<a class="github-button" href="https://github.com/artus9033" data-size="large"
				   aria-label="Follow @artus9033 on GitHub">Follow @artus9033</a>
				<a class="github-button" href="https://github.com/artus9033/SynthesisCMS" data-icon="octicon-star"
				   data-size="large" aria-label="Star artus9033/SynthesisCMS on GitHub">Star</a>
			</span>
		</div>
	</div>
</footer>
<script async defer src="https://buttons.github.io/buttons.js"></script>