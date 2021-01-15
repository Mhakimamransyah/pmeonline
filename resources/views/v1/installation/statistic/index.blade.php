@extends('v1.layouts.list')

@section('content-header')

    <h1>{{ 'Statistik' }}</h1>

@endsection

@section('content')

    <div class="box box-success">

        <div class="box-body table-responsive">

            <table id="dataTable" class="table table-hover">
                <tbody>
                @foreach($packages as $package)
                    <tr>
                        <th colspan="2">{{ $package->subject->name }}</th>
                    </tr>
                    @foreach($package->parameters as $parameter)
                        <tr>
                            <td class="middle-vertical">{{ $parameter->name }}</td>
                            <td class="middle-vertical text-right"><a class="btn btn-info" href="{{ route('installation.statistic', ['parameter_id' => $parameter->id, 'bottle_id' => 0,]) }}"><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;Lihat Statistik</a></td>
                        </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>

        </div>

    </div>

@endsection