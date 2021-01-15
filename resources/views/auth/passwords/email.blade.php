@extends('layouts.semantic-ui.app')

@section('content')

    <div class="ui centered grid text container">
        <div class="ten wide column">
            <div class="ui clearing segment">

                <form class="ui form" method="POST" action="{{ route('password.email') }}" aria-label="{{ __('Reset Password') }}">

                    <a class="ui green ribbon label ribbon-sub-segment">{{ __('Reset Password') }}</a>

                    @csrf

                    <div class="field">
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="{{ __('Email Kontak Personil Penghubung') }}">
                    </div>

                    <button type="submit" class="ui button primary right floated">
                        {{ __('Kirim Password ke Email') }}
                        <i class="right chevron icon"></i>
                    </button>
                </form>

            </div>
        </div>
    </div>

@endsection
