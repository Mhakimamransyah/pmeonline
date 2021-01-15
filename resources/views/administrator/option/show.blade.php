@php
    $has_opts = false;
@endphp

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

            <div class="ui raised segments">

                <div class="ui segment green">

                    <a class="ui green ribbon label ribbon-sub-segment">{{ __($option->getTitle()) }}</a>

                    <br/>

                    <a class="ui label"><i class="ui table icon"></i>{{ $option->getTableName() }}</a>

                    <br/>
                    <br/>

                    <table class="ui striped small table data-tables">
                        <thead>
                        <tr>
                            <th style="width: 5%">
                                {{ __('#') }}
                            </th>
                            <th style="width: 10%">
                                {{ __('Value') }}
                            </th>
                            <th style="width: 55%">
                                {{ __('Text') }}
                            </th>
                            @for($i=1; $i<=2; $i++)
                                <th style="width: 15%">
                                    {{ __('Opt #'.$i) }}
                                </th>
                            @endfor
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td class="ui center aligned">{{ __($item->getId()) }}</td>
                                <td><a href="{{ route('administrator.option.table.item', ['table' => $option->getTableName(), 'id' => $item->getId(), 'table_id' => request('id')]) }}">{{ __($item->getValue()) }}</a></td>
                                <td>{{ __($item->getText()) }}</td>
                                @if(isset($item->opt_1))
                                    @for($i=1; $i<=2; $i++)
                                        @php
                                            $has_opts = true;
                                        @endphp
                                        <td>
                                            {{ $item->{'opt_'.$i} ?? '-' }}
                                        </td>
                                    @endfor
                                @else
                                    <td class="center aligned"><i>Tidak tersedia</i></td>
                                    <td class="center aligned"><i>Tidak tersedia</i></td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>

                <div class="ui clearing segment">

                    <button class="ui blue button right floated" onclick="showCreateOptionModal()">
                        <i class="plus icon"></i>
                        {{ __('Tambah Pilihan ' . $option->getTitle() . ' Baru') }}
                    </button>

                    <br/>
                    <br/>
                    <br/>

                    <button class="ui negative button right floated" onclick="showDeleteOptionModal()">
                        <i class="delete icon"></i>
                        {{ __('Hapus Daftar Pilihan ' . $option->getTitle()) }}
                    </button>

                </div>

            </div>

        </div>

    </div>


    <div class="ui modal" id="create-option-modal">

        <div class="header">{{ __('Tambah Pilihan ' . $option->getTitle() . ' Baru') }}</div>

        <div class="content">

            <form id="create-option-form" class="ui form" method="post" action="{{ route('administrator.option.item.create', ['table_name' => $option->getTableName()]) }}">

                @csrf

                <div class="ui two fields">

                    @component('layouts.semantic-ui.components.input-text', [
                        'name' => 'value',
                        'old' => 'value',
                        'type' => 'text',
                        'label' => 'Value',
                        'placeholder' => 'Isi value',
                        'required' => true,
                    ])
                    @endcomponent

                    @component('layouts.semantic-ui.components.input-text', [
                        'name' => 'text',
                        'old' => 'text',
                        'type' => 'text',
                        'label' => 'Text',
                        'placeholder' => 'Isi text',
                        'required' => true,
                    ])
                    @endcomponent

                </div>

                @if($has_opts)

                    @for($i = 1; $i <= 10;)

                        <div class="ui two fields">

                            @component('layouts.semantic-ui.components.input-text', [
                                'name' => 'opt_'.$i,
                                'old' => 'opt_'.$i,
                                'type' => 'text',
                                'label' => 'Opt #'.$i,
                                'placeholder' => 'Isi opt#'.$i,
                            ])
                            @endcomponent

                            @php($i++)

                            @component('layouts.semantic-ui.components.input-text', [
                                'name' => 'opt_'.$i,
                                'old' => 'opt_'.$i,
                                'type' => 'text',
                                'label' => 'Opt #'.$i,
                                'placeholder' => 'Isi opt#'.$i,
                            ])
                            @endcomponent

                            @php($i++)

                        </div>

                    @endfor

                @endif

            </form>

        </div>

        <div class="actions">

            <button class="ui positive right labeled icon button" type="submit" form="create-option-form">
                {{ __('Simpan') }}
                <i class="check icon"></i>
            </button>

        </div>
    </div>

    <div class="ui modal" id="delete-option-modal">

        <div class="header">{{ __('Hapus Daftar Pilihan ' . $option->getTitle()) }}</div>

        <div class="content">

            <div class="ui message negative">
                <p>Anda yakin hendak menghapus daftar pilihan {{ $option->getTitle() }}?</p><p><strong>Perintah ini tidak dapat dibatalkan setelah dijalankan.</strong></p>
            </div>

            <form id="delete-option" method="POST" action="{{ route('administrator.option.delete', ['option' => $option->id]) }}"> @csrf </form>

        </div>

        <div class="actions">

            <button class="ui negative right labeled icon button" form="delete-option" type="submit">
                {{ __('Hapus') }}
                <i class="delete icon"></i>
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
        function showDeleteOptionModal() {
            $('#delete-option-modal')
                .modal('show');
        }
    </script>

@endsection