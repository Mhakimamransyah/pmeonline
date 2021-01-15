@extends('layouts.semantic-ui.dashboard')

@section('content')

    <div class="medium-form">

        <div class="medium-form-content">

            <div class="ui raised green clearing segment">

                <a class="ui green ribbon label">{{ 'Sertifikat' }}</a>

                @component('administrator.component.select-package')
                @endcomponent

                @if(request()->has('package_id'))
                    <div class="ui section divider"></div>

                    <table class="table celled ui data-tables">
                        <thead>
                        <tr>
                            <th style="width: 10%"></th>
                            <th style="width: 30%">{{ 'Provinsi' }}</th>
                            <th style="width: 15%">{{ 'Kode Peserta' }}</th>
                            <th style="width: 45%">{{ 'Laboratorium' }}</th>
                            <th></th>
                        </tr>
                        </thead>
                    </table>
                @endif

            </div>

        </div>

    </div>

@endsection


@section('script')

    @component('administrator.component.select-package-js')
    @endcomponent

    <script src="{{ asset('data-tables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('data-tables/dataTables.semanticui.min.js') }}"></script>

    @if(request()->has('package_id'))
        <script>
            $(document).ready(function () {
                $('.data-tables').each(function () {
                    $(this).DataTable({
                        "language" : {
                            "url" : "{{ asset('data-tables/Indonesian.json') }}"
                        },
                        "serverSide": true,
                        "processing": false,
                        "pageLength": 300,
                        "lengthMenu": [[100, 200, 300, 400, 500, -1], [100, 200, 300, 400, 500, "Semua"]],
                        "ajax": `{{ route('administrator.certificate.datatable') }}?package_id={{ request()->get('package_id') }}`,
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
                let url = "{{ route('administrator.certificate.show') }}" + `?order_id=${data[4]}`;
                return `<a target="_blank" href="${url}"><i class="search icon"></i></a>`;
            }
        </script>
    @endif

@endsection