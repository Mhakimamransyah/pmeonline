@php
$cycle = $submit->order->package->cycle;
@endphp

<table>
    <tbody>
    <tr>
        <td style="width: 60%"></td>
        <td style="width: 40%">
            <span>{{ $cycle->evaluation_signed_on_place ?? '.....................' }}, {{ $cycle->evaluation_signed_on_date ?? '..........................................' }}</span><br/>
            <span>{{ $cycle->evaluation_signed_by_position ?? '..........................................' }}</span><br/><br/><br/><br/><br/>
            <span><strong>{{ $cycle->evaluation_signed_by_name ?? '..........................................' }}</strong></span><br/>
            <span>NIP {{ $cycle->evaluation_signed_by_identifier ?? '.....................' }}</span>
        </td>
    </tr>
    </tbody>
</table>