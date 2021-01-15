@extends('layouts.semantic-ui.dashboard')

@section('content')

    <div class="medium-form">

        <div class="medium-form-content">

            <div class="ui raised green segment">

                <a class="ui green ribbon label">{{ 'Rekap Hasil Evaluasi' }}</a>

                @component('instalasi.component.select-package')
                @endcomponent

            </div>

        </div>

    </div>

    @yield('statistic-content')

@endsection


@section('script')

    @component('instalasi.component.select-package-js')
    @endcomponent

    @yield('statistic-content-script')

@endsection