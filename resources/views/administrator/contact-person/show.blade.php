@extends('layouts.semantic-ui.dashboard')

@section('content')

    <div class="small-form">

        <div class="small-form-content">

            <div class="ui clearing segment">

                <a class="ui green ribbon label ribbon-sub-segment">{{ __('Profil Personil Penghubung') }}</a>

                <div class="ui form">

                    @component('layouts.semantic-ui.components.input-text-readonly', [
                        'name' => 'name',
                        'label' => 'Nama Personil Penghubung',
                        'value' => $user->name,
                        'placeholder' => 'Nama personil penghubung',
                    ])
                    @endcomponent

                    @component('layouts.semantic-ui.components.input-text-readonly', [
                        'name' => 'email',
                        'label' => 'Email Personil Penghubung',
                        'value' => $user->email,
                        'placeholder' => 'Email personil penghubung',
                    ])
                    @endcomponent

                    @component('layouts.semantic-ui.components.input-text-readonly', [
                        'name' => 'phone_number',
                        'label' => 'Nomor Telepon Personil Penghubung',
                        'value' => $user->phone_number,
                        'placeholder' => 'Nomor telepon personil penghubung',
                    ])
                    @endcomponent

                    <form method="post" action="{{ route('administrator.contact-person.login') }}">
                        @csrf
                        <input hidden name="user_id" value="{{ $user->getId() }}">
                        <button type="submit" class="ui right floated button" data-tooltip="{{ __('Masuk sebagai ' . $user->getName()) }}">
                            <i class="key icon"></i>
                            {{ __('Masuk') }}
                        </button>
                    </form>

                </div>

            </div>

        </div>

    </div>

@endsection
