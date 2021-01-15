@extends('layouts.list')

@section('content')

    <div class="box box-success">
        <div class="box-body table-responsive">
            <div class="col-sm-12">
                <table id="dataTable" class="table table-hover">
                    <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th width="75%">Personil Penghubung</th>
                        <th width="20%" class="text-center">Total Tagihan</th>
                        <th width="10%" class="text-center">Status</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($payments as $payment)
                        <tr>
                            <td class="text-center" style="vertical-align: middle;">#{{ $payment->id }}</td>
                            <td style="vertical-align: middle;">{{ $payment->invoice->owner->name() }}</td>
                            <td class="text-right" style="vertical-align: middle;">{{ $payment->invoice->totalCost() }}</td>
                            <td style="vertical-align: middle;" class="text-center">
                                @if($payment->isVerified())
                                    <span class="label label-success">Terverifikasi</span>
                                @elseif($payment->isRejected())
                                    <span class="label label-danger">Ditolak</span>
                                @elseif($payment->isUnverified())
                                    <span class="label label-info">Belum Terverifikasi</span>
                                @else
                                    <span class="label label-warning">Tidak Diketahui</span>
                                @endif
                            </td>
                            <td class="pull-right" style="vertical-align: middle;">
                                <a class="btn btn-default btn-sm" href="{{ route('administrator.payment-confirmation.item', ['id' => $payment->id]) }}">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection