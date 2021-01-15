@php
$botol1[] = array();
$botol2[] = array();
@endphp

@extends('v1.layouts.list')

@section('content-header')

    <h1>{{ 'Hasil Isian Peserta' }}</h1>

    <br/>

    @if(Session::has('success'))
        <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <p>{!! Session::get('success')  !!}</p>
        </div>
    @endif

    @component('v1.component.alert-danger')
    @endcomponent

@endsection

@section('content')

    <div class="box box-success">

        <div class="box-header">
            <h4>Paket {{ $title }}</h4>
        </div>

        <div class="box-body">

            <div class="table-responsive">

                <table id="dataTable" class="table table-hover table-bordered">
                    <thead class="bg-info">
                    <tr>
                        <th rowspan="2" style="vertical-align: middle;" class="bg-info">#</th>
                        <th rowspan="2" class="text-center bg-info" style="vertical-align: middle;">Nomor Peserta</th>
                        <th rowspan="2" class="text-center bg-info" style="vertical-align: middle;">Instansi</th>
                        <th colspan="{{ count($data[0]->bottles[0]->parameters) }}" class="text-center">Botol 1</th>
                        <th class="bg-aqua-active"></th>
                        <th colspan="{{ count($data[0]->bottles[0]->parameters) }}" class="text-center">Botol 2</th>
                    </tr>
                    <tr>
                        @foreach($data[0]->bottles[0]->parameters as $parameter)
                            <th class="text-center" style="vertical-align: middle;">{{ $parameter->name }}</th>
                            @php($botol1[$parameter->name] = 0)
                        @endforeach
                        <th class="bg-aqua-active"></th>
                        @foreach($data[0]->bottles[0]->parameters as $parameter)
                            <th class="text-center" style="vertical-align: middle;">{{ $parameter->name }}</th>
                            @php($botol2[$parameter->name] = 0)
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @php($index = 1)
                    @foreach($data as $item)
                        <tr>
                            <th class="text-center bg-info">{{ $index }}</th>
                            <th class="text-center bg-info" style="white-space: nowrap">{{ $item->participant_number }}</th>
                            <th style="white-space: nowrap" class="bg-info">{{ $item->laboratory->name }}</th>
                            @foreach($item->bottles[0]->parameters as $parameter)
                                @if ($parameter->hasil != null)
                                    <th class="text-center bg-success">{{ $parameter->hasil }}</th>
                                    @php($botol1[$parameter->name] += 1)
                                @else
                                    @if (isset($parameter->hasil_raw))
                                    <th class="text-center bg-warning">{{ $parameter->hasil_raw }}</th>
                                    @else
                                    <th class="text-center bg-danger">{{ $parameter->hasil }}</th>
                                    @endif
                                @endif
                            @endforeach
                            <th class="bg-aqua-active"></th>
                            @foreach($item->bottles[1]->parameters as $parameter)
                                @if ($parameter->hasil != null)
                                    <th class="text-center bg-success">{{ $parameter->hasil }}</th>
                                    @php($botol2[$parameter->name] += 1)
                                @else
                                    @if (isset($parameter->hasil_raw))
                                        @if (request()->get('package_id') == 3)
                                            @if (in_array($parameter->hasil_raw, ['-', '+', '1+', '2+', '3+', '4+', '5+', '6+', '7+', '8+', '9+']))
                                                <th class="text-center bg-success">{{ $parameter->hasil_raw }}</th>
                                            @else
                                                <th class="text-center bg-warning">{{ $parameter->hasil_raw }}</th>
                                            @endif
                                        @else
                                        <th class="text-center bg-warning">{{ $parameter->hasil_raw }}</th>
                                        @endif
                                    @else
                                        <th class="text-center bg-danger">{{ $parameter->hasil }}</th>
                                    @endif
                                @endif
                            @endforeach
                        </tr>
                        @php($index++)
                    @endforeach
                    </tbody>
                    <tfoot class="bg-success">
                    <tr>
                        <th colspan="3" class="text-center">Total Data</th>
                        @foreach($item->bottles[0]->parameters as $parameter)
                            <th class="text-center">{{ $botol1[$parameter->name] }}</th>
                        @endforeach
                        <th class="bg-aqua-active"></th>
                        @foreach($item->bottles[1]->parameters as $parameter)
                            <th class="text-center">{{ $botol2[$parameter->name] }}</th>
                        @endforeach
                    </tr>
                    </tfoot>
                </table>

            </div>


        </div>

    </div>

@endsection

@section('style-table')
    <style>
        tr td:last-child{
            width:1%;
            white-space:nowrap;
        }
    </style>
@endsection

@section('setup-table')



@endsection