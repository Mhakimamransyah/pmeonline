@extends('layouts.semantic-ui.dashboard')

@section('style')

    @include('layouts.datatables.css')

@endsection

@section('content')

    <div class="medium-form">

        <div class="medium-form-content">

            <div class="ui clearing segment raised">

                <form class="ui form">

                    <a class="ui green ribbon label ribbon-sub-segment">{{ __('Pencarian') }}</a>

                    <div class="ui field">
                        <label for="input-filter-cycle">{{ __('Siklus') }}</label>
                        <select id="input-filter-cycle" class="ui search fluid dropdown" name="{{ __('cycle_id') }}">
                            <option value="">{{ __('Pilih Siklus') }}</option>
                            @foreach($optionCycles as $cycle)
                                <option value="{{ $cycle->id }}" @if(request('cycle_id') == $cycle->id) selected="" @endif>{{ $cycle->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="ui button blue right floated">
                        <i class="search icon"></i>
                        {{ __('Lihat Daftar Peserta') }}
                    </button>

                </form>

            </div>

        </div>

    </div>

    <div class="medium-form">

        <div class="medium-form-content">

            <div class="ui raised segment">

                <a class="ui green ribbon label ribbon-sub-segment">{{ __('Daftar Peserta') }}</a>

                <form method="post" action="{{ route('administrator.contact-person.login') }}">
                    @csrf

                    <table class="ui striped table data-tables celled">
                        <thead>
                        <tr>
                            <th style="width: 20%">
                                {{ __('Kode Peserta') }}
                            </th>
                            <th style="width: 80%">
                                {{ __('Instansi') }}
                            </th>
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
                    "ajax": "{{ route('administrator.participant.datatable', ['cycle' => request('cycle_id')]) }}",
                    "columnDefs": [
                        {
                            "targets": 0,
                            "className": "center aligned",
                        },
                        {
                            "targets": 1,
                            "render": renderLaboratoryName,
                            "data": null
                        }
                    ],
                });
            }).on('processing.dt', function (e, settings, processing) {
                $('#processingIndicator').css( 'display', processing ? 'block' : 'none' );
            });
            $('#DataTables_Table_0').append('<div id="processingIndicator" class="ui active inverted dimmer">\n' +
                '<div class="ui text loader">{{ __('Sedang memuat ...') }}</div>\n' +
                '</div>')
        });

        function renderLaboratoryName(data, type, row, meta) {
            let url = "{{ route('administrator.laboratory.show') }}" + `?id=${data[2]}`;
            return `<a target="_blank" href="${url}">${data[1]}</a>`;
        }
    </script>

@endsection