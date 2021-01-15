@php

    $parameterName = 'Kultur dan Resistensi MO';

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
        <th class="text-center">{{ 'Kultur' }}</th>
        <th class="text-center">{{ 'Hasil Pemeriksaan oleh Lab. Peserta' }}</th>
        <th class="text-center">{{ 'Hasil Pemeriksaan yang Seharusnya' }}</th>
        <th class="text-center">{{ 'Skor Saudara' }}</th>
        <th class="text-center">{{ 'Skor Maksimal' }}</th>
    </tr>
    </thead>
    <tbody>
    @php
        $average1 = [ 2.285714, 1.857142, 2.21428571 ]
    @endphp
    @for($i = 1; $i <= 3; $i++)
        <tr>
            <td class="text-center">{{ $i }}</td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
        </tr>
    @endfor
    </tbody>
    <tfoot>
    <tr style="background-color: white">
        <td colspan="3" class="text-center">{{ 'Jumlah' }}</td>
        <td class="text-center"></td>
        <td class="text-center"></td>
    </tr>
    </tfoot>

</table>

<br/>
<br/>

<table class="table table-bordered">

    <thead>
    <tr>
        <th class="text-center">{{ 'Kultur' }}</th>
        <th class="text-center" colspan="5">{{ 'Hasil Pemeriksaan oleh Lab. Peserta' }}</th>
        <th class="text-center" colspan="5">{{ 'Hasil Pemeriksaan yang Seharusnya' }}</th>
        <th class="text-center">{{ 'Skor Saudara' }}</th>
        <th class="text-center">{{ 'Skor Maksimal' }}</th>
    </tr>
    </thead>
    <tbody>
    <tr style="background-color: white">
        <th></th>
        @for($i = 0; $i < 5; $i++)
            <th class="text-center">{{ $i }}</th>
        @endfor
        @for($i = 0; $i < 5; $i++)
            <th class="text-center">{{ $i }}</th>
        @endfor
        <th></th>
        <th></th>
    </tr>
    <tr>
        <td class="text-center">{{ 1 }}</td>
        @php
            $score = 0;
        @endphp
        @for($i = 0; $i < 5; $i++)
            <td class="text-center">{{ '' }}</td>
        @endfor
        @for($i = 0; $i < 5; $i++)
            <td class="text-center">{{ '' }}</td>
        @endfor
        <td class="text-center">{{ '' }}</td>
        <td class="text-center">{{ '5' }}</td>
    </tr>
    <tr>
        <td colspan="13"></td>
    </tr>
    <tr style="background-color: white">
        <th></th>
        @for($i = 0; $i < 5; $i++)
            <th class="text-center">{{ $i }}</th>
        @endfor
        @for($i = 0; $i < 5; $i++)
            <th class="text-center">{{ $i }}</th>
        @endfor
        <th></th>
        <th></th>
    </tr>
    <tr>
        <td class="text-center">{{ 2 }}</td>
        @php
            $score = 0;
        @endphp
        @for($i = 0; $i < 5; $i++)
            <td class="text-center">{{ '' }}</td>
        @endfor
        @for($i = 0; $i < 5; $i++)
            <td class="text-center">{{ '' }}</td>
        @endfor
        <td class="text-center">{{ '' }}</td>
        <td class="text-center">{{ '5' }}</td>
    </tr>
    </tbody>
    <tfoot>
    <tr style="background-color: white">
        <th class="text-center" colspan="11">{{ 'Jumlah' }}</th>
        <th class="text-center">{{ '' }}</th>
        <th class="text-center">{{ '10' }}</th>
    </tr>
    </tfoot>

</table>

<br/>
<br/>
<b>Catatan :</b><br/>
<span>S : Sensitif</span><br/>
<span>I : Intermediate</span><br/>
<span>R : Resisten</span><br/>
<span>- : Tidak melakukan uji kepekaan terhadap antibiotika.</span><br/>

<br/>
<br/>
<b>{{ 'Komentar / Saran' }}</b><br/>