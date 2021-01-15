@php

    $parameterName = 'Telur Cacing';

    $submitValue = json_decode($submit->value);

    $score = $submit->order->score;

    $scoreValue = json_decode($score->value);

    $scores = [];

@endphp

<h3 class="text-center"><b>PROGRAM NASIONAL PEMANTAPAN MUTU EKSTERNAL BIDANG MIKROBIOLOGI<br/>
        HASIL EVALUASI PARAMETER {{ strtoupper($parameterName) }}<br/>
        SIKLUS II - TAHUN 2019</b>
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
        <th class="text-center" style="width: 10%">{{ 'Kode Sample' }}</th>
        <th class="text-center" style="width: 40%">{{ 'Hasil Pemeriksaan oleh Lab. Peserta' }}</th>
        <th class="text-center" style="width: 40%">{{ 'Hasil Pemeriksaan Seharusnya' }}</th>
        <th class="text-center" style="width: 10%">{{ 'Skor' }}</th>
    </tr>
    </thead>
    <tbody>
    @for ($i = 0; $i < 3; $i++)
        <tr>

            @php
                $answers = $submitValue->{'hasil_'.$i};
                $countAnswers = count($answers);

                $expected = $scoreValue->{'hasil_'.$i};
                $countExpected = count($expected);

                $intersect = array_intersect($answers, $expected);
                $countIntersect = count($intersect);

                $score = 10 * $countIntersect / $countExpected;

                array_push($scores, $score);
            @endphp

            <td class="text-center">{{ $submitValue->{'kode_sediaan_'.$i} }}</td>

            <td class="text-center">{{ implode($answers, ', ') }}</td>

            <td class="text-center">{{ implode($expected, ', ') }}</td>

            <td class="text-center">{{ number_format($score, 0) }}</td>
        </tr>
    @endfor
    </tbody>
    <tfoot>
    <tr>
        @php
            $avg = array_sum($scores) / count($scores);
        @endphp
        <th class="text-center" colspan="3">{{ 'Skor Rata-Rata' }}</th>
        <th class="text-center">{{ number_format($avg, 0) }}</th>
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
        <td class="text-center">&ge;6</td>
        <td class="text-center">Lulus</td>
        <td rowspan="2">
            Hasil PME parameter mikroskopis parasit saluran pencernaan laboratorium saudara masuk dalam skor rata-rata dengan kriteria <b>@if($avg >= 6) Lulus @else Tidak Lulus @endif</b>
        </td>
    </tr>
    <tr>
        <td class="text-center">&lt;6</td>
        <td class="text-center">Tidak Lulus</td>
    </tr>
    </tbody>
</table>

<br/>
<br/>

@component('score.signature', [
    'submit' => $submit
])
@endcomponent