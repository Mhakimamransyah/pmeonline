@extends('layouts.semantic-ui.dashboard')

@section('style')

    @include('layouts.datatables.css')

    <style>
        .text-total-cost {
            content: none;
        }
        .text-total-cost:after {
            visibility: visible;
            content: attr(data-display);
        }
    </style>

@endsection

@section('content')

    @include('layouts.semantic-ui.components.progress-html')

    <div class="medium-form loaded-content">

        <div class="medium-form-content">

            <div class="ui segment">

                <a class="ui green ribbon label ribbon-sub-segment">{{ __('Konfirmasi Pembayaran') }}</a>

                <table class="ui striped table data-tables">
                    <thead>
                    <tr>
                        <th width="5%">
                            {{ __('#') }}
                        </th>
                        <th width="75%">
                            {{ __('Laboratorium') }}
                        </th>
                        <th width="20%">
                            {{ __('Total Tagihan') }}
                        </th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($payments as $payment)
                        @if($payment->getInvoice() != null)
                            <tr>
                                <td class="ui center aligned">{{ __($payment->getId()) }}</td>
                                <td>
                                    {{ __($payment->getInvoice()->getLaboratory()->getName()) }}
                                    <br/>
                                    <div style="margin-top: 6px">
                                        @include('administrator.payment.overview-extra')
                                    </div>
                                </td>
                                <td class="right aligned text-total-cost" data-display="{{ $payment->getInvoice()->displayTotalCost() }}"><span style="visibility: hidden">{{ __($payment->getInvoice()->getTotalCost()) }}</span></td>
                                <td>
                                    <a class="ui icon button" href="{{ route('administrator.payment.show', ['id' => $payment->getId()]) }}"><i class="pencil icon"></i></a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>

            </div>

        </div>

    </div>

@endsection

@section('script')

    @include('layouts.datatables.js')

@endsection
