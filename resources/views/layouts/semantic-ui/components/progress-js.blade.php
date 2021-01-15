<script>
    setTimeout(function () {
        $('.in-progress-layout').each(function () {
            $(this).remove();
        });

        $('.loaded-content').each(function () {
            $(this).removeClass('loaded-content');
        });
    }, 1000);
</script>