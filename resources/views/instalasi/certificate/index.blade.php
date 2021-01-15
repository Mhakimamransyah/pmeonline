@extends('layouts.semantic-ui.dashboard')

@section('content')

    <div class="medium-form">

        <div class="medium-form-content">

            <div class="ui raised green segment">

                <a class="ui green ribbon label">{{ 'Sertifikat' }}</a>

                @component('instalasi.component.select-package')
                @endcomponent

            </div>

        </div>

    </div>

@endsection


@section('script')

    @component('instalasi.component.select-package-js')
    @endcomponent

@endsection