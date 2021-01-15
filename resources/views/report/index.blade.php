@extends('layouts.dashboard')

@section('content')
    <div class="box box-success">
        <div class="box-header">
            <div class="box-title">
                <h4>Laporan Hasil Evaluasi</h4>
            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th width="100%">Parameter</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($data['laboratories'][0]->orders as $order)
                    @foreach($order->orderPackages as $orderPackage)
                        <tr>
                            <td style="vertical-align: middle">{{ $orderPackage->package->display->label }}</td>
                            @if (in_array($orderPackage->package->id, [1, 2, 3]))
                            <td>
                                <a class="btn btn-primary" href="{{ route('participant.reports', ['order_package' => $orderPackage->id, 'bottle' => 0]) }}" target="_blank">{{ 'Botol 1' }}</a>
                                <a class="btn btn-primary" href="{{ route('participant.reports', ['order_package' => $orderPackage->id, 'bottle' => 1]) }}" target="_blank">{{ 'Botol 2' }}</a>
                            </td>
                            @elseif (in_array($orderPackage->package->id, [4]))
                                <td>
                                    <a class="btn btn-primary" href="{{ route('participant.reports', ['order_package' => $orderPackage->id, 'bottle' => 0]) }}" target="_blank">{{ 'Lihat Hasil Evaluasi' }}</a>
                                </td>
                            @else
                            <td><a class="btn btn-primary" href="{{ route('participant.reports', ['order_package' => $orderPackage->id]) }}" target="_blank">{{ 'Lihat Hasil Evaluasi' }}</a></td>
                            @endif
                        </tr>
                    @endforeach
                @endforeach
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>
    </div>
@endsection