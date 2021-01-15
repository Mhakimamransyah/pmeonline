@extends('layouts.list')

@section('content-header')
    <a href="{{ route('administrator.laboratory.filter') }}" class="btn btn-info pull-right"><i class="fa fa-filter"></i>&nbsp;&nbsp;Filter</a>
    <br/>
    <br/>
@endsection

@section('content')

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