@php

$cycles = \App\Cycle::all();

@endphp

@extends('layouts.dashboard')

@section('content')
    <div class="box box-success">
        <div class="box-header">
            <div class="box-title">
                <h4>Petunjuk Teknis Uji Pemantapan Mutu Eksternal</h4>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-responsive">
                <thead>
                <tr>
                    <th width="10%">Siklus</th>
                    <th width="90%">Parameter</th>
                </tr>
                </thead>
                <tbody>
                @foreach($cycles as $cycle)
                    <tr>
                        <td style="vertical-align: middle" class="text-center"><strong>{{ $cycle->name }}</strong></td>
                        <td>
                            <table class="table table-responsive table-hover">
                                @foreach($cycle->packages as $package)
                                    <tr>
                                        <td>
                                            <strong>{{ $package->displayName() }}</strong>
                                            <small>
                                                <i>
                                                    {{ $package->parameters->count() }} parameter
                                                </i>
                                            </small>
                                            <br/>{{ $package->displayParameters() }}</td>
                                        <td style="vertical-align: middle" class="text-right">
                                            <a class="btn btn-info" style="margin-right: 8px;">Tampilkan</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection