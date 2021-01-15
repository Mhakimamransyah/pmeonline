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

                        <table class="ui striped table celled">
                            <thead>
                            <tr>
                                <th class="ui center aligned" width="5%" rowspan="3">
                                    {{ __('#') }}
                                </th>
                                <th rowspan="3">
                                    {{ __('Nama Laboratorium / Instansi') }}
                                </th>
                                <th rowspan="2" colspan="3" class="center aligned">
                                    {{ __('Reagen') }}
                                </th>
                                <th rowspan="2" colspan="3" class="center aligned">
                                    {{ __('Batch') }}
                                </th>
                                @for($sediaan = 1; $sediaan <= 3; $sediaan++)
                                    <th colspan="13" class="center aligned">
                                        {{ 'Panel ' . $sediaan }}
                                    </th>
                                @endfor
                            </tr>
                            <tr>
                                @for($sediaan = 1; $sediaan <= 3; $sediaan++)
                                    <th></th>
                                    @for($tes = 1; $tes <= 3; $tes++)
                                        <th colspan="4" class="center aligned">
                                            {{ 'Tes ' . $tes }}
                                        </th>
                                    @endfor
                                @endfor
                            </tr>
                            <tr>
                                @for($tes = 1; $tes <= 3; $tes++)
                                    <th class="center aligned">
                                        {{ 'Tes ' . $tes }}
                                    </th>
                                @endfor
                                @for($tes = 1; $tes <= 3; $tes++)
                                    <th class="center aligned">
                                        {{ 'Tes ' . $tes }}
                                    </th>
                                @endfor
                                @for($sediaan = 1; $sediaan <= 3; $sediaan++)
                                    <th class="center aligned">
                                        {{ 'Kode Panel' }}
                                    </th>
                                    @for($tes = 1; $tes <= 3; $tes++)
                                        <th class="center aligned">
                                            {{ 'Abs' }}
                                        </th>
                                        <th class="center aligned">
                                            {{ 'Cut' }}
                                        </th>
                                        <th class="center aligned">
                                            {{ 'Sco' }}
                                        </th>
                                        <th class="center aligned">
                                            {{ 'Hasil' }}
                                        </th>
                                    @endfor
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
                                    @for($tes = 1; $tes <= 3; $tes++)
                                        <td class="center aligned">
                                            {{ $result->value->reagen->{'tes_'.$tes} ?? 'N/A' }}
                                        </td>
                                    @endfor
                                    @for($tes = 1; $tes <= 3; $tes++)
                                        <td class="center aligned">
                                            {{ $result->value->batch->{'tes_'.$tes} ?? 'N/A' }}
                                        </td>
                                    @endfor
                                    @for($sediaan = 0; $sediaan <= 2; $sediaan++)
                                        <td>
                                            {{ __($result->value->{'sediaan_'.$sediaan}->kode ?? 'N/A') }}
                                        </td>
                                        @for($tes = 1; $tes <= 3; $tes++)
                                            <td>
                                                {{ __($result->value->{'sediaan_'.$sediaan}->{'tes_'.$tes}->abs ?? 'N/A') }}
                                            </td>
                                            <td>
                                                {{ __($result->value->{'sediaan_'.$sediaan}->{'tes_'.$tes}->cut ?? 'N/A') }}
                                            </td>
                                            <td>
                                                {{ __($result->value->{'sediaan_'.$sediaan}->{'tes_'.$tes}->sco ?? 'N/A') }}
                                            </td>
                                            <td>
                                                {{ __($result->value->{'sediaan_'.$sediaan}->{'tes_'.$tes}->hasil ?? 'N/A') }}
                                            </td>
                                        @endfor
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