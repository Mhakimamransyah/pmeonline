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

            <div class="ui segments">

                <div class="ui segment">

                    <a class="ui green ribbon label ribbon-sub-segment">{{ __('Tipe Instansi') }}</a>

                    <table class="ui striped table data-tables">
                        <thead>
                        <tr>
                            <th width="5%">
                                {{ __('#') }}
                            </th>
                            <th>
                                {{ __('Tipe Instansi') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($laboratoryTypes as $type)
                            <tr>
                                <td class="ui center aligned">{{ __($type->getId()) }}</td>
                                <td><a href="{{ route('administrator.option.laboratory-type.show', ['id' => $type->getId()]) }}">{{ __($type->getName()) }}</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>

                <div class="ui clearing segment">

                    <button class="ui blue button right floated" onclick="showCreateOptionModal()">
                        <i class="plus icon"></i>
                        {{ __('Tambah Tipe Instansi') }}
                    </button>

                </div>

            </div>

        </div>

    </div>


    <div class="ui small modal" id="create-option-modal">

        <div class="header">{{ __('Tambah Tipe Instansi') }}</div>

        <div class="content">

            <form id="create-option-form" class="ui form" method="post" action="{{ route('administrator.option.laboratory-type.create') }}">

                @csrf

                @component('layouts.semantic-ui.components.input-text', [
                    'name' => 'name',
                    'old' => 'name',
                    'type' => 'text',
                    'label' => 'Tipe Instansi',
                    'placeholder' => 'Isi tipe instansi',
                    'required' => true,
                ])
                @endcomponent

            </form>

        </div>

        <div class="actions">

            <button class="ui positive right labeled icon button" type="submit" form="create-option-form">
                {{ __('Simpan') }}
                <i class="check icon"></i>
            </button>

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