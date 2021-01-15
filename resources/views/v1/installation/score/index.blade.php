@extends('v1.layouts.list')

@section('content-header')

    <h1>{{ 'Penilaian' }}</h1>

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
                    <th class="block" width="65%">{{ 'Laboratorium' }}</th>
                    <th class="block" width="30%">{{ 'Paket' }}</th>
                    <th class="block"></th>
                </tr>
                </thead>
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
        const formInputTable = $('#dataTable').DataTable({
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : true,
            'pageLength'  : 50,
            'columnDefs'  : [{
                'targets'    : [0, 1, 2],
                'className'  : 'middle-vertical'
            }]
        });

        function reload() {
            formInputTable.clear().draw();
            $.ajax({
                type: 'GET',
                url: '{{ route('installation.score.fetch') }}',
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    $.each(data, function (index, item) {
                        let button = '<a class="btn btn-info" href="{{ route('installation.score.index') }}/' +  item.id + '" target="_blank"><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;Lihat</a>';
                        formInputTable.row.add([
                            '<strong>' + item.order_package.order.laboratory.name + '</strong><br/><i></i>',
                            '' + item.order_package.package.display.label + '<br/><i></i>',
                            button
                        ]).draw();
                    });
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }

        $(document).ready(function() {
            reload();
        });
    </script>

@endsection