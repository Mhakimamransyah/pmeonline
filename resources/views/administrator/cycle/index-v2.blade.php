@extends('layouts.semantic-ui.dashboard')

@section('style')

    @include('layouts.moment-js.css')
    @include('layouts.datatables.css')

    <style>
        .cycle-info {
            margin-top: 6px !important;
        }
    </style>

@endsection

@section('content')

    <div class="medium-form">

        <div class="medium-form-content">

            <div class="ui breadcrumb">
                <div class="active section"><i class="recycle icon"></i>{{ __('Siklus') }}</div>
            </div>

            <div class="ui segments">

                <div class="ui segment">

                    <a class="ui green ribbon label ribbon-sub-segment">{{ __('Siklus') }}</a>

                    <table class="ui striped table" id="cycle-data-tables">
                        <thead>
                        <tr>
                            <th class="ui center aligned" width="5%">
                                {{ __('#') }}
                            </th>
                            <th>
                                {{ __('Siklus') }}
                            </th>
                            <th style="width: 15%">
                                {{ __('Jumlah Pendaftar') }}
                            </th>
                            <th style="width: 15%">
                                {{ __('Jumlah Peserta') }}
                            </th>
                        </tr>
                        </thead>
                    </table>

                </div>

                <div class="ui clearing segment">

                    <a class="ui button blue right floated" onclick="showCreateCycleModal()">
                        <i class="plus icon"></i>
                        {{ __('Buat Siklus Baru') }}
                    </a>

                </div>

            </div>

        </div>

    </div>

    <div class="ui modal" id="create-cycle-modal">

        <div class="header">{{ __('Buat Siklus Baru') }}</div>

        <div class="content">

            <form id="create-option-form" class="ui form" method="post" action="{{ route('administrator.cycle.create') }}">

                @include('administrator.cycle.create.form')

            </form>

        </div>

        <div class="actions">

            <button class="ui positive right labeled icon button" type="submit" form="create-option-form">
                {{ __('Simpan') }}
                <i class="check icon"></i>
            </button>

        </div>

    </div>

@endsection

@section('script')

    @include('layouts.moment-js.js')
    @include('layouts.datatables.js')

    <script>
        function showCreateCycleModal() {
            $('#create-cycle-modal')
                .modal({
                    onApprove: function () {
                        return false;
                    }
                })
                .modal('show')
            ;
        }

        function setupCycleNameCell(td, cellData, rowData, row, col) {
            let html = '<a href="/administrator/cycle/item?id=' + rowData.id + '">' + rowData.cycle_name + '</a><br/><div class="ui labels">';
            if (rowData.has_done) {
                html += '<a class="ui purple label cycle-info">Sudah Selesai</a>';
            }
            if (rowData.has_not_started) {
                html += '<a class="ui green label cycle-info">Belum Dimulai</a>';
            }
            if (rowData.is_open_registration) {
                html += '<a class="ui blue label cycle-info">Pendaftaran Dibuka</a>';
            }
            if (rowData.is_open_submit) {
                html += '<a class="ui blue label cycle-info">Pengisian Laporan Dibuka</a>';
            }
            html += '</div>';
            $(td).html(html);
        }

        function setupCycleRegisteredCountCell(td, cellData, rowData, row, col) {
            if (rowData.id === 1) {
                $(td).html('<a href="/administrator/cycle/' + rowData.id + '/registered">' + 238  + '</a> Pendaftar');
                return;
            }
            $(td).html('<a href="/administrator/cycle/' + rowData.id + '/registered">' + rowData.register_count  + '</a> Pendaftar');
        }

        function setupCycleParticipantCountCell(td, cellData, rowData, row, col) {
            if (rowData.id === 1) {
                $(td).html('<a href="/administrator/cycle/' + rowData.id + '/registered">' + 238  + '</a> Peserta');
                return;
            }
            $(td).html('<a href="/administrator/cycle/' + rowData.id + '/participant">' + rowData.participant_count  + '</a> Peserta');
        }

        $(document).ready(function () {
            $table = $('#cycle-data-tables');
            $table.DataTable( {
                "language" : {
                    "url" : "{{ asset('data-tables/Indonesian.json') }}"
                },
                "processing": false,
                "serverSide": true,
                "ajax": "{{ route('administrator.cycle.v5.index-data-tables') }}",
                "columns": [
                    { data: "id", className: "center aligned" },
                    { data: "cycle_name", createdCell: setupCycleNameCell, },
                    { data: "register_count", className: "right aligned", createdCell: setupCycleRegisteredCountCell, },
                    { data: "participant_count", className: "right aligned", createdCell: setupCycleParticipantCountCell, },
                ]
            }).on('processing.dt', function (e, settings, processing) {
                $('#processingIndicator').css( 'display', processing ? 'block' : 'none' );
            });
            $table.append('<div id="processingIndicator" class="ui active inverted dimmer">\n' +
                '<div class="ui text loader">{{ __('Sedang memuat ...') }}</div>\n' +
                '</div>');
        });
    </script>

@endsection