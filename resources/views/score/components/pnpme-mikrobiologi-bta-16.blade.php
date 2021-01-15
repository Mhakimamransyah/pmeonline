@php

    $parameterName = 'BTA';

    $submitValue = json_decode($submit->value);

    $score = $submit->order->score;

    $scoreValue = json_decode($score->value);

    $package = $submit->order->package;
    $parameters = $package->parameters;
    $cycle = $package->cycle;

    $matrixScore = [
        ['Benar', 'PPR', 'PPT', 'PPT', 'PPT'],
        ['NPR', 'Benar', 'Benar', 'KH', 'KH'],
        ['NPT', 'Benar', 'Benar', 'Benar', 'KH'],
        ['NPT', 'KH', 'Benar', 'Benar', 'Benar'],
        ['NPT', 'KH', 'KH', 'Benar', 'Benar'],
    ];

    $matrixValue = [
        [10, 5, 0, 0, 0],
        [5, 10, 10, 5, 5],
        [0, 10, 10, 10, 5],
        [0, 5, 10, 10, 10],
        [0, 5, 5, 10, 10],
    ];

    $scoreItems = [];

    $autoFail = false;

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
        <th class="text-center">{{ 'Hasil Pemeriksaan oleh Lab. Peserta' }}</th>
        <th class="text-center">{{ 'Hasil Pemeriksaan yang Seharusnya' }}</th>
        <th class="text-center">{{ 'Kualifikasi Penilaian' }}</th>
        <th class="text-center">{{ 'Skor' }}</th>
    </tr>
    </thead>
    <tbody>
    @for ($i = 0; $i < 10; $i++)
        <tr>
            @php
                $panelNumber = $submitValue->{'kode_sediaan_'.$i} ?? null;
                $userAnswer = $submitValue->{'hasil_'.$i} ?? null;
                $expectedAnswer = $scoreValue->{'rujukan'}[$i] ?? '';

                $userMatrix = -1;
                if ($userAnswer == 'negatif') {
                    $userMatrix = 0;
                } elseif ($userAnswer == 'scanty') {
                    $userMatrix = 1;
                } elseif ($userAnswer == '1+') {
                    $userMatrix = 2;
                } elseif ($userAnswer == '2+') {
                    $userMatrix = 3;
                } elseif ($userAnswer == '3+') {
                    $userMatrix = 4;
                }

                $expectedMatrix = -1;
                if ($expectedAnswer == 'negatif') {
                    $expectedMatrix = 0;
                } elseif ($expectedAnswer == 'scanty') {
                    $expectedMatrix = 1;
                } elseif ($expectedAnswer == '1+') {
                    $expectedMatrix = 2;
                } elseif ($expectedAnswer == '2+') {
                    $expectedMatrix = 3;
                } elseif ($expectedAnswer == '3+') {
                    $expectedMatrix = 4;
                }

                $predicate = null;
                $predicateScore = -1;
                if ($userMatrix != -1 && $expectedMatrix != -1) {
                    $predicate = $matrixScore[$expectedMatrix][$userMatrix];
                    $predicateScore = $matrixValue[$expectedMatrix][$userMatrix];
                    array_push($scoreItems, $predicateScore);
                    if ($predicateScore == 0) {
                        $autoFail = true;
                    }
                }
            @endphp
            <td class="text-center">
                @if ($panelNumber == null)
                    <i>Tidak diisi</i>
                @else
                    {{ $panelNumber }}
                @endif
            </td>
            <td class="text-center">
                @if ($userAnswer == null)
                    <i>Tidak diisi</i>
                @else
                    {{ ucfirst($userAnswer) }}
                @endif
            </td>
            <td class="text-center">
                @if ($expectedAnswer == null)
                    <i>Tidak diisi</i>
                @else
                    {{ ucfirst($expectedAnswer) }}
                @endif
            </td>
            <td class="text-center">
                @if ($predicate == null)
                    <i>Tidak dapat dinilai ({{ $userMatrix }}, {{ $expectedMatrix }})</i>
                @else
                    {{ $predicate }}
                @endif
            </td>
            <td class="text-center">
                @if ($predicateScore == -1)
                    <i>-</i>
                @else
                    {{ $predicateScore }}
                @endif
            </td>
        </tr>
    @endfor
    </tbody>
    <tfoot>
    <tr>
        <th class="text-center" colspan="4">{{ 'Total' }}</th>
        <th class="text-center">{{ array_sum($scoreItems) }}</th>
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
        <td class="text-center">&ge;80 dan tanpa NPT / PPT</td>
        <td class="text-center">Lulus</td>
        <td rowspan="2">
            Hasil PME parameter mikroskopis BTA laboratorium saudara masuk dalam kriteria <b>@if(array_sum($scoreItems) >= 80 && !$autoFail) Lulus @else Tidak Lulus @endif</b>
        </td>
    </tr>
    <tr>
        <td class="text-center">&lt;80 atau ada NPT / PPT</td>
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