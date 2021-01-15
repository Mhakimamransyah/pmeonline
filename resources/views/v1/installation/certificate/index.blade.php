@extends('v1.layouts.list')

@section('content-header')

    <h1>{{ 'Sertifikat Keikutsertaan' }}</h1>

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
                    <th class="block" width="5%"></th>
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
                'targets'    : [1, 2],
                'className'  : 'middle-vertical'
            }, {
                'targets'    : [0],
                'className'  : 'text-center middle-vertical',
            }, {
                'targets'    : [3],
                'orderables' : false,
                'className'  : 'middle-vertical'
            }]
        });

        function reload() {
            formInputTable.clear().draw();
            $.ajax({
                type: 'GET',
                url: '{{ route('installation.certificate.fetch') }}',
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    $.each(data, function (index, item) {
                        let color = '';
                        let button = '';
                        if (item.input != null && item.input.sent === 1) {
                            color = 'green';
                        } else if (item.input != null && item.input.sent === 0) {
                            color = 'yellow';
                        } else {
                            color = 'red';
                        }
                        button = '<a class="btn btn-info" href="{{ route('installation.certificate.index') }}/' +  item.id + '" target="_blank"><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;Lihat</a>'
                        formInputTable.row.add([
                            '<span><i class="fa fa-circle" style="color: ' + color + '"></i> </span>',
                            '<strong>' + item.order.laboratory.name + '</strong><br/><i></i>',
                            '' + item.package.display.label + '<br/><i></i>',
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