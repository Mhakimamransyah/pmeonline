@php
$useSelect2 = true;
$cycles = \App\Cycle::all();
$types = \App\LaboratoryType::all();
$ownerships = \App\LaboratoryOwnership::all();
$provinces = \App\ProvinceFilter::all();
$packages = \App\PackageFilter::all();
$pageLength = 10;
$cycle_id = app('request')->input('cycle');
@endphp

@extends('layouts.list')

@section('more-head')
    <style>
        tr td:last-child{
            width:1%;
            white-space:nowrap;
        }

        .middle-vertical {
            vertical-align: middle !important;
        }
    </style>
@endsection

@section('content')

    @if($cycle_id != null)

    <div class="text-right">
        <a class="btn btn-primary btn-flat pull-right btn-info" href="{{ route('administrator.export.participant', ['cycle_id' => $cycle_id]) }}" target="_blank">Ekspor Data ke Excel</a>
    </div>

    @endif

    <br/><br/><br/>

    <div class="box box-success">

        <form action="{{ route('administrator.participant.filter') }}" method="get">

            <input hidden="" value="{{ $cycle_id or -1 }}" name="cycle">

            <div class="box-body table-responsive">

                <div class="col-md-3">

                    <label>{{ 'Tipe Laboratorium' }}</label>
                    <select class="form-control select2" style="width: 100%;" name="{{ 'type' }}" id="{{ 'select-type' }}">
                        <option value="-1">{{ '-- Semua --' }}</option>
                        @foreach($types as $item)
                            <option value="{{ $item->id }}" @if($type_id == $item->id) selected @endif>{{ $item->name }}</option>
                        @endforeach
                    </select>

                </div>

                <div class="col-md-3">

                    <label>{{ 'Kepemilikan Laboratorium' }}</label>
                    <select class="form-control select2" style="width: 100%;" name="{{ 'ownership' }}" id="{{ 'select-ownership' }}">
                        <option value="-1">{{ '-- Semua --' }}</option>
                        @foreach($ownerships as $item)
                            <option value="{{ $item->id }}" @if($ownership_id == $item->id) selected @endif>{{ $item->name }}</option>
                        @endforeach
                    </select>

                </div>

                <div class="col-md-3">

                    <label>{{ 'Provinsi' }}</label>
                    <select class="form-control select2" style="width: 100%;" name="{{ 'province_filter' }}" id="{{ 'select-province_filter' }}">
                        <option value="-1">{{ '-- Semua --' }}</option>
                        @foreach($provinces as $item)
                            <option value="{{ $item->id }}" @if($province_filter_id == $item->id) selected @endif>{{ $item->province->name }}</option>
                        @endforeach
                        <option value="-2" @if($province_filter_id == "-2") selected @endif>{{ 'Luar Sumatera' }}</option>
                    </select>

                </div>

                <div class="col-md-3">

                    <label>{{ 'Peserta Paket' }}</label>
                    <select class="form-control select2" style="width: 100%;" name="{{ 'package' }}" id="{{ 'select-package' }}">
                        <option value="-1">{{ '-- Semua --' }}</option>
                        @foreach($packages as $item)
                            <option value="{{ $item->id }}" @if($package_id == $item->id) selected @endif>{{ $item->label }}</option>
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
            <h3 class="box-title">Daftar Peserta</h3>
        </div>

        <div class="box-body">
            <table class="table" id="dataTable">
                <thead>
                <tr>
                    <th width="25%">Laboratorium</th>
                    <th width="75%">Rincian</th>
                </tr>
                </thead>
                <tbody>
                @if($participants->count() != 0)
                    @foreach($participants as $participant)
                        <tr>
                            <td>
                                <strong>{{ $participant->laboratory->name }}</strong><br/>
                                {{ $participant->laboratory->address }}<br/>
                                {{ $participant->laboratory->village }}, {{ $participant->laboratory->district }}, {{ $participant->laboratory->city }}<br/>
                                {{ $participant->laboratory->province->name }}&nbsp;{{ $participant->laboratory->postal_code }}<br/>
                                <br/>
                                Personil Penghubung :<br/>
                                <strong>{{ $participant->laboratory->contactPerson->user->name }}</strong><br/>
                                {{ $participant->laboratory->contactPerson->position or '-' }}<br/>
                            </td>
                            <td>
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th class="block">Bidang / Parameters</th>
                                        <th class="block"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($participant->order->orderPackages as $orderPackage)
                                        <tr>
                                            <td class="middle-vertical">
                                                <b>{{ $orderPackage->package->displayName() }}</b>
                                                <small>
                                                    <i>
                                                        {{ $orderPackage->package->parameters->count() }} parameter
                                                    </i>
                                                </small>
                                                <p>{{ $orderPackage->package->displayParameters() }}<p>
                                            </td>
                                            <td class="middle-vertical">
                                                <a target="_blank" href="{{ route('administrator.form-input', ['id' => $orderPackage->id]) }}" class="btn btn-warning">
                                                    <i class="fa fa-arrow-right"></i>&nbsp;&nbsp;Perbaiki Isian
                                                </a>&nbsp;&nbsp;
                                                <a target="_blank" href="{{ route('administrator.preview', ['id' => $orderPackage->id]) }}" class="btn btn-info">
                                                    <i class="fa fa-arrow-right"></i>&nbsp;&nbsp;Preview
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>

    </div>

@endsection
