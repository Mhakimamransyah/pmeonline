<table class="no-border">
    <tbody>
    <tr>
        <td style="width: 60%"></td>
        <td style="width: 40%">
            <span>{{ $submit->order->invoice->laboratory->city ?? '.....................' }}, {{ now()->format('d M Y') }}</span><br/>
            <span>{{ 'Pemeriksa' }}</span><br/><br/><br/><br/>
            <span><strong>{{ $signer }}</strong></span><br/>
        </td>
    </tr>
    </tbody>
</table>