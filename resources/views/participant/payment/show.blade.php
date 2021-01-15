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

                @if($invoice->getPayment() != null)

                    <h4 class="ui horizontal divider header">
                        {{ __('Konfirmasi Pembayaran') }}
                    </h4>

                    <img class="ui fluid image" src="{{ $invoice->getPayment()->getEvidenceStorageLink() }}">

                    <br/>

                    <div class="ui clearing form">

                        <div class="field">
                            <label>Informasi Tambahan</label>
                            <textarea class="form-control" rows="3" placeholder="" name="note" readonly>{{ $invoice->getPayment()->getNoteFromParticipant() }}</textarea>
                        </div>

                    </div>

                @endif

                <h4 class="ui horizontal divider header">
                    {{ __('Status Konfirmasi Pembayaran') }}
                </h4>

                @if ($invoice->isPaymentWaitingVerification())

                    <div class="ui icon warning message">
                        <i class="time icon"></i>
                        <div class="content">
                            <div class="header">
                                {{ __('Menunggu Verifikasi') }}
                            </div>
                            <p>{{ __('Status konfirmasi pembayaran Anda sedang menunggu verifikasi oleh bagian keuangan PME BBLK Palembang.') }}</p>
                        </div>
                    </div>

                @elseif ($invoice->isUnpaid())

                    <div class="ui icon warning message">
                        <i class="money icon"></i>
                        <div class="content">
                            <div class="header">
                                {{ __('Belum Dibayar') }}
                            </div>
                            <p>{{ __('Mohon segera lakukan konfirmasi pembayaran.') }}</p>
                        </div>
                    </div>

                @elseif ($invoice->isPaymentInDebt())

                    <div class="ui icon warning message">
                        <i class="money icon"></i>
                        <div class="content">
                            <div class="header">
                                {{ __('Terhutang') }}
                            </div>
                            <p>{{ __('Mohon segera lakukan pembayaran.') }}</p>
                        </div>
                    </div>

                @elseif ($invoice->isPaymentRejected())

                    <div class="ui icon error message">
                        <i class="cancel icon"></i>
                        <div class="content">
                            <div class="header">
                                {{ __('Tidak Terverifikasi') }}
                            </div>
                            <p>{{ __('Pembayaran Anda tidak dapat diverifikasi oleh bagian keuangan PME BBLK Palembang. Silakan hubungai kami untuk informasi lebih lanjut.') }}</p>
                        </div>
                    </div>

                @elseif ($invoice->isPaymentVerified())

                    <div class="ui icon success message">
                        <i class="check icon"></i>
                        <div class="content">
                            <div class="header">
                                {{ __('Terverifikasl') }}
                            </div>
                            <p>{{ __('Pembayaran Anda telah diverifikasi oleh bagian keuangan PME BBLK Palembang.') }}</p>
                        </div>
                    </div>

                @endif

                @if($invoice->getPayment() != null)

                    <div class="ui clearing form">

                        <div class="field">
                            <label>Catatan dari Administrator</label>
                            <textarea class="form-control" rows="3" placeholder="" name="note" readonly>{{ $invoice->getPayment()->getNoteFromAdministrator() }}</textarea>
                        </div>

                    </div>

                @endif

            </section>

        </div>

    </div>

@endsection
