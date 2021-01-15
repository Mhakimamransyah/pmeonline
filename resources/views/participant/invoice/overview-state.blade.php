@if ($invoice->isPaymentWaitingVerification())
    <span class="ui label">{{ __('Menunggu Konfirmasi') }}</span>
@elseif ($invoice->isUnpaid())
    <span class="ui yellow label">{{ __('Belum Dibayar') }}</span>
@elseif ($invoice->isPaymentInDebt())
    <span class="ui purple label">{{ __('Terhutang') }}</span>
@elseif ($invoice->isPaymentRejected())
    <span class="ui red label">{{ __('Ditolak') }}</span>
@elseif ($invoice->isPaymentVerified())
    <span class="ui green label">{{ __('Terverifikasi') }}</span>
@endif