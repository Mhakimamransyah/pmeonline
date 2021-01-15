@extends('instalasi.component.template', [
    'title' => 'Lihat Isian peserta'
])

@section('dataTableScript')

    <script>
        $(document).ready(function () {
            $('.data-tables').each(function () {
                $(this).DataTable({
                    "language" : {
                        "url" : "{{ asset('data-tables/Indonesian.json') }}"
                    },
                    "serverSide": true,
                    "processing": false,
                    "pageLength": 50,
                    "ajax": `{{ route('installation.submit.datatable') }}?package_id={{ request()->get('package_id') }}`,
                    "columnDefs": [
                        {
                            "targets": [0, 2],
                            "className": "center aligned",
                        },
                        {
                            "targets": -1,
                            "render": renderOpenCell,
                            "data": null,
                            "className": "selectable center aligned"
                        },
                    ],
                    "createdRow": function (row, data, dataIndex) {
                        $(row).addClass(data[5]);
                    }
                });
            }).on('processing.dt', function (e, settings, processing) {
                $('#processingIndicator').css( 'display', processing ? 'block' : 'none' );
            });
            $('#DataTables_Table_0').append('<div id="processingIndicator" class="ui active inverted dimmer">\n' +
                '<div class="ui text loader">{{ __('Sedang memuat ...') }}</div>\n' +
                '</div>');
        });

        function renderOpenCell(data, type, row, meta) {
            let url = "{{ route('installation.submit.show') }}" + `?order_id=${data[4]}`;
            return `<a target="_blank" href="${url}"><i class="search icon"></i></a>`;
        }
    </script>

@endsection
