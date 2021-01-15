<h3 class="text-center" style="font-size: 9pt;"><b>PROGRAM NASIONAL PEMANTAPAN MUTU EKSTERNAL BIDANG {{ strtoupper($bidang) }}<br/>
        HASIL EVALUASI BOTOL {{ $bottle_number }} ({{ $bottle_string }})<br/>
        SIKLUS 2 - TAHUN 2018</b>
</h3>

<br/>

<table class="" style="border-width: 0">
    <tr style="height: 20pt">
        <td width="20%">Kode Peserta</td>
        <td width="2%">&nbsp;:&nbsp;</td>
        <td>{{ $orderPackage->order->participant->number }}</td>
    </tr>
    <tr style="height: 20pt">
        <td width="20%">Nama Peserta</td>
        <td width="2%">&nbsp;:&nbsp;</td>
        <td>{{ $orderPackage->laboratoryName() }}</td>
    </tr>
    <tr style="height: 20pt">
        <td width="20%">Alamat Peserta</td>
        <td width="2%">&nbsp;:&nbsp;</td>
        <td>{{ $orderPackage->order->laboratory->address }}</td>
    </tr>
</table>

<br/>