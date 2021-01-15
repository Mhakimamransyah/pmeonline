@extends('v1.layouts.list')

@section('content-header')

    <h1>{{ 'Laporan Hasil Evaluasi' }}</h1>

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

        <div class="box-body table-responsive">

            <table id="dataTable" class="table table-hover">
                <thead>
                <tr>
                    <th class="block" width="65%">{{ 'Paket' }}</th>
                    <th class="block"></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Kimia Klinik</td>
                    <td><a class="btn btn-warning" href="{{ route('installation.report.create', ['package_id' => 1]) }}" target="_blank">{{ 'Lihat' }}</a></td>
                </tr>
                <tr>
                    <td>Hematologi</td>
                    <td><a class="btn btn-warning" href="{{ route('installation.report.create', ['package_id' => 2]) }}" target="_blank">{{ 'Lihat' }}</a></td>
                </tr>
                <tr>
                    <td>Urinalisa</td>
                    <td><a class="btn btn-warning" href="{{ route('installation.report.create', ['package_id' => 3]) }}" target="_blank">{{ 'Lihat' }}</a></td>
                </tr>
                <tr>
                    <td>Hemostasis</td>
                    <td><a class="btn btn-warning" href="{{ route('installation.report.create', ['package_id' => 4]) }}" target="_blank">{{ 'Lihat' }}</a></td>
                </tr>
                </tbody>
            </table>

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

    <script>
        function reload() {
            const formInputTable = $('#dataTable').DataTable({
                'paging'      : true,
                'lengthChange': true,
                'searching'   : true,
                'ordering'    : true,
                'info'        : true,
                'autoWidth'   : true,
                'pageLength'  : 50,
                'columnDefs'  : [{
                    'targets'    : [0, 1],
                    'className'  : 'middle-vertical'
                }, {
                    'targets'    : [1],
                    'orderables' : false,
                    'className'  : 'middle-vertical'
                }]
            });
        }

        $(document).ready(function() {
            reload();
        });
    </script>

@endsection