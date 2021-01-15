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
                                <th rowspan="2">
                                    {{ __('Metode') }}
                                </th>
                                <th rowspan="2">
                                    {{ __('Reagen') }}
                                </th>
                                <th rowspan="2">
                                    {{ __('Produsen') }}
                                </th>
                                <th rowspan="2">
                                    {{ __('Lot / Batch') }}
                                </th>
                                @for($sediaan = 1; $sediaan <= 3; $sediaan++)
                                    <th colspan="3" class="center aligned">
                                        {{ 'Sediaan ' . $sediaan }}
                                    </th>
                                @endfor
                            </tr>
                            <tr>
                                @for($sediaan = 1; $sediaan <= 3; $sediaan++)
                                    <th>
                                        {{ __('Kode Panel') }}
                                    </th>
                                    <th>
                                        {{ __('Hasil Semi Kuantitatif') }}
                                    </th>
                                    <th>
                                        {{ __('Titer') }}
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
                                    <td>
                                        {{ __($result->value->metode ?? '-') }}
                                    </td>
                                    <td>
                                        {{ __($result->value->reagen ?? '-') }}
                                    </td>
                                    <td>
                                        {{ __($result->value->produsen ?? '-') }}
                                    </td>
                                    <td>
                                        {{ __($result->value->batch ?? '-') }}
                                    </td>
                                    @for($sediaanId = 0; $sediaanId < 3; $sediaanId++)
                                        <td class="yellow">
                                            {{ __($result->value->{'sediaan_'.$sediaanId}->kode ?? 'N/A') }}
                                        </td>
                                        <td>
                                            {{ __($result->value->{'sediaan_'.$sediaanId}->hasil_semi_kuantitatif ?? 'N/A') }}
                                        </td>
                                        <td>
                                            {{ __($result->value->{'sediaan_'.$sediaanId}->titer ?? 'N/A') }}
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