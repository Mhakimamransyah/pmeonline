@extends('layouts.list')

@section('more-head')
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
@endsection

@section('content')

    <div class="box box-success">

        <form action="{{ route('administrator.invoice.filter') }}" method="post">

            @csrf

            <div class="box-body table-responsive">

                <div class="col-md-12">

                    <div class="form-group has-feedback">
                        <label>{{ 'Personil Penghubung' }}</label>
                        <select class="form-control select2" style="width: 100%;" name="{{ 'contact_person' }}" id="{{ 'select-contact_person' }}">
                            <option value="-1">{{ '-- Pilih Personil Penghubung --' }}</option>
                            @foreach($contact_people as $item)
                                <option value="{{ $item->id }}" @if($contact_person_id == $item->id) selected="" @endif>{{ $item->user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{--@component('components.input-select', [--}}
                        {{--'name' => '',--}}
                        {{--'label' => '',--}}
                        {{--'placeholder' => '',--}}
                        {{--'items' => $contact_people,--}}
                        {{--'selected' => $contact_person_id,--}}
                    {{--])--}}
                    {{--@endcomponent--}}

                </div>

            </div>

            <div class="box-footer">
                <button class="btn btn-primary btn-flat pull-right btn-info" type="submit">Cari</button>
            </div>

        </form>

    </div>

    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Tagihan</h3>
        </div>

        <div class="box-body">
            <table class="table" id="dataTable">
                <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="82%">Rincian</th>
                    <th width="13%" class="text-center">Harga</th>
                </tr>
                </thead>
                <tbody>
                @foreach($invoices as $invoice)
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
                @endforeach
                </tbody>
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
