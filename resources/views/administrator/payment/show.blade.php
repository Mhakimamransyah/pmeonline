@extends('layouts.semantic-ui.dashboard')

@section('content')

    <div class="medium-form">

        <div class="medium-form-content">

            @include('layouts.dashboard.legacy-error')

            <section class="ui clearing segment">

                <a class="ui green ribbon label">{{ __('Tagihan #') . $payment->getInvoice()->getId() }}</a>

                @include('administrator.payment.overview')

                @include('administrator.payment.detail')

                @include('participant.payment.payment-method')

                <h4 class="ui horizontal divider header">
                    {{ __('Konfirmasi Pembayaran') }}
                </h4>

                <img class="ui fluid image" src="{{ $payment->getEvidenceStorageLink() }}">

                <br/>

                <div class="ui clearing form">

                    <div class="field">
                        <label>Informasi Tambahan</label>
                        <textarea class="form-control" rows="3" placeholder="" name="note" readonly>{{ $payment->getNoteFromParticipant() }}</textarea>
                    </div>

                </div>

                <h4 class="ui horizontal divider header">
                    {{ __('Verifikasi Pembayaran') }}
                </h4>

                <form class="ui form" method="post" action="{{ route('administrator.payment.update', ['id' => $payment->getId()]) }}">

                    @csrf

                    <div class="field">
                        <label>{{ __('Status Verifikasi Pembayaran') }}</label>
                        <select class="ui search fluid dropdown" name="{{ 'state' }}" required>
                            <option value="">{{ 'Pilih Status Verifikasi Pembayaran' }}</option>
                            <option value="{{ \App\Payment::STATE_WAITING }}" @if($payment->isWaitingVerification()) selected @endif>{{ __('Menunggu Konfirmasi') }}</option>
                            <option value="{{ \App\Payment::STATE_DEBT }}" @if($payment->isInDebt()) selected @endif>{{ __('Terhutang') }}</option>
                            <option value="{{ \App\Payment::STATE_REJECTED }}" @if($payment->isRejected()) selected @endif>{{ __('Ditolak') }}</option>
                            <option value="{{ \App\Payment::STATE_VERIFIED }}" @if($payment->isVerified()) selected @endif>{{ __('Terverifikasi') }}</option>
                        </select>
                    </div>

                    <div class="field">
                        <label>Keterangan dari Administrator</label>
                        <textarea class="form-control" rows="3" placeholder="" name="note_from_administrator">{{ $payment->getNoteFromAdministrator() }}</textarea>
                    </div>

                    <button class="ui blue button right floated" type="submit">
                        <i class="check icon"></i>
                        {{ __('Simpan') }}
                    </button>

                </form>

            </section>

        </div>

    </div>

@endsection
