<h3 class="header">{{ $payment->getInvoice()->getLaboratory()->getName() }}</h3>
<div class="meta">
    <strong class="price">{{ $payment->getInvoice()->displayTotalCost() }}</strong>
    <span class="package count">
        <i class="edit outline icon"></i>
        {{ $payment->getInvoice()->getOrders()->count() . __(' Paket PME') }}
    </span>
    <span class="created time">
        <i class="time icon"></i>
        {{ $payment->getInvoice()->getCreatedAt() }}
    </span>
</div>
<div class="description">
</div>