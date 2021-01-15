@csrf

<div class="ui two fields">

    @component('layouts.semantic-ui.components.input-text', [
        'name' => 'name',
        'old' => 'name',
        'label' => 'Nama Siklus',
        'placeholder' => 'Isi nama siklus',
        'required' => true,
    ])
    @endcomponent

    @component('layouts.semantic-ui.components.input-text', [
        'name' => 'year',
        'old' => 'year',
        'type' => 'number',
        'label' => 'Tahun',
        'placeholder' => 'Isi tahun',
        'required' => true,
    ])
    @endcomponent

</div>

<div class="ui two fields">

    @component('layouts.semantic-ui.components.input-text', [
        'name' => 'start_registration_date',
        'old' => 'start_registration_date',
        'label' => 'Pendaftaran Dibuka',
        'placeholder' => 'Isi tanggal pendaftaran dibuka',
        'required' => true,
        'type' => 'date',
    ])
    @endcomponent

    @component('layouts.semantic-ui.components.input-text', [
        'name' => 'end_registration_date',
        'old' => 'end_registration_date',
        'label' => 'Pendaftaran Ditutup',
        'placeholder' => 'Isi tanggal pendaftaran ditutup',
        'required' => true,
        'type' => 'date',
    ])
    @endcomponent

</div>

<div class="ui two fields">

    @component('layouts.semantic-ui.components.input-text', [
        'name' => 'start_submit_date',
        'old' => 'start_submit_date',
        'label' => 'Pengisian Dibuka',
        'placeholder' => 'Isi tanggal pengisian dibuka',
        'required' => true,
        'type' => 'date',
    ])
    @endcomponent

    @component('layouts.semantic-ui.components.input-text', [
        'name' => 'end_submit_date',
        'old' => 'end_submit_date',
        'label' => 'Pengisian Ditutup',
        'placeholder' => 'Isi tanggal pengisian ditutup',
        'required' => true,
        'type' => 'date',
    ])
    @endcomponent

</div>