<script>
	$(document).ready(function(){
		var $toastContent = "{!! $toast !!}";
		Materialize.toast($toastContent, 5000);
	});
</script>
