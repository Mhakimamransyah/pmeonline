@php
    $routeName = Route::currentRouteName();
@endphp

@if ($routeName == 'participant.invoice.index')
    <div class="ui clearing segment">
        <div class="ui icon message">
            <i class="history icon"></i>
            <div class="content">
                <div class="header">
                    {{ __('Belum Ada Riwayat Pemesanan!') }}
                </div>
                <span>{{ __('Anda belum memiliki riwayat pemesanan. Silakan lakukan pendaftaran pengujian PME terlebih dahulu.') }}</span>
                <br/>
            </div>
        </div>
        <a class="ui right floated primary button" href="{{ route('participant.invoice.show-create-form') }}">
            <i class="ui shopping cart icon"></i>
            {{ __('Daftar Uji PME') }}
        </a>
    </div>
@elseif($routeName == 'participant.payment.index')
    <div class="ui clearing segment">
        <div class="ui icon message">
            <i class="money bill alternate outline icon"></i>
            <div class="content">
                <div class="header">
                    {{ __('Belum Ada Konfirmasi Pembayaran!') }}
                </div>
                <span>{{ __('Anda belum memiliki konfirmasi pembayaran. Silakan lakukan pendaftaran pengujian PME terlebih dahulu.') }}</span>
                <br/>
            </div>
        </div>
        <a class="ui right floated primary button" href="{{ route('participant.invoice.show-create-form') }}">
            <i class="ui shopping cart icon"></i>
            {{ __('Daftar Uji PME') }}
        </a>
    </div>
@endif