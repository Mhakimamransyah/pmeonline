@csrf

<div class="ui two fields">

    @component('layouts.semantic-ui.components.input-text', [
        'name' => 'label',
        'old' => 'label',
        'type' => 'text',
        'label' => 'Nama Parameter',
        'placeholder' => 'Isi nama parameter',
        'required' => true,
    ])
    @endcomponent

    @component('layouts.semantic-ui.components.input-text', [
        'name' => 'unit',
        'old' => 'unit',
        'type' => 'text',
        'label' => 'Satuan',
        'placeholder' => 'Isi satuan',
    ])
    @endcomponent

</div>