<div id="nitrogen-slider" class="carousel carousel-slider center" data-indicators="true">
	{!! $kernel->getSliderItems($slug) !!}
</div>
<script>
$(document).ready(function(){
	$('#nitrogen-slider').carousel({fullWidth: true});
});
</script>
