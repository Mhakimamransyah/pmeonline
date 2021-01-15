@extends('layouts.list')

@section('more-head')
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
@endsection

@section('content')

    <div class="box box-success">

        <form action="{{ route('administrator.order.filter') }}" method="post">

            @csrf

            <div class="box-body table-responsive">

                <div class="col-md-9">

                    @component('components.input-select', [
                        'name' => 'laboratory',
                        'label' => 'Laboratorium',
                        'placeholder' => '-- Pilih Laboratorium --',
                        'items' => $laboratories,
                        'selected' => $laboratory_id,
                    ])
                    @endcomponent

                </div>

                <div class="col-md-3">

                    <label>{{ 'Siklus' }}</label>
                    <select class="form-control select2" style="width: 100%;" name="{{ 'cycle' }}" id="{{ 'select-cycle' }}">
                        <option value="-1">{{ '-- Semua --' }}</option>
                        @foreach($cycles as $item)
                            <option value="{{ $item->id }}" @if($cycle_id == $item->id) selected @endif>{{ $item->name }}</option>
                        @endforeach
                    </select>

                </div>

            </div>

            <div class="box-footer">
                <button class="btn btn-primary btn-flat pull-right btn-info" type="submit">Cari</button>
            </div>

        </form>

    </div>

    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Paket Pengujian Mutu Eksternal Terpilih</h3>
        </div>

        <div class="box-body">
            <table class="table" id="dataTable">
                <thead>
                <tr>
                    <th width="10%">Siklus</th>
                    <th width="75%">Rincian</th>
                    <th width="15%" class="text-center">Total Biaya</th>
                </tr>
                </thead>
                <tbody>
                @if($orders->count() != 0)
                    @foreach($orders as $order)
                        <tr>
                            <td class="text-center" style="vertical-align: middle;">{{ $order->cycle->name }}</td>
                            <td>
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th width="80%">Bidang / Parameters</th>
                                        <th width="20%" class="text-center">Tarif</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order->packages as $package)
                                        <tr>
                                            <td>
                                                <b>{{ $package->displayName() }}</b>
                                                <small>
                                                    <i>
                                                        {{ $package->parameters->count() }} parameter
                                                    </i>
                                                </small>
                                                <p>{{ $package->displayParameters() }}<p>
                                            </td>
                                            <td class="text-right" style="vertical-align: middle;">{{ $package->displayTariff() }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </td>
                            <td style="vertical-align: middle;" class="text-right">
                                {{ $order->displayTotalCost() }}
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
                <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="text-right">
                        <strong>
                            {{ $totalCost }}
                        </strong>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>

    </div>

@endsection

@section('more-js')
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
@endsection

@section('more-script')
    $(function () {
        $('.select2').select2()
    });
@endsection
