@extends('layouts.semantic-ui.dashboard')

@section('style')

    @include('layouts.datatables.css')

@endsection

@section('content')

    <div class="medium-form">

        <div class="medium-form-content">

            <div class="ui raised segment">

                <a class="ui green ribbon label ribbon-sub-segment">{{ __('Personil Penghubung') }}</a>

                <form method="post" action="{{ route('administrator.contact-person.login') }}">
                    @csrf

                    <table class="ui striped table data-tables celled">
                        <thead>
                        <tr>
                            <th style="width: 5%">
                                {{ __('#') }}
                            </th>
                            <th style="width: 40%">
                                {{ __('Nama') }}
                            </th>
                            <th style="width: 25%">
                                {{ __('Email') }}
                            </th>
                            <th style="width: 25%">
                                {{ __('Nomor Telepon') }}
                            </th>
                            <th style="width: 5%;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </form>

            </div>

        </div>

    </div>

@endsection

@section('script')

    <script src="{{ asset('data-tables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('data-tables/dataTables.semanticui.min.js') }}"></script>

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
                    "ajax": "{{ route('administrator.contact-person.datatable') }}",
                    "columnDefs": [
                        {
                            "targets": 0,
                            "className": "selectable center aligned",
                        },
                        {
                            "targets": -1,
                            "data": null,
                            "render": renderOpenAsCell,
                            "className": "selectable center aligned"
                        },
                    ],
                });
            }).on('processing.dt', function (e, settings, processing) {
                $('#processingIndicator').css( 'display', processing ? 'block' : 'none' );
            });
            $('#DataTables_Table_0').append('<div id="processingIndicator" class="ui active inverted dimmer">\n' +
                '<div class="ui text loader">{{ __('Sedang memuat ...') }}</div>\n' +
                '</div>');
        });
        
        function renderOpenAsCell(data, type, row, meta) {
            return "<button style=\"margin-right: 0\" type=\"submit\" class=\"ui icon button\" name=\"user_id\" value=\"" + data[0] + "\" data-tooltip=\"{{ __('Masuk sebagai ') }}" + data[1] + "\"><i class=\"key icon\"'></i></button>"
        }
    </script>

@endsection