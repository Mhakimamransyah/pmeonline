<div class="ui form">

    @csrf

    <div class="ui two fields">

        @component('layouts.semantic-ui.components.input-text-readonly', [
            'name' => 'label',
            'old' => 'label',
            'type' => 'text',
            'label' => 'Nama Paket',
            'placeholder' => 'Isi nama paket',
            'value' => $package->getLabel(),
            'required' => true,
        ])
        @endcomponent

        @component('layouts.semantic-ui.components.input-text-readonly', [
            'name' => 'name',
            'old' => 'name',
            'type' => 'text',
            'label' => 'Kode Paket',
            'placeholder' => 'Isi kode paket',
            'value' => $package->getName(),
            'required' => true,
        ])
        @endcomponent

    </div>

    <div class="ui two fields">

        @component('layouts.semantic-ui.components.input-text-readonly', [
            'name' => 'tariff',
            'old' => 'tariff',
            'type' => 'number',
            'label' => 'Tarif',
            'placeholder' => 'Isi tarif',
            'value' => $package->getTariff(),
            'required' => true,
        ])
        @endcomponent

        @component('layouts.semantic-ui.components.input-text-readonly', [
            'name' => 'quota',
            'old' => 'quota',
            'type' => 'number',
            'label' => 'Target Peserta',
            'placeholder' => 'Isi jumlah target peserta',
            'value' => $package->getQuota(),
            'required' => true,
        ])
        @endcomponent

    </div>

    <button disabled type="submit" class="ui right floated green button"><i class="check icon"></i>{{ __('Siklus Sudah Berjalan') }}</button>

</div>