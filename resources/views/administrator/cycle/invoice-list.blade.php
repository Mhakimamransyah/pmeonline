@include('layouts.dashboard.legacy-error')

<div class="ui segments">

    <div class="ui segment">

        <a class="ui green ribbon label ribbon-sub-segment">{{ __('Siklus') }}</a>

        <table class="ui striped table data-tables">
            <thead>
            <tr>
                <th>
                    {{ __('Laboratorium') }}
                </th>
                <th style="width: 120px">
                    {{ __('Tagihan') }}
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoices as $invoice)
                @if ($invoice != null && $invoice->getLaboratory() != null)
                    <tr>
                        <td>
                            <a target="_blank" href="{{ route('administrator.laboratory.show', ['id' => $invoice->getLaboratory()->getId()]) }}">
                                {{ __($invoice->getLaboratory()->getName()) }}
                            </a>
                            <br/>
                            @foreach($invoice->getOrders() as $order)
                                @if ($order->getPackage()->getCycle()->is($cycle))
                                    @if ($order->getSubmit() != null)
                                        @if ($order->getSubmit()->getValue() != null)
                                            @if ($order->getSubmit()->isSent())
                                                <a class="ui blue image label" style="margin-top: 6px">
                                                    {{ $order->getPackage()->getLabel() }}
                                                    <div class="detail">
                                                        <i class="check icon"></i>
                                                    </div>
                                                </a>
                                            @else
                                                <a class="ui orange image label" style="margin-top: 6px">
                                                    {{ $order->getPackage()->getLabel() }}
                                                    <div class="detail">
                                                        <i class="check icon"></i>
                                                    </div>
                                                </a>
                                            @endif
                                        @else
                                            <a class="ui image label" style="margin-top: 6px">
                                                {{ $order->getPackage()->getLabel() }}
                                                <div class="detail">
                                                    <i class="exclamation icon"></i>
                                                </div>
                                            </a>
                                        @endif
                                    @else
                                        <a class="ui red image label" style="margin-top: 6px">
                                            {{ $order->getPackage()->getLabel() }}
                                            <div class="detail">
                                                <i class="close icon"></i>
                                            </div>
                                        </a>
                                    @endif
                                @endif
                            @endforeach
                        </td>
                        <td class="center aligned">
                            <a target="_blank" @if($invoice->getPayment() != null) href="{{ route('administrator.payment.show', ['id' => $invoice->getPayment()->getId()]) }}" @endif>
                                @include('participant.invoice.overview-state')
                            </a>
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>

    </div>

</div>