@extends('layouts.semantic-ui.dashboard')

@section('style')

    @include('layouts.moment-js.css')
    @include('layouts.datatables.css')

    <style>
        td.registered-counter:after, td.participant-counter:after {
            margin-left: 6px;
        }
        td.registered-counter:after {
            content: 'Pendaftar';
        }
        td.participant-counter:after {
            content: 'Peserta';
        }
        .cycle-info {
            margin-top: 6px !important;
        }
        .hide-on-loading {
            visibility: hidden;
        }
    </style>

@endsection

@section('content')

@include('layouts.dashboard.legacy-error')

<div class="ui segments">

    <div class="ui segment">

        <a class="ui green ribbon label ribbon-sub-segment">{{ __('Tagihan Belum Dibayar Siklus ' . $cycle->name) }}</a>

        <table class="ui striped table data-tables" id="table">
            <thead>
            <tr>
                <th>
                    {{ __('Laboratorium') }}
                </th>
                <th style="width: 120px">
                    {{ __('Status Tagihan') }}
                </th>
                <th style="width: 120px">
                    {{ __('Nominal Tagihan') }}
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
                        <td class="right aligned">
                            {{ 'Rp ' . number_format($invoice->getTotalCost(), 0, ',', '.') }}
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>

    </div>

</div>

@endsection

@section('script')

    @include('layouts.moment-js.js')
    @include('layouts.datatables.js')

@endsection