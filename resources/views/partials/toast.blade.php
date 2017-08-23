<script>
    $(document).ready(function () {
        setTimeout(function () {
            var $toastContent = "{!! $toast !!}";
            SynthesisCmsJsUtils.showToast($toastContent, 6000);
        }, 500);
    });
</script>
