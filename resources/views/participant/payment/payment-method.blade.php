<h4 class="ui horizontal divider header">
    {{ __('Metode Pembayaran') }}
</h4>

<div class="ui form">

    <div class="two fields">
        <div class="field">
            <label>{{ __('Nama Bank') }}</label>
            <input value="{{env('PME_PAYMENT_BANK_NAME') }}" readonly="" type="text">
        </div>
        <div class="field">
            <label>{{ __('Nama Cabang') }}</label>
            <input value="{{ env('PME_PAYMENT_BANK_BRANCH') }}" readonly="" type="text">
        </div>
    </div>

    <div class="two fields">
        <div class="field">
            <label>{{ __('Nomor Rekening') }}</label>
            <input value="{{ env('PME_PAYMENT_BANK_ACCOUNT') }}" readonly="" type="text">
        </div>
        <div class="field">
            <label>{{ __('Nama Pemilik Rekening') }}</label>
            <input value="{{ env('PME_PAYMENT_BANK_ACCOUNT_OWNER') }}" readonly="" type="text">
        </div>
    </div>

    <div class="field">
        <label>{{ __('Informasi Tambahan') }}</label>
        <textarea readonly>{{ env('PME_PAYMENT_MORE_INFO') }}</textarea>
    </div>

</div>