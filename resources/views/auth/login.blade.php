@extends('layouts.semantic-ui.app')

@section('content')

    <div class="medium-form">
        <div class="medium-form-content">

            <div class="ui segment raised">

                <div class="ui very relaxed grid internally celled">

                    <div class="ten wide column">

                        <img class="ui image" src="{{ asset('image/login_image.jpg') }}" alt="{{ __('Logo') }}">

                    </div>

                    <div class="six wide column">

                        @include('auth.form.login')

                        <br/>
                        <br/>
                        <br/>

                        <div class="ui message">
                            @if (Route::has('password.request'))
                                <p>{{ __('Lupa Password? Reset password ') }}<a href="{{ route('password.request') }}">
                                        {{ __('di sini') }}
                                    </a></p>
                            @endif
                            <p>{{ __('Belum terdaftar? Formulir pendaftaran ada ') }}<a href="{{ route('register') }}">
                                    {{ __('di sini') }}
                                </a></p>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

@endsection
