@extends('layouts.semantic-ui.blank-3')

@section('style-override')
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')

    <div class="ui fluid clearing segment green raised">

        @component('form.components.'.$form, [
            'route' => $route,
        ])
        @endcomponent

        @if(auth()->user()->isParticipant())

            @component('form.participant-submit')
            @endcomponent

        @elseif(auth()->user()->isAdministrator())

            @component('form.administrator-submit', [
                'submit' => $submit
            ])
            @endcomponent

        @endif

    </div>

@endsection