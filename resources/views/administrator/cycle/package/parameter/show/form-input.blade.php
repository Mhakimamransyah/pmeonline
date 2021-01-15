<form class="ui form" method="post" action="{{ route('administrator.cycle.package.parameter.update', ['id' => $parameter->getId()]) }}">

    @csrf

    <div class="ui two fields">

        @component('layouts.semantic-ui.components.input-text', [
            'name' => 'label',
            'old' => 'label',
            'type' => 'text',
            'label' => 'Nama Parameter',
            'placeholder' => 'Isi nama parameter',
            'value' => $parameter->getLabel(),
            'required' => true,
        ])
        @endcomponent

        @component('layouts.semantic-ui.components.input-text', [
            'name' => 'unit',
            'old' => 'unit',
            'type' => 'text',
            'label' => 'Satuan',
            'placeholder' => 'Isi satuan',
            'value' => $parameter->getUnit(),
        ])
        @endcomponent

    </div>

    <button type="submit" class="ui right floated blue button"><i class="check icon"></i>{{ __('Simpan') }}</button>

</form>