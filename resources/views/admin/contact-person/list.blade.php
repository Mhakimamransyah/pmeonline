@extends('layouts.list')

@section('content')

    <div class="box box-success">
        <div class="box-body table-responsive">
            <div class="col-sm-12">
                <table id="dataTable" class="table table-hover">
                    <thead>
                    <tr>
                        <th width="25%">Nama</th>
                        <th width="25%">Email</th>
                        <th width="15%">Nomor Telepon</th>
                        <th width="35%">Laboratorium</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($people as $person)
                        <tr>
                            <td><strong>{{ $person->user->name }}</strong></td>
                            <td>{{ $person->user->email }}</td>
                            <td>
                                @foreach($person->phoneNumbers as $phoneNumber)
                                    <li>{{ $phoneNumber->number }}</li>
                                @endforeach
                            </td>
                            <td>
                                @foreach($person->laboratories as $laboratory)
                                    <li>{{ $laboratory->name }}</li>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection