@extends('layouts.semantic-ui.dashboard')

@section('content')

    <div class="medium-form">

        <div class="medium-form-content">

            <div class="ui raised green segment">

                <a class="ui green ribbon label">{{ $title }}</a>

                @component('instalasi.component.select-package')
                @endcomponent

                @if(request()->has('package_id'))
                    <div class="ui section divider"></div>


                    <table class="table celled ui data-tables">
                        <thead>
                        <tr>
                            <th style="width: 10%"></th>
                            <th style="width: 30%">{{ 'Provinsi' }}</th>
                            <th style="width: 15%">{{ 'Kode Peserta' }}</th>
                            <th style="width: 45%">{{ 'Laboratorium' }}</th>
                            <th></th>
                        </tr>
                        </thead>
                    </table>

                    @if(!request()->routeIs(['installation.scoring.index', 'installation.score.index']))
                        <a class="ui red empty circular label"></a>&nbsp;&nbsp;Belum Diisi<br/><br/>
                        <a class="ui yellow empty circular label"></a>&nbsp;&nbsp;Belum Dikirim<br/><br/>
                    @endif
                    <a class="ui green empty circular label"></a>&nbsp;&nbsp;Sudah Dikirim<br/><br/>
                    <a class="ui purple empty circular label"></a>&nbsp;&nbsp;Sudah Diverifikasi<br/><br/>
                    <a class="ui blue empty circular label"></a>&nbsp;&nbsp;Sudah Dievaluasi<br/><br/>
                @endif

            </div>

        </div>

    </div>

@endsection


@section('script')

    @component('instalasi.component.select-package-js')
    @endcomponent

    <script src="{{ asset('data-tables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('data-tables/dataTables.semanticui.min.js') }}"></script>

    @if(request()->has('package_id'))
        @yield('dataTableScript')
    @endif

@endsection