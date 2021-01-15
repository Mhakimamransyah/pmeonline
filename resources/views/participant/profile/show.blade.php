@extends('layouts.semantic-ui.dashboard')

@section('content')

    <div class="small-form">

        <div class="small-form-content">

            @include('layouts.dashboard.legacy-error')

            <div class="ui clearing segment">

                <a class="ui green ribbon label ribbon-sub-segment">{{ __('Profil Personil Penghubung') }}</a>

                <form class="ui form" action="{{ route('participant.profile.update') }}" method="post">

                    @csrf

                    @component('layouts.semantic-ui.components.input-text', [
                        'name' => 'name',
                        'old' => 'name',
                        'hasError' => $errors->has('name'),
                        'label' => 'Nama Personil Penghubung',
                        'required' => true,
                        'value' => $user->name,
                        'placeholder' => 'Isi nama personil penghubung',
                    ])
                    @endcomponent

                    @component('layouts.semantic-ui.components.input-text', [
                        'name' => 'email',
                        'old' => 'email',
                        'hasError' => $errors->has('email'),
                        'label' => 'Email Personil Penghubung',
                        'required' => true,
                        'value' => $user->email,
                        'placeholder' => 'Isi email personil penghubung',
                    ])
                    @endcomponent

                    @component('layouts.semantic-ui.components.input-text', [
                        'name' => 'phone_number',
                        'old' => 'phone_number',
                        'hasError' => $errors->has('phone_number'),
                        'label' => 'Nomor Telepon Personil Penghubung',
                        'required' => true,
                        'value' => $user->phone_number,
                        'placeholder' => 'Isi nomor telepon personil penghubung',
                    ])
                    @endcomponent

                    <button type="submit" class="ui primary button right floated">
                        <i class="check icon"></i>
                        {{ __('Simpan') }}
                    </button>

                </form>

            </div>

        </div>

    </div>

@endsection
