<script>
    $(document).ready(function () {
        setTimeout(function () {
            var $toastContent = "{!! $toast !!}";
            Materialize.toast($toastContent, 6000);
        }, 500);
    });
</script>
