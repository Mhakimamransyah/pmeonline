@extends('layouts.semantic-ui.dashboard')

@section('content')

    <div class="medium-form">

        <div class="medium-form-content ui clearing segment">

            <a class="ui green ribbon label ribbon-sub-segment">{{ __('Detail Laboratorium') }}</a>

            <form class="ui form" action="{{ route('participant.laboratory.update', ['id' => $laboratory->id]) }}" method="post">

                @csrf

                <div class="ui three fields">

                    @component('layouts.semantic-ui.components.input-text', [
                        'name' => 'name',
                        'old' => 'name',
                        'label' => 'Nama Instansi / Laboratorium',
                        'placeholder' => 'Isi nama instansi / laboratorium',
                        'value' => $laboratory->name,
                        'required' => true,
                    ])
                    @endcomponent

                    @component('layouts.semantic-ui.components.input-select', [
                        'name' => 'type_id',
                        'old' => 'type_id',
                        'label' => 'Tipe Instansi',
                        'items' => $optionsLaboratoryType,
                        'selected' => $laboratory->type->id,
                        'required' => true,
                    ])
                    @endcomponent

                    @component('layouts.semantic-ui.components.input-select', [
                        'name' => 'ownership_id',
                        'old' => 'ownership_id',
                        'label' => 'Kepemilikan Instansi',
                        'items' => $optionsLaboratoryOwnership,
                        'selected' => $laboratory->ownership->id,
                        'required' => true,
                    ])
                    @endcomponent

                </div>

                <div class="ui two fields">

                    @component('layouts.semantic-ui.components.input-text', [
                        'name' => 'email',
                        'old' => 'email',
                        'label' => 'Email Instansi',
                        'placeholder' => 'Isi email instansi',
                        'value' => $laboratory->email,
                        'required' => true,
                    ])
                    @endcomponent

                    @component('layouts.semantic-ui.components.input-text', [
                        'name' => 'phone_number',
                        'old' => 'phone_number',
                        'label' => 'Nomor Telepon Instansi',
                        'placeholder' => 'Isi nomor telepon instansi',
                        'value' => $laboratory->phone_number,
                        'required' => true,
                    ])
                    @endcomponent

                </div>

                @component('layouts.semantic-ui.components.input-text', [
                        'name' => 'address',
                        'old' => 'address',
                        'label' => 'Alamat Instansi',
                        'placeholder' => 'Isi alamat instansi',
                        'value' => $laboratory->address,
                        'required' => true,
                    ])
                @endcomponent

                <div class="ui three fields">

                    @component('layouts.semantic-ui.components.input-text', [
                        'name' => 'village',
                        'old' => 'village',
                        'label' => 'Kelurahan',
                        'placeholder' => 'Isi kelurahan',
                        'value' => $laboratory->village,
                        'required' => true,
                    ])
                    @endcomponent

                    @component('layouts.semantic-ui.components.input-text', [
                        'name' => 'district',
                        'old' => 'district',
                        'label' => 'Kecamatan',
                        'placeholder' => 'Isi kecamatan',
                        'value' => $laboratory->district,
                        'required' => true,
                    ])
                    @endcomponent

                    @component('layouts.semantic-ui.components.input-text', [
                        'name' => 'city',
                        'old' => 'city',
                        'label' => 'Kota / Kabupaten',
                        'placeholder' => 'Isi kota / kabupaten',
                        'value' => $laboratory->city,
                        'required' => true,
                    ])
                    @endcomponent

                </div>

                <div class="ui two fields">

                    <div class="twelve wide field">

                        @component('layouts.semantic-ui.components.input-select', [
                            'name' => 'province_id',
                            'old' => 'province_id',
                            'label' => 'Provinsi',
                            'items' => $optionsProvince,
                            'selected' => $laboratory->province->id,
                            'required' => true,
                        ])
                        @endcomponent

                    </div>

                    <div class="four wide field">

                        @component('layouts.semantic-ui.components.input-text', [
                            'name' => 'postal_code',
                            'old' => 'postal_code',
                            'label' => 'Kode Pos',
                            'placeholder' => 'Isi kode pos instansi',
                            'value' => $laboratory->postal_code,
                            'required' => true,
                        ])
                        @endcomponent

                    </div>

                </div>

                <button type="submit" class="ui primary button right floated">
                    <i class="check icon"></i>
                    {{ __('Simpan') }}
                </button>

            </form>

        </div>

    </div>

@endsection
