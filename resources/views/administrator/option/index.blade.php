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

                    <a class="ui green ribbon label ribbon-sub-segment">{{ __('Daftar Pilihan') }}</a>

                    <table class="ui striped table data-tables">
                        <thead>
                        <tr>
                            <th width="5%">
                                {{ __('#') }}
                            </th>
                            <th>
                                {{ __('Daftar Pilihan') }}
                            </th>
                            <th>
                                {{ __('Nama Tabel') }}
                            </th>
                            <th>
                                {{ __('Jumlah Pilihan') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($options as $option)
                            <tr>
                                <td class="ui center aligned">{{ __($option->getId()) }}</td>
                                <td><a href="{{ route('administrator.option.show', ['id' => $option->getId()]) }}">{{ __($option->getTitle()) }}</a></td>
                                <td>{{ __($option->getTableName()) }}</td>
                                @if (\Illuminate\Support\Facades\Schema::hasTable($option->getTableName()))
                                    <td class="right aligned" id="count">{{ \Illuminate\Support\Facades\DB::table($option->getTableName())->count() }}</td>
                                @else
                                    <td class="negative"><i class="attention icon"></i> {{ __('Tabel Tidak Ditemukan') }}</td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>

                <div class="ui clearing segment">

                    <button class="ui blue button right floated" onclick="showCreateOptionModal()">
                        <i class="plus icon"></i>
                        {{ __('Buat Daftar Pilihan') }}
                    </button>
                    <br/>
                    <br/>
                    <br/>
                    <a class="ui button right floated" href="{{ route('administrator.option.laboratory-type.index') }}">
                        <i class="list icon"></i>
                        {{ __('Daftar Pilihan Tipe Instansi') }}
                    </a>

                </div>

            </div>

        </div>

    </div>


    <div class="ui modal" id="create-option-modal">

        <div class="header">{{ __('Buat Daftar Pilihan') }}</div>

        <div class="content">

            <form id="create-option-form" class="ui form" method="post" action="{{ route('administrator.option.create') }}">

                @csrf

                @component('layouts.semantic-ui.components.input-text', [
                    'name' => 'title',
                    'old' => 'title',
                    'type' => 'text',
                    'label' => 'Judul Pilihan',
                    'placeholder' => 'Isi judul pilihan',
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