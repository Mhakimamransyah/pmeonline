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

                    <a class="ui green ribbon label ribbon-sub-segment">Ubah Pilihan</a>

                    <br/>
                    @foreach($schedule as $item)
                    <form id="create-option-form" class="ui form" method="post" action="{{ route('administrator.schedule.update', ['table' => request('table'), 'id' => request('id'), 'table_id' => request('table_id'),]) }}">

                        @csrf

                        <div class="ui three fields">

                            @component('layouts.semantic-ui.components.input-text', [
                                'name' => 'kegiatan',
                                'old' => 'kegiatan',
                                'type' => 'text',
                                'label' => 'Kegiatan',
                                'placeholder' => 'Isi kegiatan',
                                'value' => $item->kegiatan,
                                'required' => true,
                            ])
                            @endcomponent

                            @component('layouts.semantic-ui.components.input-text', [
                                'name' => 'siklus_1',
                                'old' => 'siklus_1',
                                'type' => 'text',
                                'value' => $item->siklus_1,
                                'label' => 'Siklus 1',
                                'placeholder' => 'Isi Siklus 1',
                                'required' => true,
                            ])
                            @endcomponent

                            @component('layouts.semantic-ui.components.input-text', [
                                'name' => 'siklus_2',
                                'old' => 'siklus_2',
                                'type' => 'text',
                                'value' => $item->siklus_2,
                                'label' => 'Siklus 2',
                                'placeholder' => 'Isi Siklus 2',
                                'required' => true,
                            ])
                            @endcomponent

                        </div>
                   
                    @endforeach
                       
                </div>

                <div class="ui clearing segment">

                    <button class="ui blue button right floated" type="submit" form="create-option-form">
                        <i class="save icon"></i>
                        {{ __('Simpan Jadwal') }}
                    </button>

                </div>
             </form>
            </div>

        </div>

    </div>

@endsection
