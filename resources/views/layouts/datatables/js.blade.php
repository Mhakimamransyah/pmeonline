<script src="{{ asset('data-tables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('data-tables/dataTables.semanticui.min.js') }}"></script>

<script>
    $(document).ready( function () {
        $('.data-tables').each(function () {
            $(this).DataTable({
                "language" : {
                    "url" : "{{ asset('data-tables/Indonesian.json') }}"
                },
                pageLength: 300,
                lengthMenu: [[100, 200, 300, 400, 500, -1], [100, 200, 300, 400, 500, "Semua"]],
            });
        });
    } );
</script>