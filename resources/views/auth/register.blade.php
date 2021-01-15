@extends('layouts.semantic-ui.app')

@section('content')
    @include('layouts.dashboard.legacy-error')

    <div class="ui centered grid">
        <div class="sixteen wide column">

            <div class="ui warning message">
                <div class="header">{{ __('Penting!') }}</div>
                <p><strong>{{ __('Pastikan email personil penghubung aktif.') }}</strong> {{ __('Email personil penghubung akan digunakan sebagai
                username untuk login. Password akan dikirim ke email personil penghubung.') }}</p>
            </div>
            <div class="ui fluid clearing segment raised">
                @include('auth.form.register')
            </div>
            <div class="ui warning message">
                <i class="icon help"></i>
                {{ __('Sudah terdaftar? Silakan login') }} <a href="{{ route('login') }}">{{ __('di sini') }}</a>.
            </div>
        </div>
    </div>
    <br/>
@endsection
