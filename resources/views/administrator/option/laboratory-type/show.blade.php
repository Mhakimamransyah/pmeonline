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

    <div class="small-form">

        <div class="small-form-content">

            <div class="ui segments">

                <div class="ui clearing segment">

                    <a class="ui green ribbon label ribbon-sub-segment">{{ __($laboratoryType->getName()) }}</a>

                    <form id="create-option-form" class="ui form" method="post" action="{{ route('administrator.option.laboratory-type.update', ['id' => $laboratoryType->getId()]) }}">

                        @csrf

                        @component('layouts.semantic-ui.components.input-text', [
                            'name' => 'name',
                            'old' => 'name',
                            'type' => 'text',
                            'value' => $laboratoryType->getName(),
                            'label' => 'Tipe Instansi',
                            'placeholder' => 'Isi tipe instansi',
                            'required' => true,
                        ])
                        @endcomponent

                        <button class="ui button blue right floated"><i class="check icon"></i>{{ __('Simpan') }}</button>

                    </form>

                </div>

            </div>

        </div>

    </div>

@endsection

@section('script')

    @include('layouts.datatables.js')

    <script>
        function showCreateOptionModal() {
            $('#create-option-modal')
                .modal({
                    onApprove: function () {
                        return false;
                    }
                })
                .modal('show')
            ;
        }
    </script>

@endsection