@php

$order_package = \App\OrderPackage::find($order_package_id);
$laboratory_name = $order_package->laboratoryName();

@endphp


@if(\Illuminate\Support\Facades\Auth::user()->roles->first()->id != 1)
    <div class="callout callout-info">
        <p>Anda sedang memperbaiki isian milik <strong>{{ $laboratory_name }}</strong>.</p>
    </div>
@endif