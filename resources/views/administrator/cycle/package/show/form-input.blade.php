<form class="ui form" method="post" action="{{ route('administrator.cycle.package.update', ['id' => $package->getId()]) }}">

    @csrf

    <div class="ui two fields">

        @component('layouts.semantic-ui.components.input-text', [
            'name' => 'label',
            'old' => 'label',
            'type' => 'text',
            'label' => 'Nama Paket',
            'placeholder' => 'Isi nama paket',
            'value' => $package->getLabel(),
            'required' => true,
        ])
        @endcomponent

        @component('layouts.semantic-ui.components.input-text', [
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

        @component('layouts.semantic-ui.components.input-text', [
            'name' => 'tariff',
            'old' => 'tariff',
            'type' => 'number',
            'label' => 'Tarif',
            'placeholder' => 'Isi tarif',
            'value' => $package->getTariff(),
            'required' => true,
        ])
        @endcomponent

        @component('layouts.semantic-ui.components.input-text', [
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

    <button type="submit" class="ui right floated blue button"><i class="check icon"></i>{{ __('Simpan') }}</button>

</form>