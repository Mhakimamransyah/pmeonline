@extends('layouts.semantic-ui.dashboard')

@section('style')

    @include('layouts.datatables.css')

    <style>
        #count:after {
            content: 'Pilihan';
            margin-left: 6px;
        }
    </style>

@endsection

@section('content')

    <div class="medium-form">

        <div class="medium-form-content">

            <div class="ui segments raised">

                <div class="ui green segment">

                    <a class="ui green ribbon label ribbon-sub-segment">Ubah Tarif</a>

                    <br/>
                    @foreach($rate as $item)
                    <form id="create-option-form" class="ui form" method="post" action="{{ route('administrator.rate.update', ['table' => request('table'), 'id' => request('id'), 'table_id' => request('table_id'),]) }}">

                        @csrf

                        <div class="ui three fields">

                            @component('layouts.semantic-ui.components.input-text', [
                                'name' => 'bidang',
                                'old' => 'bidang',
                                'type' => 'text',
                                'label' => 'Bidang',
                                'placeholder' => 'Isi bidang',
                                'value' => $item->bidang,
                                'required' => true,
                            ])
                            @endcomponent

                            @component('layouts.semantic-ui.components.input-text', [
                                'name' => 'jmlsample',
                                'old' => 'jmlsample',
                                'type' => 'text',
                                'value' => $item->jmlsample,
                                'label' => 'Jumlah Sampel',
                                'placeholder' => 'Isi Jumlah Sampel',
                                'required' => true,
                            ])
                            @endcomponent

                            @component('layouts.semantic-ui.components.input-text', [
                                'name' => 'parameter',
                                'old' => 'parameter',
                                'type' => 'text',
                                'value' => $item->parameter,
                                'label' => 'Parameter',
                                'placeholder' => 'Isi Parameter',
                                'required' => true,
                            ])
                            @endcomponent

                            @component('layouts.semantic-ui.components.input-text', [
                                'name' => 'tarif',
                                'old' => 'tarif',
                                'type' => 'number',
                                'value' => $item->tarif,
                                'label' => 'Tarif',
                                'placeholder' => 'Isi Tarif',
                                'required' => true,
                            ])
                            @endcomponent

                        </div>
                   
                    @endforeach
                       
                </div>

                <div class="ui clearing segment">

                    <button class="ui blue button right floated" type="submit" form="create-option-form">
                        <i class="save icon"></i>
                        {{ __('Simpan Tarif') }}
                    </button>

                </div>
             </form>
            </div>

        </div>

    </div>

@endsection
