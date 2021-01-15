{{-- See also view/participant/invoice/overview-extra.blade.php --}}
@foreach($payment->getInvoice()->getCycles() as $cycle)
    @if($cycle != null)
        <a class="ui teal label"><i class="recycle icon"></i>{{ 'Siklus ' . $cycle["name"] }}</a>
    @endif
@endforeach
@if ($payment->isWaitingVerification())
    <a class="ui label">{{ __('Menunggu Konfirmasi') }}</a>
@elseif ($payment->isInDebt())
    <a class="ui purple label">{{ __('Terhutang') }}</a>
@elseif ($payment->isRejected())
    <a class="ui red label">{{ __('Ditolak') }}</a>
@elseif ($payment->isVerified())
    <a class="ui green label">{{ __('Terverifikasi') }}</a>
@endif
