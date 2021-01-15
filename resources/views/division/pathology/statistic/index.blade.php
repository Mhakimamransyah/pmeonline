@extends('layouts.semantic-ui.dashboard')

@section('style')

@endsection

@section('content')

    <div class="medium-form">

        <div class="medium-form-content">

            @include('layouts.dashboard.legacy-error')

            <div class="ui segments">

                <div class="ui segment">

                    <a class="ui green ribbon label ribbon-sub-segment">{{ __('Daftar Peserta Parameter ' . $parameter->label) }}</a>

                    <table class="ui striped table">
                        <thead>
                        <tr>
                            <th class="ui center aligned" width="5%" rowspan="2">
                                {{ __('#') }}
                            </th>
                            <th rowspan="2">
                                {{ __('Nama Laboratorium / Instansi') }}
                            </th>
                            <th colspan="5" class="center aligned">
                                {{ 'Botol 1' }}
                            </th>
                            <th colspan="5" class="center aligned">
                                {{ 'Botol 2' }}
                            </th>
                        </tr>
                        <tr>
                            <th>
                                {{ __('Metode Pemeriksaan') }}
                            </th>
                            <th>
                                {{ __('Kode Alat') }}
                            </th>
                            <th>
                                {{ __('Kode Reagen') }}
                            </th>
                            <th>
                                {{ __('Kode Kualifikasi Pemeriksa') }}
                            </th>
                            <th>
                                {{ __('Hasil') }}
                            </th>
                            <th>
                                {{ __('Metode Pemeriksaan') }}
                            </th>
                            <th>
                                {{ __('Kode Alat') }}
                            </th>
                            <th>
                                {{ __('Kode Reagen') }}
                            </th>
                            <th>
                                {{ __('Kode Kualifikasi Pemeriksa') }}
                            </th>
                            <th>
                                {{ __('Hasil') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($count = 0)
                        @foreach($results as $result)
                            @php($count++)
                            <tr>
                                <td class="center aligned">
                                    {{ $count }}
                                </td>
                                <td>
                                    {{ __($result->order->invoice->laboratory->name) }}
                                </td>
                                @for($bottle = 1; $bottle <= 2; $bottle++)
                                <td class="yellow">
                                    {{ __($result->value->{'bottle_'.$bottle}->metode_pemeriksaan ?? 'N/A') }}
                                </td>
                                <td>
                                    {{ __($result->value->{'bottle_'.$bottle}->alat ?? 'N/A') }}
                                </td>
                                <td>
                                    {{ __($result->value->{'bottle_'.$bottle}->reagen ?? 'N/A') }}
                                </td>
                                <td>
                                    {{ __($result->value->{'bottle_'.$bottle}->kualifikasi_pemeriksa ?? 'N/A') }}
                                </td>
                                <td>
                                    {{ __($result->value->{'bottle_'.$bottle}->hasil ?? 'N/A') }}
                                </td>
                                @endfor
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

        </div>

    </div>

@endsection

@section('script')

@endsection