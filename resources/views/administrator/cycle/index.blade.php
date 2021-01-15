@extends('layouts.semantic-ui.dashboard')

@section('style')

    @include('layouts.moment-js.css')
    @include('layouts.datatables.css')

    <style>
        td.registered-counter:after, td.participant-counter:after {
            margin-left: 6px;
        }
        td.registered-counter:after {
            content: 'Pendaftar';
        }
        td.participant-counter:after {
            content: 'Peserta';
        }
        .cycle-info {
            margin-top: 6px !important;
        }
        .hide-on-loading {
            visibility: hidden;
        }
    </style>

@endsection

@section('content')

    @include('layouts.semantic-ui.components.progress-html-custom')

    <div class="medium-form hide-on-loading">

        <div class="medium-form-content">

            <div class="ui breadcrumb">
                <div class="active section"><i class="recycle icon"></i>{{ __('Siklus') }}</div>
            </div>

            @include('layouts.dashboard.legacy-error')

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
                            <th width="15%">
                                {{ __('Jumlah Pendaftar') }}
                            </th>
                            <th width="15%">
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

        $.get('{{ route('administrator.cycle.index.data') }}', function(data, status) {
            $('#cycle-data-tables').DataTable({
                "language" : {
                    "url" : "{{ asset('data-tables/Indonesian.json') }}"
                },
                "pageLength": 50,
                "ordering": false,
                "data": data,
                "columns": [
                    {
                        "class": "ui center aligned",
                        "data": "id",
                    },
                    {
                        "data": "name",
                        "createdCell": setupCycleNameCell,
                    },
                    {
                        "class": "registered-counter right aligned",
                        "data": "laboratories_count",
                        "createdCell": setupCycleRegisteredCountCell,
                    },
                    {
                        "class": "participant-counter right aligned",
                        "data": "participants_count",
                        "createdCell": setupCycleParticipantCountCell,
                    },
                ],
            });
            $('.custom-progress-layout').each(function () {
                $(this).remove();
            });
            $('.hide-on-loading').each(function () {
                $(this).removeClass('hide-on-loading');
            });
        });

        function setupCycleNameCell(td, cellData, rowData, row, col) {
            let html = '<a href="/administrator/cycle/item?id=' + rowData.id + '">' + rowData.name + '</a><br/><div class="ui labels">';
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
            if (rowData.errors.length > 0) {
                tooltip = 'Terdapat ' + rowData.errors.length + ' kesalahan dalam siklus ' + rowData.name;
                html += '<a class="ui red label cycle-info" data-tooltip="' + tooltip + '"><i class="exclamation triangle icon"></i>' + rowData.errors.length + '</a>';
            }
            html += '</div>';
            $(td).html(html);
        }

        function setupCycleRegisteredCountCell(td, cellData, rowData, row, col) {
            if (rowData.id === 1) {
                $(td).html('<a href="/administrator/cycle/' + rowData.id + '/registered">' + 238  + '</a>');
                return;
            }
            $(td).html('<a href="/administrator/cycle/' + rowData.id + '/registered">' + rowData.laboratories_count  + '</a>');
        }

        function setupCycleParticipantCountCell(td, cellData, rowData, row, col) {
            if (rowData.id === 1) {
                $(td).html('<a href="/administrator/cycle/' + rowData.id + '/registered">' + 238  + '</a>');
                return;
            }
            $(td).html('<a href="/administrator/cycle/' + rowData.id + '/participant">' + rowData.participants_count  + '</a>');
        }
    </script>

@endsection