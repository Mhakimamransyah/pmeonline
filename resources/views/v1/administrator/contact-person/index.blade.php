@extends('v1.layouts.list')

@section('content-header')

    @component('v1.administrator.contact-person.heading')
    @endcomponent

    @if(Session::has('success'))
        <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <p>{!! Session::get('success')  !!}</p>
        </div>
    @endif

    @component('v1.component.alert-danger')
    @endcomponent

    <span class="pull-right">
        <a class="btn btn-primary" onclick="showCreateFormDialog()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Tambah</a>
    </span>

    <br/>

    <br/>

@endsection

@section('content')

    <div class="box box-success">

        <div class="box-body table-responsive">

            <table id="dataTable" class="table table-hover">
                <thead>
                <tr>
                    <th class="block" width="5%"></th>
                    <th class="block" width="50%">{{ 'Nama Personil Penghubung' }}</th>
                    <th class="block" width="50%">{{ 'Laboratorium' }}</th>
                    <th class="block"></th>
                </tr>
                </thead>
            </table>

        </div>

    </div>

    @component('v1.administrator.contact-person.dialog.create')
    @endcomponent

    @component('v1.administrator.contact-person.dialog.reset-password')
    @endcomponent

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
        const contactPersonTable = $('#dataTable').DataTable({
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

        function buttonResetPasswordClicked(userId, userName) {
            $('#resetPasswordContactPersonDialog').modal('show');
            $('#userNameLabel').text(userName);
            $('#inputUserId').val(userId)
        }

        function showCreateFormDialog() {
            $('#createContactPersonDialog').modal('show');
        }

        function reload() {
            contactPersonTable.clear().draw();
            $.ajax({
                type: 'GET',
                url: '{{ route('v1.administrator.contact-person.fetch') }}',
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    $.each(data, function (index, item) {
                        let laboratoryName, laboratoryPlace = "";
                        let isParticipant = item.participation.length > 0;
                        console.log(isParticipant);
                        if (item.laboratories.length > 0) {
                            laboratoryName = item.laboratories[0].name;
                            laboratoryPlace = item.laboratories[0].province.name;
                        } else {
                            laboratoryName = "-";
                            laboratoryPlace = "";
                        }
                        let participant = '';
                        if (isParticipant) {
                            participant = '<i class="fa fa-check" style="color: green;"></i>';
                        } else {
                            participant = '<i class="fa fa-close" style="color: red;"></i>';
                        }
                        contactPersonTable.row.add([
                            participant,
                            '<strong>' + item.user.name + '</strong><br/><i>' + item.user.email + '</i>',
                            '<strong>' + laboratoryName + '</strong><br/><i>' + laboratoryPlace + '</i>',
                            '<a class="btn btn-info" href="{{ route('v1.administrator.contact-person') }}/' + item.id + '"><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;Detail</a>&nbsp;&nbsp;' +
                            '<a class="btn btn-danger" onclick="buttonResetPasswordClicked(' + item.user.id + ', \'' +  item.user.name + '\')"><i class="fa fa-lock"></i>&nbsp;&nbsp;Reset Password</a>',
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