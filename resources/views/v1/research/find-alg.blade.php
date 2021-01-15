@php
    $useSelect2 = true;
    $useIcheck = true;
@endphp

@extends('layouts.app')

@section('style-override')
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')

    @component('form.components.success-message')
    @endcomponent

    <form method="post" action="{{ route('research.find-alg.submit') }}">

        @csrf

        <div class="box box-success">

            <div class="box-body">

                <div class="col-md-12">

                    <div class="form-group">
                        <label for="items">{{ 'Input Data' }}&nbsp;&nbsp;<small><i>{{ 'Pisahkan koma desimal dengan tanda titik. Pisahkan item dengan spasi.' }}</i></small></label>
                        <input id="items" class="form-control" name="items">
                    </div>

                </div>

            </div>

            <div class="box-footer">

                <div class="col-md-12">
                    <button id="calculate" type="submit" class="btn btn-warning pull-right" style="margin-left: 8px;">{{ 'Hitung' }}</button>
                </div>

            </div>

        </div>

    </form>

    @if(session()->has('result'))

        <div class="row">

            <div class="col-xs-6">

                <div class="box box-success">

                    <div class="box-body">

                        <div class="col-md-12">

                            <div class="form-group">
                                <label for="items">{{ 'Iteration / Perulangan' }}</label>
                                <input id="items" class="form-control" style="width: 100%;" value="{{ session()->get('result')->iteration }}" disabled/>
                            </div>

                        </div>

                        <div class="col-md-12">

                            <div class="form-group">
                                <label for="items">{{ 'Mean' }}</label>
                                <input id="items" class="form-control" style="width: 100%;" value="{{ number_format((float)session()->get('result')->mean, 3, '.', '') }}" disabled/>
                            </div>

                        </div>

                        <div class="col-md-12">

                            <div class="form-group">
                                <label for="items">{{ 'Standard Deviation (Alg-A)' }}</label>
                                <input id="items" class="form-control" style="width: 100%;" value="{{ number_format((float)session()->get('result')->standardDeviation, 3, '.', '') }}" disabled/>
                            </div>

                        </div>

                        <div class="col-md-12">

                            <div class="form-group">
                                <label for="items">{{ 'S. Horwit' }}</label>
                                <input id="items" class="form-control" style="width: 100%;" value="{{ number_format((float)session()->get('result')->shorwit, 3, '.', '') }}" disabled/>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-xs-6">

                <div class="box box-success">

                    <div class="box-body">

                        <table class="table table-hover">

                            <thead>

                                <th>{{ 'Data' }}</th>

                            </thead>

                            @foreach(session()->get('items') as $item)

                                <tr>

                                    <td>{{ $item }}</td>

                                </tr>

                            @endforeach

                        </table>

                    </div>

                </div>

            </div>

        </div>

    @endif

@endsection

@section('js')
    <script src="{{ asset('bower_components/inputmask/dist/inputmask/inputmask.js') }}"></script>
    <script src="{{ asset('bower_components/inputmask/dist/inputmask/inputmask.extensions.js') }}"></script>
    <script src="{{ asset('bower_components/inputmask/dist/inputmask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
@endsection


@section('script')
    $(function () {
        $('.select2-tag').select2({
            tags: true
        });
    });
@endsection