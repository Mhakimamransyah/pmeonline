@extends('layouts.semantic-ui.dashboard')

@section('content')

    <div class="medium-form">

        <div class="medium-form-content">

            @include('layouts.dashboard.legacy-error')

            <section class="ui clearing segment">

                <a class="ui green ribbon label">{{ __('Tagihan #') . $invoice->getId() }}</a>

                @include('participant.payment.invoice-overview')

                @include('participant.payment.invoice-detail')

                @include('participant.payment.payment-method')

                @if($invoice->isUnpaid())

                    <h4 class="ui horizontal divider header">
                        {{ __('Konfirmasi Pembayaran') }}
                    </h4>

                    <form class="ui form" method="post" enctype="multipart/form-data" action="">

                        @csrf

                        <div class="field">
                            <label for="image">Foto bukti pembayaran</label>
                            <input id="image" type="file" name="evidence" required>
                            <span class="ui label">{{ __('Foto bukti pembayaran dapat berupa berkas gambar berekstensi jpeg/jpg/bmp/png dengan ukuran maksimal 1,5 MB.') }}</span>
                        </div>

                        <div class="field">
                            <label>Informasi Tambahan</label>
                            <textarea class="form-control" rows="3" placeholder="" name="note"></textarea>
                        </div>

                        <button class="ui button blue right floated" type="submit">
                            <i class="check icon"></i>
                            {{ __('Kirim') }}
                        </button>

                    </form>

                @endif

            </section>

        </div>

    </div>

@endsection
