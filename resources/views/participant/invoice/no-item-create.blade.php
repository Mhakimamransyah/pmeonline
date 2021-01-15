@extends('layouts.semantic-ui.dashboard')

@section('content')

    <div class="medium-form">

        <div class="medium-form-content">

            <div class="ui clearing segment">
                <div class="ui icon message">
                    <i class="shopping cart icon"></i>
                    <div class="content">
                        <div class="header">
                            {{ __('Pendaftaran Uji PME Belum Dibuka!') }}
                        </div>
                        <span>{{ __('Silakan hubungi penyelenggara PME untuk informasi lebih lanjut.') }}</span>
                        <br/>
                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection