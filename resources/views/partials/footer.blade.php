<footer class="page-footer col s12">
	<div class="container">
		<div class="row">
			<div class="col l6 s12">
				<h5 class="white-text">{{ \App\Models\Settings\Settings::getFromActive('footer_header') }}</h5>
				<p class="grey-text text-lighten-4">{{ \App\Models\Settings\Settings::getFromActive('footer_content') }}</p>
			</div>
			<div class="col l4 offset-l2 s12">
				<h5 class="white-text">{{ \App\Models\Settings\Settings::getFromActive('footer_links_text') }}</h5>
				{!! \App\Models\Settings\Settings::getFromActive('footer_links_content') !!}
			</div>
		</div>
	</div>
	<div class="footer-copyright">
		<div class="container">
			<span>&copy;&nbsp;@php echo(date('Y')); @endphp&nbsp;{{ \App\Models\Settings\Settings::getFromActive('footer_copyright') }}</span>
			<a class="grey-text text-lighten-4 right" href="{{ \App\Models\Settings\Settings::getFromActive('footer_more_links_bottom_href') }}">{{ \App\Models\Settings\Settings::getFromActive('footer_more_links_bottom_text') }}</a>
		</div>
	</div>
</footer>
