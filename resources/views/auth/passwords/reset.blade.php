@extends('layouts.semantic-ui.app')

@section('content')
    <div class="ui centered grid text container">
        <div class="ten wide column">
            <div class="ui clearing segment">

                <form class="ui form" method="POST" action="{{ route('password.request') }}" aria-label="{{ __('Reset Password') }}">

                    <a class="ui green ribbon label ribbon-sub-segment">{{ __('Reset Password') }}</a>

                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="field">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>
                    </div>

                    <div class="field">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                    </div>

                    <div class="field">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                    </div>

                    <button type="submit" class="ui primary button right floated">
                        {{ __('Reset Password') }}
                        <i class="right chevron icon"></i>
                    </button>
                </form>

            </div>
        </div>
    </div>
@endsection
