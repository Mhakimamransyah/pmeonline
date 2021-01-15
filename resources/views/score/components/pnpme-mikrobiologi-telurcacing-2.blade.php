@php

    $parameterName = 'Telur Cacing';

@endphp

<h3 class="text-center"><b>PROGRAM NASIONAL PEMANTAPAN MUTU EKSTERNAL BIDANG MIKROBIOLOGI<br/>
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
        <th class="text-center">{{ 'Kode Sample' }}</th>
        <th class="text-center">{{ 'Hasil Pemeriksaan oleh Lab. Peserta' }}</th>
        <th class="text-center">{{ 'Hasil Pemeriksaan Seharusnya' }}</th>
        <th class="text-center">{{ 'Skor' }}</th>
    </tr>
    </thead>
    <tbody>
    @for ($i = 0; $i < 3; $i++)
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
        <th class="text-center" colspan="3">{{ 'Skor Rata-Rata' }}</th>
        <th class="text-center">{{ '' }}</th>
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
            Hasil PME parameter mikroskopis parasit saluran pencernaan laboratorium saudara masuk dalam skor rata-rata dengan kriteria
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
<b>{{ 'Komentar / Saran' }}</b><br/>