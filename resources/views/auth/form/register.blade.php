<form class="ui form" action="{{ route('register') }}" method="post">

    <a class="ui green ribbon label ribbon-sub-segment">{{ __('Detail Instansi / Laboratorium') }}</a>

    @csrf

    <div class="three fields">

        @component('layouts.semantic-ui.components.input-text', [
            'name' => 'laboratory[name]',
            'old' => 'laboratory.name',
            'hasError' => $errors->has('laboratory.name'),
            'label' => 'Nama Instansi / Laboratorium',
            'placeholder' => 'Isi nama instansi / laboratorium',
            'required' => true,
        ])
        @endcomponent

        @component('layouts.semantic-ui.components.input-select', [
            'name' => 'laboratory[type_id]',
            'old' => 'laboratory.type_id',
            'hasError' => $errors->has('laboratory.type_id'),
            'label' => 'Tipe Instansi',
            'placeholder' => '-- Pilih tipe instansi --',
            'items' => $optionsLaboratoryType,
            'required' => true,
        ])
        @endcomponent

        @component('layouts.semantic-ui.components.input-select', [
            'name' => 'laboratory[ownership_id]',
            'old' => 'laboratory.ownership_id',
            'hasError' => $errors->has('laboratory.ownership_id'),
            'label' => 'Kepemilikan Instansi',
            'placeholder' => '-- Pilih kepemilikan instansi --',
            'items' => $optionsLaboratoryOwnership,
            'required' => true,
        ])
        @endcomponent

    </div>

    <div class="two fields">

        @component('layouts.semantic-ui.components.input-text', [
            'name' => 'laboratory[email]',
            'old' => 'laboratory.email',
            'hasError' => $errors->has('laboratory.email'),
            'label' => 'Email Instansi',
            'placeholder' => 'Isi email instansi',
            'required' => true,
        ])
        @endcomponent

        @component('layouts.semantic-ui.components.input-text', [
            'name' => 'laboratory[phone_number]',
            'old' => 'laboratory.phone_number',
            'hasError' => $errors->has('laboratory.phone_number'),
            'label' => 'Nomor Telepon Instansi',
            'placeholder' => 'Isi nomor telepon instansi',
            'required' => true,
        ])
        @endcomponent

    </div>

    @component('layouts.semantic-ui.components.input-text', [
            'name' => 'laboratory[address]',
            'old' => 'laboratory.address',
            'hasError' => $errors->has('laboratory.address'),
            'label' => 'Alamat Instansi',
            'placeholder' => 'Isi alamat instansi',
            'required' => true,
        ])
    @endcomponent

    <div class="three fields">

        @component('layouts.semantic-ui.components.input-text', [
            'name' => 'laboratory[village]',
            'old' => 'laboratory.village',
            'hasError' => $errors->has('laboratory.village'),
            'label' => 'Kelurahan',
            'placeholder' => 'Isi kelurahan',
            'required' => true,
        ])
        @endcomponent

        @component('layouts.semantic-ui.components.input-text', [
            'name' => 'laboratory[district]',
            'old' => 'laboratory.district',
            'hasError' => $errors->has('laboratory.district'),
            'label' => 'Kecamatan',
            'placeholder' => 'Isi kecamatan',
            'required' => true,
        ])
        @endcomponent

        @component('layouts.semantic-ui.components.input-text', [
            'name' => 'laboratory[city]',
            'old' => 'laboratory.city',
            'hasError' => $errors->has('laboratory.city'),
            'label' => 'Kota / Kabupaten',
            'placeholder' => 'Isi kota / kabupaten',
            'required' => true,
        ])
        @endcomponent

    </div>

    <div class="two fields">

        <div class="ten wide field">
            @component('layouts.semantic-ui.components.input-select', [
                'name' => 'laboratory[province_id]',
                'old' => 'laboratory.province_id',
                'hasError' => $errors->has('laboratory.province_id'),
                'label' => 'Provinsi',
                'placeholder' => '-- Pilih provinsi --',
                'items' => $optionsProvince,
                'required' => true,
            ])
            @endcomponent
        </div>

        <div class="six wide field">
            @component('layouts.semantic-ui.components.input-text', [
                'name' => 'laboratory[postal_code]',
                'old' => 'laboratory.postal_code',
                'hasError' => $errors->has('laboratory.postal_code'),
                'label' => 'Kode Pos',
                'placeholder' => 'Isi kode pos instansi',
                'required' => true,
            ])
            @endcomponent
        </div>

    </div>

    <a class="ui green ribbon label ribbon-sub-segment">{{ __('Detail Personil Penghubung') }}</a>

    <div class="two fields">

            @component('layouts.semantic-ui.components.input-text', [
                'name' => 'user[name]',
                'old' => 'user.name',
                'hasError' => $errors->has('user.name'),
                'label' => 'Nama Personil Penghubung',
                'placeholder' => 'Isi nama personil penghubung',
                'required' => true,
            ])
            @endcomponent

            @component('layouts.semantic-ui.components.input-text', [
                'name' => 'laboratory[user_position]',
                'old' => 'laboratory.user_position',
                'hasError' => $errors->has('laboratory.user_position'),
                'label' => 'Jabatan Personil Penghubung',
                'placeholder' => 'Isi jabatan personil penghubung',
                'required' => true,
            ])
            @endcomponent

    </div>

    <div class="two fields">

            @component('layouts.semantic-ui.components.input-text', [
                'name' => 'user[email]',
                'old' => 'user.email',
                'hasError' => $errors->has('user.email'),
                'label' => 'Email Personil Penghubung',
                'placeholder' => 'Isi email personil penghubung',
                'required' => true,
            ])
            @endcomponent

            @component('layouts.semantic-ui.components.input-text', [
                'name' => 'user[phone_number]',
                'old' => 'user.phone_number',
                'hasError' => $errors->has('user.phone_number'),
                'label' => 'Nomor Telepon Personil Penghubung',
                'placeholder' => 'Isi nomor telepon personil penghubung',
                'required' => true,
            ])
            @endcomponent

    </div>

    <div class="field">

        <div class="ui checkbox">
            <input type="checkbox" name="acceptance[]" required>
            <label>{{ __('Saya bertanggung jawab atas kebenaran data yang Saya isi di atas.') }}</label>
        </div>

    </div>

    <button type="submit" class="ui blue button right floated">
        <i class="check icon"></i>
        {{ __('Register') }}
    </button>

</form>