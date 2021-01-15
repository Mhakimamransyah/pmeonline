<form class="ui form" method="post" action="{{ route('administrator.cycle.update', ['id' => $cycle->getId()]) }}">

    @csrf

    <div class="ui two fields">

        @component('layouts.semantic-ui.components.input-text', [
            'name' => 'name',
            'old' => 'name',
            'label' => 'Nama Siklus',
            'placeholder' => 'Isi nama siklus',
            'value' => $cycle->name,
            'required' => true,
        ])
        @endcomponent

        @component('layouts.semantic-ui.components.input-text', [
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

        @component('layouts.semantic-ui.components.input-text', [
            'name' => 'start_registration_date',
            'old' => 'start_registration_date',
            'label' => 'Pendaftaran Dibuka',
            'placeholder' => 'Isi tanggal pendaftaran dibuka',
            'value' => $cycle->getStartRegistrationDate()->format('Y-m-d'),
            'required' => true,
            'type' => 'date',
        ])
        @endcomponent

        @component('layouts.semantic-ui.components.input-text', [
            'name' => 'end_registration_date',
            'old' => 'end_registration_date',
            'label' => 'Pendaftaran Ditutup',
            'placeholder' => 'Isi tanggal pendaftaran ditutup',
            'value' => $cycle->getEndRegistrationDate()->format('Y-m-d'),
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
            'value' => $cycle->getStartSubmitDate()->format('Y-m-d'),
            'required' => true,
            'type' => 'date',
        ])
        @endcomponent

        @component('layouts.semantic-ui.components.input-text', [
            'name' => 'end_submit_date',
            'old' => 'end_submit_date',
            'label' => 'Pengisian Ditutup',
            'placeholder' => 'Isi tanggal pengisian ditutup',
            'value' => $cycle->getEndSubmitDate()->format('Y-m-d'),
            'required' => true,
            'type' => 'date',
        ])
        @endcomponent

    </div>

    <button type="submit" class="ui right floated blue button"><i class="check icon"></i>{{ __('Simpan') }}</button>

</form>