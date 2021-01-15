@extends('layouts.semantic-ui.dashboard')

@section('content')

    <div class="small-form">

        <div class="small-form-content">

            @include('layouts.dashboard.legacy-error')

            <div class="ui clearing segment">

                <a class="ui green ribbon label ribbon-sub-segment">{{ __('Perbaharui Password') }}</a>

                <form class="ui form" action="{{ route('participant.password.update') }}" method="post">

                    @csrf

                    <div class="ui field">
                        <label for="input_new_password">{{ 'Password Baru' }}</label>
                        <input id="input_new_password" class="form-control" type="password" name="password" required>
                    </div>

                    <div class="ui field">
                        <label for="input_confirm_new_password">{{ 'Ulangi Password Baru' }}</label>
                        <input id="input_confirm_new_password" class="form-control" type="password" name="password_confirmation" required>
                    </div>

                    <button type="submit" class="ui blue button right floated">
                        <i class="check icon"></i>
                        {{ __('Simpan') }}
                    </button>

                </form>

            </div>

        </div>

    </div>

@endsection