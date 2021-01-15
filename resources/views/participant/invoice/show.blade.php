@extends('layouts.semantic-ui.dashboard')

@section('content')

    <div class="medium-form">

        <div class="medium-form-content">

            <div class="ui clearing segment">

                <a class="ui green ribbon label">{{ __('Tagihan #') . $invoice->getId() }}</a>

                <div class="ui divided items">
                    <div class="ui item">
                        <div class="content">
                            @include('participant.invoice.overview-description')
                            <div class="extra">
                                @include('participant.invoice.overview-extra')
                            </div>
                        </div>
                    </div>
                </div>

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

                <div class="ui divider"></div>

                @if ($invoice->isPaymentWaitingVerification())

                    <a href="{{ route('participant.payment.show-create-form', ['invoice_id' => $invoice->getId()]) }}" class="ui right floated button">
                        {{ __('Lihat Konfirmasi Pembayaran') }}
                        <i class="right chevron icon"></i>
                    </a>

                @elseif ($invoice->isUnpaid())

                    <a href="{{ route('participant.payment.show-create-form', ['invoice_id' => $invoice->getId()]) }}" class="ui right floated blue button">
                        {{ __('Konfirmasi Pembayaran') }}
                        <i class="right chevron icon"></i>
                    </a>

                    <button onclick="showCancelInvoiceModal()" class="ui red button">
                        <i class="cancel icon"></i>
                        {{ __('Batalkan Pemesanan') }}
                    </button>

                @elseif ($invoice->isPaymentInDebt())

                    <a href="{{ route('participant.payment.show-create-form', ['invoice_id' => $invoice->getId()]) }}" class="ui right floated blue button">
                        {{ __('Konfirmasi Pembayaran') }}
                        <i class="right chevron icon"></i>
                    </a>

                @elseif ($invoice->isPaymentRejected())

                    <a href="{{ route('participant.payment.show-create-form', ['invoice_id' => $invoice->getId()]) }}" class="ui right floated button">
                        {{ __('Lihat Konfirmasi Pembayaran') }}
                        <i class="right chevron icon"></i>
                    </a>

                @elseif ($invoice->isPaymentVerified())

                    <a href="{{ route('participant.payment.show-create-form', ['invoice_id' => $invoice->getId()]) }}" class="ui right floated button">
                        {{ __('Lihat Konfirmasi Pembayaran') }}
                        <i class="right chevron icon"></i>
                    </a>

                @endif

            </div>

        </div>

    </div>

    @include('participant.invoice.cancel')

@endsection

@section('script')
    <script>
        function showCancelInvoiceModal() {
            $('#cancel-invoice-modal')
                .modal('show');
        }
    </script>
@endsection