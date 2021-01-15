@extends('v1.layouts.list')

@section('content-header')

    @component('v1.administrator.account.heading')
    @endcomponent

    <br/>

@endsection

@section('content')

    <div class="box box-success">

        <div class="box-body table-responsive">

            <table id="dataTable" class="table table-hover">
                <thead>
                <tr>
                    <th class="block" width="50%">{{ 'nama / role' }}</th>
                    <th class="block" width="50%">{{ 'username / password' }}</th>
                </tr>
                </thead>
            </table>

        </div>

    </div>

@endsection

@section('style-table')
@endsection

@section('setup-table')

    <script>
        const contactPersonTable = $('#dataTable').DataTable({
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'pageLength'  : 50,
            'columnDefs'  : [{
                'targets'    : [0, 1],
                'className'  : 'middle-vertical'
            }]
        });

        function reload() {
            contactPersonTable.clear().draw();
            $.ajax({
                type: 'GET',
                url: '{{ route('superadmin.account.fetch') }}',
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    $.each(data, function (index, item) {
                        let role = item.roles[0];
                        let roleText = role != null ? role.name : '-';
                        contactPersonTable.row.add([
                            '<strong>' + item.name + '</strong><br/><i>' + roleText + '</i>',
                            '<strong>' + item.email + '</strong><br/><i>' + item.password + '</i>'
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