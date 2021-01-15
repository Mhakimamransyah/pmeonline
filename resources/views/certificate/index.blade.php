@extends('layouts.dashboard')

@section('content')
    <div class="box box-success">
        <div class="box-header">
            <div class="box-title">
                <h4>Sertifikat Keikutsertaan</h4>
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
                            <td><a class="btn btn-primary" href="{{ route('participant.certificates', ['order_package' => $orderPackage->id]) }}" target="_blank">{{ 'Lihat Sertifikat' }}</a></td>
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