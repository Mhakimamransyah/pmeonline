@extends('layouts.list')

@section('more-head')
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
@endsection

@section('content')

    <div class="box box-success">

        <form action="{{ route('administrator.laboratory.filter') }}" method="post">

            @csrf

        <div class="box-body table-responsive">
            <div class="col-md-3">

                @component('components.input-select', [
                    'name' => 'laboratory_type',
                    'label' => 'Tipe Instansi',
                    'placeholder' => '-- Semua --',
                    'items' => $laboratory_types,
                    'selected' => $laboratory_type_id,
                ])
                @endcomponent

            </div>

            <div class="col-md-3">

                @component('components.input-select', [
                    'name' => 'laboratory_ownership',
                    'label' => 'Kepemilikan Instansi',
                    'placeholder' => '-- Semua --',
                    'items' => $laboratory_ownerships,
                    'selected' => $laboratory_ownership_id,
                ])
                @endcomponent

            </div>

            <div class="col-md-3">

                <div class="form-group has-feedback">
                    <label>{{ 'Provinsi' }}</label>
                    <select class="form-control select2" style="width: 100%;" name="{{ 'province_filter' }}" id="{{ 'select-province_filter' }}">
                        <option value="-1">{{ '-- Semua --' }}</option>
                        @foreach($province_filters as $item)
                            <option value="{{ $item->id }}" @if(isset($province_filter_id) && ($province_filter_id == $item->id)) selected @endif>{{ $item->province->name }}</option>
                        @endforeach
                        <option value="-2" @if(isset($province_filter_id) && ($province_filter_id == "-2")) selected @endif>{{ 'Luar Sumatera' }}</option>
                    </select>
                </div>

            </div>

            <div class="col-md-3">

                <label>{{ 'Peserta Siklus' }}</label>
                <select class="form-control select2" style="width: 100%;" name="{{ 'cycle' }}" id="{{ 'select-cycle' }}">
                    <option value="-1">{{ '-- Semua --' }}</option>
                    @foreach($cycles as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                    <option value="-2">{{ 'Belum Pernah Menjadi Peserta' }}</option>
                </select>

            </div>

        </div>

        <div class="box-footer">
            <button class="btn btn-primary btn-flat pull-right btn-info" type="submit">Cari</button>
        </div>

        </form>

    </div>

    <div class="box box-success">
        <div class="box-body table-responsive">
            <div class="col-sm-12">
                <table id="dataTable" class="table table-hover">
                    <thead>
                    <tr>
                        <th width="25%">Nama Laboratorium</th>
                        <th width="40%">Alamat</th>
                        <th width="15%">Propinsi</th>
                        <th width="20%">Personil Penghubung</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($laboratories as $laboratory)
                        <tr>
                            <td><strong>{{ $laboratory->name }}</strong></td>
                            <td>
                                {{ $laboratory->address }}<br/>
                                {{ $laboratory->village }}, {{ $laboratory->district }}, {{ $laboratory->city }}
                            </td>
                            <td>{{ $laboratory->province->name }}</td>
                            <td>{{ $laboratory->contactPerson->user->name }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
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
