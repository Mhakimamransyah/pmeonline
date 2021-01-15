@php

    $parameterName = 'Anti HCV';

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
        <th rowspan="2" class="text-center">{{ 'Panel' }}</th>
        <th rowspan="2" class="text-center">{{ 'Metode Pemeriksaan' }}</th>
        <th rowspan="2" class="text-center">{{ 'Reagen' }}</th>
        <th rowspan="2" class="text-center">{{ 'Hasil Pemeriksaan' }}</th>
        <th rowspan="2" class="text-center">{{ 'Hasil Rujukan' }}</th>
        <th colspan="2" class="text-center">{{ 'Ketepatan Hasil' }}</th>
    </tr>
    <tr>
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
        </tr>
    @endfor
    </tbody>
    <tfoot>
    <tr>
        <th class="text-center" colspan="5">{{ 'Rata-Rata Nilai Ketepatan Hasil' }}</th>
        <th class="text-center"></th>
        <th class="text-center"></th>
    </tr>
    </tfoot>

</table>

<br/>
<br/>
<b>{{ 'Komentar / Saran' }}</b><br/>