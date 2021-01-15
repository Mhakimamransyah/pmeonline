<script>

    $('#input-cycle').on('change', function () {
        let nextUrl = `/{{ request()->route()->uri() }}?cycle_id=${$(this).val()}`;
        console.log(nextUrl);
        window.location.href = nextUrl;
    });

    $('#input-package').on('change', function () {
        let nextUrl = `/{{ request()->route()->uri() }}?cycle_id={{ request()->get('cycle_id') }}&package_id=${$(this).val()}`;
        console.log(nextUrl);
        window.location.href = nextUrl;
    })

</script>