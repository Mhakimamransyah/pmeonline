@extends('v1.layouts.list')

@section('content-header')

    @component('v1.administrator.contact-person.heading')
    @endcomponent

@endsection

@section('content')

    @if(Session::has('success'))
        <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <p>{!! Session::get('success')  !!}</p>
        </div>
    @endif

    @component('v1.component.alert-danger')
    @endcomponent

    <div class="row">

        <div class="col-md-6">
            @component('v1.administrator.contact-person.small-form', [
                'data' => $contact_person,
            ])
            @endcomponent
        </div>

        <div class="col-md-6">
            @component('v1.administrator.phone.small-index')
            @endcomponent

            @component('v1.administrator.laboratory.small-index')
            @endcomponent
        </div>

    </div>

    @component('v1.administrator.phone.dialog.create')
    @endcomponent

    @component('v1.administrator.phone.dialog.delete')
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
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            let phoneNumbers = JSON.parse('{!! $contact_person->phoneNumbers !!}');
            setupPhoneNumbersTable(phoneNumbers);

            let laboratories = JSON.parse('{!! $contact_person->laboratories !!}');
            setupLaboratoriesTable(laboratories);

            $('.select2').select2({
                'placeholder' : '-- Pilih --',
            });
        });

        function setupPhoneNumbersTable(phoneNumbers) {
            console.log(phoneNumbers);
            let table = $('#phone_small_table').DataTable({
                'paging'      : false,
                'lengthChange': false,
                'searching'   : false,
                'ordering'    : false,
                'info'        : false,
                'autoWidth'   : true,
            });
            $.each(phoneNumbers, function (index, phone) {
                table.row.add([
                    '<strong>' + phone.number + '</strong><br/><small><i>' + phone.phone_type.name + '<small></i>',
                    '<a class="btn btn-warning" onclick="showUpdatePhoneDialog(' + phone.phone_type.id + ', \'' + phone.number + '\', ' +  phone.id + ')"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;' +
                    '<a class="btn btn-danger" onclick="showDeletePhoneDialog(\'' + phone.number + '\', ' +  phone.id + ')"><i class="fa fa-trash"></i></a>'
                ]).draw();
            })
        }

        function setupLaboratoriesTable(laboratories) {
            console.log(laboratories);
            let table = $('#laboratory_small_table').DataTable({
                'paging'      : false,
                'lengthChange': false,
                'searching'   : false,
                'ordering'    : false,
                'info'        : false,
                'autoWidth'   : true,
            });
            $.each(laboratories, function (index, laboratory) {
                table.row.add([
                    '<strong>' + laboratory.name + '</strong><br/><small><i>' + laboratory.address + ', ' + laboratory.province.name + '<small></i>',
                    ''
                    // '<a class="btn btn-info" onclick=""><i class="fa fa-info-circle"></i></a>&nbsp;&nbsp;' +
                    // '<a class="btn btn-danger" onclick=""><i class="fa fa-minus"></i></a>'
                ]).draw();
            })
        }

        function showCreatePhoneDialog() {
            $('#createPhoneDialog').modal('show');
            $('#contactPersonId').val('{!! $contact_person->id !!}');
            $('#phoneType').val('').trigger('change');
            $('#phoneNumber').val('');
            $('#createPhoneDialogTitle').text('Tambah Nomor Telepon');
            $('#phoneId').val(null);
        }

        function showUpdatePhoneDialog(typeId, number, id) {
            console.log(typeId);
            console.log(number);
            $('#createPhoneDialog').modal('show');
            $('#contactPersonId').val('{!! $contact_person->id !!}');
            $('#phoneType').val(typeId).trigger('change');
            $('#phoneNumber').val(number);
            $('#createPhoneDialogTitle').text('Perbaharui Nomor Telepon');
            $('#phoneId').val(id);
        }

        function showDeletePhoneDialog(number, id) {
            console.log(number);
            $('#deletePhoneDialog').modal('show');
            $('#phoneNumberLabel').text(number);
            $('#targetDeletePhoneId').val(id);
            $('#fromContactPersonId').val({!! $contact_person->id !!});
        }
    </script>
@endsection