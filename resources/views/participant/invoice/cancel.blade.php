<div class="ui basic modal" id="cancel-invoice-modal">
    <div class="ui icon header">
        <i class="trash alternate outline icon"></i>
        {{ __('Batalkan Pemesanan') }}
    </div>
    <div class="content">
        <p>{{ __('Apakah Anda yakin hendak membatalkan pemesanan ini?') }}</p>
    </div>
    <div class="actions">
        <div class="ui blue basic cancel inverted button">
            <i class="undo icon"></i>
            {{ __('Kembali') }}
        </div>
        <a class="ui red ok inverted button"
           href="{{ route('participant.invoice.cancel', ['id' => $invoice->getId()]) }}" onclick="event.preventDefault();document.getElementById('cancel-form').submit();">
            <i class="trash alternate outline icon"></i>
            {{ __('Ya, Batalkan Pemesanan') }}
        </a>
        <form id="cancel-form" method="POST" action="{{ route('participant.invoice.cancel', ['id' => $invoice->getId()]) }}">
            @csrf
        </form>
    </div>
</div>