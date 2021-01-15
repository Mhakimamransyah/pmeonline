<h3 class="header">{{ $invoice->getLaboratory()->getName() }}</h3>
<div class="meta">
    <strong class="price">{{ $invoice->displayTotalCost() }}</strong>
    <span class="package count">
        <i class="edit outline icon"></i>
        {{ $invoice->getOrders()->count() . __(' Paket PME') }}
    </span>
    <span class="created time">
        <i class="time icon"></i>
        {{ $invoice->getCreatedAt() }}
    </span>
</div>
<div class="description">
</div>