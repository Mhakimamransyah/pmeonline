@extends('layouts.dashboard')

@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/iCheck/square/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
@endsection

@section('content-header')

@endsection

@section('content')

    @if(Session::has('warning'))

        <div class="alert alert-warning alert-dismissable" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {!! session('warning') !!}
        </div>

    @endif

    @if(Session::has('success'))

        <div class="alert alert-success alert-dismissable" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <b>Tersimpan!</b> Terima kasih atas masukan saudara/i.
        </div>

    @endif

    @if($errors->any())

        <div class="alert alert-error alert-dismissable" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <b>Gagal tersimpan!</b> {!! $errors->first() !!}
        </div>

    @endif

    <form action="{{ route('participant.survey.post', ['id' => $survey->id]) }}" method="POST">

    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Survey</h3>
        </div>

        <div class="box-body">

            @csrf

            <input type="hidden" value="{{ $contact->id }}" name="contact_person_id">

            @php($index = 1)

            @foreach($survey->questions as $question)

                <!-- {{ $question->title }} -->

                <div class="col-xs-12">

                    <div class="form-group">

                        <label class="col-xs-12" for="" style="padding-left: 0">{{ $index }}. {{ $question->title }}</label>

                        @foreach($question->options as $option)

                            <div class="radio">
                                <label for="{{ $option->id }}">
                                    <input type="radio" name="{{ $question->id }}" id="{{ $option->id }}" value="{{ $option->id }}" @if(in_array($option->id, $answered->toArray())) checked="checked" @endif>
                                    {{ $option->title }}
                                </label>
                            </div>

                        @endforeach

                    </div>

                </div>

                @php($index++)

            @endforeach

        </div>

        <div class="box-footer text-right">
            <button type="submit" class="btn btn-info">Kirim</button>
        </div>

    </div>

    </form>

@endsection

@section('js')
    <script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
@endsection
