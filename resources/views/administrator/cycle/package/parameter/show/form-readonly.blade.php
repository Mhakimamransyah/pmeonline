<div class="ui form">

    @csrf

    <div class="ui two fields">

        @component('layouts.semantic-ui.components.input-text-readonly', [
            'name' => 'label',
            'old' => 'label',
            'type' => 'text',
            'label' => 'Nama Parameter',
            'placeholder' => 'Isi nama parameter',
            'value' => $parameter->getLabel(),
            'required' => true,
        ])
        @endcomponent

        @component('layouts.semantic-ui.components.input-text-readonly', [
            'name' => 'unit',
            'old' => 'unit',
            'type' => 'text',
            'label' => 'Satuan',
            'placeholder' => 'Isi satuan',
            'value' => $parameter->getUnit(),
        ])
        @endcomponent

    </div>

    <button disabled type="submit" class="ui right floated green button"><i class="check icon"></i>{{ __('Siklus Sudah Berjalan') }}</button>

</div>