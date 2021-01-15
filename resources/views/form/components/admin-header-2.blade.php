@php

$order = \App\Order::find($order_id);
$laboratory_name = $order->invoice->laboratory->name;

@endphp
