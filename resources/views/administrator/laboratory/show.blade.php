@extends('layouts.semantic-ui.dashboard')

@section('content')

    <div class="medium-form">

        <div class="medium-form-content">

            <div class="ui clearing raised segment">

                <a class="ui green ribbon label ribbon-sub-segment">{{ __('Detail Laboratorium') }}</a>

                <div class="ui form">

                    <div class="ui three fields">

                        @component('layouts.semantic-ui.components.input-text-readonly', [
                            'name' => 'name',
                            'label' => 'Nama Instansi / Laboratorium',
                            'placeholder' => 'Nama instansi / laboratorium',
                            'value' => $laboratory->name,
                        ])
                        @endcomponent

                        @component('layouts.semantic-ui.components.input-text-readonly', [
                            'name' => 'type_id',
                            'label' => 'Tipe Instansi',
                            'placeholder' => 'Tipe Instansi',
                            'value' => $laboratory->type->name,
                        ])
                        @endcomponent

                        @component('layouts.semantic-ui.components.input-text-readonly', [
                            'name' => 'ownership_id',
                            'label' => 'Kepemilikan Instansi',
                            'placeholder' => 'Kepemilikan Instansi',
                            'value' => $laboratory->ownership->name,
                        ])
                        @endcomponent

                    </div>

                    <div class="ui two fields">

                        @component('layouts.semantic-ui.components.input-text-readonly', [
                            'name' => 'email',
                            'label' => 'Email Instansi',
                            'placeholder' => 'Email instansi',
                            'value' => $laboratory->email,
                        ])
                        @endcomponent

                        @component('layouts.semantic-ui.components.input-text-readonly', [
                            'name' => 'phone_number',
                            'label' => 'Nomor Telepon Instansi',
                            'placeholder' => 'Nomor telepon instansi',
                            'value' => $laboratory->phone_number,
                        ])
                        @endcomponent

                    </div>

                    @component('layouts.semantic-ui.components.input-text-readonly', [
                            'name' => 'address',
                            'label' => 'Alamat Instansi',
                            'placeholder' => 'Alamat instansi',
                            'value' => $laboratory->address,
                        ])
                    @endcomponent

                    <div class="ui three fields">

                        @component('layouts.semantic-ui.components.input-text-readonly', [
                            'name' => 'village',
                            'label' => 'Kelurahan',
                            'placeholder' => 'Kelurahan',
                            'value' => $laboratory->village,
                        ])
                        @endcomponent

                        @component('layouts.semantic-ui.components.input-text-readonly', [
                            'name' => 'district',
                            'label' => 'Kecamatan',
                            'placeholder' => 'Kecamatan',
                            'value' => $laboratory->district,
                        ])
                        @endcomponent

                        @component('layouts.semantic-ui.components.input-text-readonly', [
                            'name' => 'city',
                            'label' => 'Kota / Kabupaten',
                            'placeholder' => 'Kota / kabupaten',
                            'value' => $laboratory->city,
                        ])
                        @endcomponent

                    </div>

                    <div class="ui two fields">

                        <div class="twelve wide field">

                            @component('layouts.semantic-ui.components.input-text-readonly', [
                                'name' => 'province_id',
                                'label' => 'Provinsi',
                                'placeholder' => 'Provinsi',
                                'value' => $laboratory->province->name,
                            ])
                            @endcomponent

                        </div>

                        <div class="four wide field">

                            @component('layouts.semantic-ui.components.input-text-readonly', [
                                'name' => 'postal_code',
                                'label' => 'Kode Pos',
                                'placeholder' => 'Kode pos instansi',
                                'value' => $laboratory->postal_code,
                            ])
                            @endcomponent

                        </div>

                    </div>

                </div>

            </div>

            <div class="ui clearing raised segment clearing">

                <a class="ui green ribbon label ribbon-sub-segment">{{ __('Kode Peserta') }}</a>

                <form class="ui form" method="post" action="{{ route('administrator.laboratory.update-participant-number', ['laboratory' => $laboratory->id]) }}">

                    @csrf

                    @component('layouts.semantic-ui.components.input-text', [
                        'name' => 'participant_number',
                        'label' => 'Kode Peserta',
                        'placeholder' => $laboratory->participant_number,
                        'old' => 'participant_number',
                        'value' => $laboratory->attributes['participant_number'],
                    ])
                    @endcomponent

                    <button type="submit" class="ui primary button right floated">
                        <i class="check icon"></i>
                        {{ 'Simpan Kode Peserta' }}
                    </button>

                </form>

            </div>

        </div>

    </div>

@endsection
