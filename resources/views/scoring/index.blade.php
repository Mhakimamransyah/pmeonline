@extends('layouts.semantic-ui.blank-3')

@section('style-override')
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')

    <div class="ui fluid clearing segment raised green">

        @component('scoring.components.'.$form, [
            'submitValue' => $submitValue,
            'submit' => $submit,
        ])
        @endcomponent

        <br/>

        <button form="submit-form" class="ui primary button right floated"><i class="save icon"></i>{{ 'Simpan Penilaian' }}</button>

    </div>

@endsection