<h4 class="ui horizontal divider header">
    {{ __('Rincian Pemesanan') }}
</h4>

<table class="ui table">
    <thead>
    <tr>
        <th width="80%">{{ __('Paket') }}</th>
        <th width="20%" class="center aligned">{{ __('Subtotal') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($invoice->getOrders() as $order)
        <tr>
            <td>
                <b>{{ $order->getPackage()->getLabel() }}</b>
                <small>
                    <i>
                        {{ $order->getPackage()->getParameters()->count() }} parameter
                    </i>
                </small>
                <br/>
                @foreach($order->getPackage()->getParameters() as $parameter)
                    <span class="ui label" style="margin: 2px 0 2px;">{{ $parameter->label }}</span>
                @endforeach
                <span class="ui tag label">{{ $order->getPackage()->getCycle()->getName() }}</span>
            </td>
            <td class="right aligned" style="vertical-align: middle;">{{ $order->displaySubtotal() }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th class="right aligned">{{ __('Total') }}</th>
        <th class="right aligned"><strong>{{ $invoice->displayTotalCost() }}</strong></th>
    </tr>
    </tfoot>
</table>