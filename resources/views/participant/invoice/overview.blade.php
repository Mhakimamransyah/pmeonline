<div class="ui clearing segment">

    <a class="ui green ribbon label">{{ __('Tagihan #') . $invoice->getId() }}</a>

    <div class="ui divided items">
        <div class="ui item">
            <div class="content">
                @include('participant.invoice.overview-description')
                <div class="extra">
                    @include('participant.invoice.overview-extra')

                    <a href="{{ route('participant.invoice.show', ['id' => $invoice->getId()]) }}" class="ui right floated button">
                        {{ __('Lihat Detail') }}
                        <i class="right chevron icon"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>