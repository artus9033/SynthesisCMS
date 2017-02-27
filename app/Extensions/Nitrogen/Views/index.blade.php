@php
$slider = $kernel->getSliderItems($slug);
@endphp
@if(strlen($slider))
	<div id="nitrogen-slider" class="carousel carousel-slider center" data-indicators="true">
		{!! $slider !!}
	</div>
	<script>
	$(document).ready(function(){
		$('#nitrogen-slider').carousel({fullWidth: true});
	});
	</script>
@endif
