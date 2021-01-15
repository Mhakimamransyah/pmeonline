@php

    $parameterName = 'Malaria';

@endphp

<h3 class="text-center"><b>PROGRAM NASIONAL PEMANTAPAN MUTU EKSTERNAL BIDANG MIKROBIOLOGI<br/>
        HASIL EVALUASI PARAMETER {{ strtoupper($parameterName) }}<br/>
        SIKLUS II - TAHUN 2018</b>
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
        <th class="text-center">{{ 'Hasil Pemeriksaan yang Seharusnya' }}</th>
        <th class="text-center">{{ 'Skor' }}</th>
    </tr>
    </thead>

    <tbody>
    @for ($i = 0; $i < 10; $i++)

        <tr>

            <td class="text-center">{{ $i }}</td>

            <td class="text-center"></td>

            <td class="text-center"></td>

            <td class="text-center"></td>

        </tr>

    @endfor
    </tbody>
    <tfoot>
    <tr>
        <th colspan="3" class="text-center">{{ 'Skor Rata-Rata' }}</th>
        <td class="text-center"></td>
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
        <td class="text-center">&ge;2,5</td>
        <td class="text-center">Lulus</td>
        <td rowspan="2"></td>
    </tr>
    <tr>
        <td class="text-center">&lt;2,5</td>
        <td class="text-center">Tidak Lulus</td>
    </tr>
    </tbody>
</table>

<br/>
<br/>
<b>{{ 'Komentar / Saran' }}</b><br/>