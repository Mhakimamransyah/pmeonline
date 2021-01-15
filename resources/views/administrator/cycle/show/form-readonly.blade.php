<div class="ui form">

    @csrf

    <div class="ui two fields">

        @component('layouts.semantic-ui.components.input-text-readonly', [
            'name' => 'name',
            'old' => 'name',
            'label' => 'Nama Siklus',
            'placeholder' => 'Isi nama siklus',
            'value' => $cycle->name,
            'required' => true,
        ])
        @endcomponent

        @component('layouts.semantic-ui.components.input-text-readonly', [
            'name' => 'year',
            'old' => 'year',
            'type' => 'number',
            'label' => 'Tahun',
            'placeholder' => 'Isi tahun',
            'value' => $cycle->year,
            'required' => true,
        ])
        @endcomponent

    </div>

    <div class="ui two fields">

        @component('layouts.semantic-ui.components.input-text-readonly', [
            'name' => 'start_registration_date',
            'old' => 'start_registration_date',
            'label' => 'Pendaftaran Dibuka',
            'placeholder' => 'Isi tanggal pendaftaran dibuka',
            'value' => $cycle->getStartRegistrationDate()->formatLocalized('%e %B %Y'),
            'required' => true,
            'type' => 'date',
        ])
        @endcomponent

        @component('layouts.semantic-ui.components.input-text-readonly', [
            'name' => 'end_registration_date',
            'old' => 'end_registration_date',
            'label' => 'Pendaftaran Ditutup',
            'placeholder' => 'Isi tanggal pendaftaran ditutup',
            'value' => $cycle->getEndRegistrationDate()->formatLocalized('%e %B %Y'),
            'required' => true,
            'type' => 'date',
        ])
        @endcomponent

    </div>

    <div class="ui two fields">

        @component('layouts.semantic-ui.components.input-text-readonly', [
            'name' => 'start_submit_date',
            'old' => 'start_submit_date',
            'label' => 'Pengisian Dibuka',
            'placeholder' => 'Isi tanggal pengisian dibuka',
            'value' => $cycle->getStartSubmitDate()->formatLocalized('%e %B %Y'),
            'required' => true,
            'type' => 'date',
        ])
        @endcomponent

        @component('layouts.semantic-ui.components.input-text-readonly', [
            'name' => 'end_submit_date',
            'old' => 'end_submit_date',
            'label' => 'Pengisian Ditutup',
            'placeholder' => 'Isi tanggal pengisian ditutup',
            'value' => $cycle->getEndSubmitDate()->formatLocalized('%e %B %Y'),
            'required' => true,
            'type' => 'date',
        ])
        @endcomponent

    </div>

    <button disabled type="submit" class="ui right floated green button"><i class="check icon"></i>{{ __('Siklus Sudah Berjalan') }}</button>

</div>