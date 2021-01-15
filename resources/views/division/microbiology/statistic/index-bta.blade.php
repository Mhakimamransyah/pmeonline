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

                    <div style="overflow-x: scroll;">

                        <table class="ui striped table">
                            <thead>
                            <tr>
                                <th class="ui center aligned" width="5%" rowspan="2">
                                    {{ __('#') }}
                                </th>
                                <th rowspan="2">
                                    {{ __('Nama Laboratorium / Instansi') }}
                                </th>
                                @for($sediaan = 1; $sediaan <= 10; $sediaan++)
                                <th colspan="2" class="center aligned">
                                    {{ 'Sediaan ' . $sediaan }}
                                </th>
                                @endfor
                            </tr>
                            <tr>
                                @for($sediaan = 1; $sediaan <= 10; $sediaan++)
                                <th>
                                    {{ __('Kode') }}
                                </th>
                                <th>
                                    {{ __('Hasil') }}
                                </th>
                                @endfor
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
                                    @for($sediaanId = 0; $sediaanId < 10; $sediaanId++)
                                    <td class="yellow">
                                        {{ __($result->value->{'sediaan_'.$sediaanId}->kode ?? 'N/A') }}
                                    </td>
                                    <td>
                                        {{ __($result->value->{'sediaan_'.$sediaanId}->hasil ?? 'N/A') }}
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

    </div>

@endsection

@section('script')

@endsection