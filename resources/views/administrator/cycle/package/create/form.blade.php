@csrf

<div class="ui two fields">

    @component('layouts.semantic-ui.components.input-text', [
        'name' => 'label',
        'old' => 'label',
        'type' => 'text',
        'label' => 'Nama Paket',
        'placeholder' => 'Isi nama paket',
        'required' => true,
    ])
    @endcomponent

    @component('layouts.semantic-ui.components.input-text', [
        'name' => 'name',
        'old' => 'name',
        'type' => 'text',
        'label' => 'Kode Paket',
        'placeholder' => 'Isi kode paket',
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
        'required' => true,
    ])
    @endcomponent

    @component('layouts.semantic-ui.components.input-text', [
        'name' => 'quota',
        'old' => 'quota',
        'type' => 'number',
        'label' => 'Target Peserta',
        'placeholder' => 'Isi jumlah target peserta',
        'required' => true,
    ])
    @endcomponent

</div>