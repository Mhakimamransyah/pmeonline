<table style="border-width: 0; white-space: nowrap;" class="no-border">
    <tr style="height: 20pt">
        <td>Kode Peserta</td>
        <td style="width: 1%">&nbsp;:&nbsp;</td>
        <td style="width: 99%">{{ $submit->order->invoice->laboratory->participant_number }}</td>
    </tr>
    <tr style="height: 20pt">
        <td>Nama Peserta</td>
        <td>&nbsp;:&nbsp;</td>
        <td>{{ $submit->order->invoice->laboratory->name }}</td>
    </tr>
    <tr style="height: 20pt">
        <td>Alamat Peserta</td>
        <td>&nbsp;:&nbsp;</td>
        <td>{{ $submit->order->invoice->laboratory->address }}</td>
    </tr>
</table>