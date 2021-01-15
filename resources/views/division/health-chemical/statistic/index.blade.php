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
                        </tr>
                        <tr>
                            <th>
                                {{ __('Metode Pemeriksaan') }}
                            </th>
                            <th>
                                {{ __('Ketidakpastian') }}
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
                                <td class="yellow">
                                    {{ __($result->value->metode_pemeriksaan ?? '-') }}
                                </td>
                                <td>
                                    {{ __($result->value->ketidakpastian ?? '-') }}
                                </td>
                                <td>
                                    {{ __($result->value->hasil ?? '-') }}
                                </td>
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