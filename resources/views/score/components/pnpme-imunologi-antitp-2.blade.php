@php

    $parameterName = 'Anti TPHA';

@endphp

<h3 class="text-center"><b>PROGRAM NASIONAL PEMANTAPAN MUTU EKSTERNAL BIDANG IMUNOLOGI<br/>
        HASIL EVALUASI PARAMETER {{ strtoupper($parameterName) }}<br/>
        SIKLUS I - TAHUN 2019</b>
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
        <th class="text-center" rowspan="2">{{ 'Panel' }}</th>
        <th class="text-center" rowspan="2">{{ 'Metode Pemeriksaan' }}</th>
        <th class="text-center" rowspan="2">{{ 'Nama Reagen' }}</th>
        <th class="text-center" colspan="2">{{ 'Hasil Pemeriksaan' }}</th>
        <th class="text-center" colspan="2">{{ 'Hasil Rujukan' }}</th>
        <th class="text-center" colspan="2">{{ 'Nilai Keterangan Hasil' }}</th>
    </tr>
    <tr>
        <th class="text-center">{{ 'Hasil' }}</th>
        <th class="text-center">{{ 'Titer' }}</th>
        <th class="text-center">{{ 'Hasil' }}</th>
        <th class="text-center">{{ 'Titer' }}</th>
        <th class="text-center">{{ 'Nilai' }}</th>
        <th class="text-center">{{ 'Kategori' }}</th>
    </tr>
    </thead>
    <tbody>
    @for($h = 0; $h < 3; $h++)
        <tr>
            <td class="text-center">{{ $h }}</td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
        </tr>
    @endfor
    </tbody>
    <tfoot>
    <tr>
        <th colspan="7" class="text-center">{{ 'Rata-Rata Nilai Ketepatan Hasil' }}</th>
        <th class="text-center"></th>
        <th class="text-center"></th>
    </tr>
    </tfoot>
</table>

<br/>
<br/>
<b>{{ 'Komentar / Saran' }}</b><br/>