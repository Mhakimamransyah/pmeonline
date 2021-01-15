@extends('layouts.list')

@php

$invoice = $payment->invoice;

@endphp

@section('content')

    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Tagihan</h3>
        </div>

        <div class="box-body">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="82%">Rincian</th>
                    <th width="13%" class="text-center">Total Tagihan</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center" style="vertical-align: middle;">#{{ $invoice->id }}</td>
                        <td>
                            @foreach($invoice->orders as $order)
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th width="20%">Laboratorium</th>
                                        <th width="10%">Siklus</th>
                                        <th width="70%"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td style="vertical-align: middle;">{{ $order->laboratory->name }}</td>
                                        <td style="vertical-align: middle;">{{ $order->cycle->name }}</td>
                                        <td>
                                            <table class="table table-hover">
                                                <thead>
                                                <tr>
                                                    <th width="70%">Bidang / Parameter Pengujian</th>
                                                    <th width="30%" class="text-center">Harga</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($order->packages as $package)
                                                    <tr>
                                                        <td>
                                                            <b>{{ $package->displayName() }}</b>&nbsp;
                                                            <small>
                                                                <i>
                                                                    {{ $package->parameters->count() }} parameter
                                                                </i>
                                                            </small>
                                                            <p>@foreach($package->parameters as $parameter){{ $loop->first ? '' : ', ' }}{{ $parameter->name }}@endforeach<p>
                                                        </td>
                                                        <td class="text-right" style="vertical-align: middle;">{{ $package->displayTariff() }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            @endforeach
                        </td>
                        <td class="text-right" style="vertical-align: middle;">{{ $invoice->totalCost() }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Konfirmasi Pembayaran</h3>
        </div>

        <div class="box-body">

            <div><a href="{{ Storage::url($payment->evidence) }}" target="_blank" class="btn btn-info">Lihat Bukti Pembayaran</a></div>
            <br/>
            <div class="col-sm-12 well">
                <strong>Informasi Tambahan :</strong><br>
                <p>{{ $payment->note }}</p>
            </div>

        </div>

        <div class="box-footer" style="padding-bottom: 24px;">

            @if($payment->isUnverified())

            <form action="{{ route('administrator.payment-confirmation.verify', ['id' => $payment->id]) }}" method="post">

                @csrf

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Catatan</label>
                        <textarea class="form-control" rows="3" placeholder="" name="note" required></textarea>
                    </div>
                </div>

                <div class="col-sm-12">

                    <button type="submit" class="btn btn-info pull-right" style="margin-left: 8px;" name="action" value="accept">Terima</button>

                    <button type="submit" class="btn btn-danger pull-right" name="action" value="reject">Tolak</button>

                </div>

            </form>

            @endif

            @if($payment->isRejected())

                <div class="alert alert-danger">
                    <h4><i class="icon fa fa-ban"></i> Konfiramsi Pembayaran Ditolak!</h4>
                    <p><strong>Alasan Penolakan :</strong></p>
                    <p>{{ $payment->verifyPayments->first()->note }}</p>
                </div>

            @endif

            @if($payment->isVerified())

                <div class="alert alert-success">
                    <h4><i class="icon fa fa-check"></i> Konfiramsi Pembayaran Diterima!</h4>
                    <p><strong>Informasi Tambahan :</strong></p>
                    <p>{{ $payment->verifyPayments->first()->note }}</p>
                </div>

            @endif

        </div>

    </div>

@endsection
