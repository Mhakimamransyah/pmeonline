@php

    $parameterName = 'Malaria';

    $submitValue = json_decode($submit->value);

    $score = $submit->order->score;

    $scoreValue = json_decode($score->value);

    $package = $submit->order->package;
    $parameters = $package->parameters;
    $cycle = $package->cycle;

    $scores = [];

@endphp

<h3 class="text-center"><b>PROGRAM NASIONAL PEMANTAPAN MUTU EKSTERNAL BIDANG MIKROBIOLOGI<br/>
        HASIL EVALUASI PARAMETER {{ strtoupper($parameterName) }}<br/>
        {{ strtoupper($cycle->name) }}</b>
</h3>

<br/>

@component('score.identity-header', [
    'submit' => $submit,
])
@endcomponent

<br/>

<table class="table table-bordered">

    <thead>
    <tr>
        <th class="text-center">{{ 'Kode Sediaan' }}</th>
        <th class="text-center">{{ 'Hasil Pemeriksaan oleh Laboratorium Peserta' }}</th>
        <th class="text-center" style="width: 120px">{{ 'Hasil Kepatadatan Parasit oleh Laboratorium Peserta' }}</th>
        <th class="text-center">{{ 'Hasil Pemeriksaan yang Seharusnya' }}</th>
        <th class="text-center" style="width: 120px">{{ 'Hasil Kepatadatan Parasit yang Seharusnya' }}</th>
        <th class="text-center">{{ 'Skor' }}</th>
    </tr>
    </thead>

    <tbody>
    @for ($i = 0; $i < 10; $i++)

        <tr>

            <td class="text-center">{{ $submitValue->{'kode_'.$i} }}</td>

            <td class="text-center">

                @php
                    $answer = isset($submitValue->{'hasil_'.$i}) ? $submitValue->{'hasil_'.$i} : array();
                    $answerJumlahMalaria = isset($submitValue->{'jumlah_malaria_'.$i}) ? $submitValue->{'jumlah_malaria_'.$i} : 0;

                    $answerPlasmodiums = [];
                    $answerStadiums = [];
                @endphp

                @if(count($answer) > 0)
                    @if($answer == ["Negatif"])
                        {{ implode(', ', $answer) }}
                    @else
                        @php
                            foreach ($answer as $item) {
                                array_push($answerPlasmodiums, explode(" ",$item)[1]);
                                $answerStadium = explode(" ",$item)[3];
                                if ($answerStadium == "Skizon") {
                                    $answerStadium = "Schizont";
                                }
                                array_push($answerStadiums, $answerStadium);
                            }
                            $answerPlasmodiums = array_unique($answerPlasmodiums);
                            $answerStadiums = array_unique($answerStadiums);
                        @endphp
                        {{ __('Positif') }}<br/>
                        <b>{{ __('Plasmodium : ')  }}</b>{{ implode(', ', $answerPlasmodiums) }}<br/>
                        <b>{{ __('Stadium : ') }}</b>{{ implode(', ', $answerStadiums) }}
                    @endif
                @else
                    <i>Tidak diisi</i>
                @endif

            </td>

            <td class="text-center">
                {!! number_format($answerJumlahMalaria, 0, ",", ".") !!}
            </td>

            <td class="text-center">

                @php
                    $expected = isset($scoreValue->{'hasil_'.$i}) ? $scoreValue->{'hasil_'.$i} : array();
                    $expectedJumlahMalaria = isset($scoreValue->{'jumlah_malaria_'.$i}) ? $scoreValue->{'jumlah_malaria_'.$i} : 0;

                    $expectedPlasmodiums = [];
                    $expectedStadiums = [];
                    $duaPuluhLimaPersen = $expectedJumlahMalaria / 4;
                    $minJumlahMalaria = $expectedJumlahMalaria - $duaPuluhLimaPersen;
                    $maxJumlahMalaria = $expectedJumlahMalaria + $duaPuluhLimaPersen;
                @endphp

                @if(count($expected) > 0)
                    @if($expected == ["Negatif"])
                        {{ implode(', ', $expected) }}
                    @else
                        @php
                            foreach ($expected as $item) {
                                array_push($expectedPlasmodiums, explode(" ",$item)[1]);
                                array_push($expectedStadiums, explode(" ",$item)[3]);
                            }
                            $expectedPlasmodiums = array_unique($expectedPlasmodiums);
                            $expectedStadiums = array_unique($expectedStadiums);
                        @endphp
                        {{ __('Positif') }}<br/>
                        <b>{{ __('Plasmodium : ')  }}</b>{{ implode(', ', $expectedPlasmodiums) }}<br/>
                        <b>{{ __('Stadium : ') }}</b>{{ implode(', ', $expectedStadiums) }}
                    @endif
                @else
                    <i>Tidak diisi</i>
                @endif

            </td>

            <td class="text-center">

                @if ($expectedJumlahMalaria == 0)

                    {{ '0' }}

                @else

                    @php

                    @endphp
                    {!! number_format($minJumlahMalaria, 0, ",", ".") !!} - {{ number_format(($maxJumlahMalaria), 0, ",", ".") }}

                @endif

            </td>

            <td class="text-center">

                @php
                    $currentScore = 0;
                    if (count($expected) == 1 && $expected[0] == 'Negatif') {
                        if (count($answer) == 1 && $answer[0] == 'Negatif') {
                            $currentScore = 10;
                        } else {
                            $currentScore = 0;
                        }
                    } else {
                        sort($answerPlasmodiums);
                        sort($expectedPlasmodiums);
                        sort($answerStadiums);
                        sort($expectedStadiums);
                        if ($answerPlasmodiums == $expectedPlasmodiums && $answerStadiums == $expectedStadiums && $answerJumlahMalaria >= $minJumlahMalaria && $answerJumlahMalaria <= $maxJumlahMalaria) {
                            $currentScore = 10;
                        } elseif ($answerPlasmodiums == $expectedPlasmodiums && $answerStadiums == $expectedStadiums) {
                            $currentScore = 8;
                        } elseif ($answerPlasmodiums == $expectedPlasmodiums && count(array_intersect($answerStadiums, $expectedStadiums)) > 0 && $answerJumlahMalaria >= $minJumlahMalaria && $answerJumlahMalaria <= $maxJumlahMalaria) {
                            $currentScore = 8;
                        } elseif ($answerPlasmodiums == $expectedPlasmodiums && count(array_intersect($answerStadiums, $expectedStadiums)) > 0) {
                            $currentScore = 6;
                        } elseif (count(array_intersect($answerStadiums, $expectedStadiums)) > 0 && $answerJumlahMalaria >= $minJumlahMalaria && $answerJumlahMalaria <= $maxJumlahMalaria) {
                            $currentScore = 5;
                        } elseif (count($answer) == 1 && $answer[0] == 'Negatif') {
                            $currentScore = 0;
                        } else {
                            $currentScore = 3;
                        }
                    }

                    array_push($scores, $currentScore);
                @endphp

                {{ $currentScore }}

            </td>

        </tr>

    @endfor
    </tbody>
    <tfoot>
    <tr>
        <th colspan="5" class="text-center">{{ 'Total' }}</th>
        @php
            $avg = array_sum($scores);
        @endphp
        <th class="text-center">{{ $avg }}</th>
    </tr>
    </tfoot>

</table>

<br/>
<br/>

<table class="table table-bordered">
    <thead>
    <tr>
        <th class="text-center">{{ 'Total Skor' }}</th>
        <th class="text-center">{{ 'Kriteria' }}</th>
        <th class="text-center" width="60%">{{ 'Komentar atau Saran' }}</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="text-center">&ge;90</td>
        <td class="text-center">Sempurna</td>
        <td rowspan="4">
            Hasil PME parameter mikroskopis malaria laboratorium saudara masuk dalam skor rata-rata dengan kriteria <b>@if($avg >= 90) Sempurna @elseif($avg >= 80) Sangat Baik @elseif($avg >= 70) Baik @else Buruk @endif</b>.
            {{ $scoreValue->saran ?? '' }}
        </td>
    </tr>
    <tr>
        <td class="text-center">80 -&lt; 90</td>
        <td class="text-center">Sangat Baik</td>
    </tr>
    <tr>
        <td class="text-center">70 -&lt; 80</td>
        <td class="text-center">Baik</td>
    </tr>
    <tr>
        <td class="text-center">&lt;70</td>
        <td class="text-center">Buruk</td>
    </tr>
    </tbody>
</table>

<br/>
<br/>

@component('score.signature', [
    'submit' => $submit
])
@endcomponent