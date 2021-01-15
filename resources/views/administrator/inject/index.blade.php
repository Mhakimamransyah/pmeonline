@extends('layouts.semantic-ui.dashboard')

@section('content')

    <div class="medium-form">

        <div class="medium-form-content">

            <div class="ui raised green clearing segment">

                <a class="ui green ribbon label">{{ 'Kaitan Daftar ke Paket' }}</a>

                @component('administrator.component.select-package')
                @endcomponent

                @if(request()->has('package_id'))
                    <div class="ui section divider"></div>


                    <table class="table celled ui data-tables">
                        <thead>
                        <tr>
                            <th style="width: 50%">{{ 'Nama Daftar' }}</th>
                            <th style="width: 50%">{{ 'Table Daftar' }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($injects as $inject)
                            <tr>
                                <td><a href="{{ route('administrator.inject.show', ['inject' => $inject->id]) }}">{{ $inject->name }}</a></td>
                                <td><a href="{{ route('administrator.option.show', ['id' => $inject->option_id]) }}">{{ $inject->option->title }}</a><br/>
                                    <a class="ui label" style="margin-top: 6px"><i class="ui table icon"></i>{{ $inject->option->table_name }}</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <button type="button" onclick="showCreateInjectModal()" class="ui primary button right floated"><i class="plus icon"></i>{{ 'Tambah Keterkaitan' }}</button>
                @endif

            </div>

        </div>

    </div>

    @if(request()->has('package_id'))

        <div class="ui modal" id="create-modal">

            <div class="header">{{ __('Tambah Keterkaitan') }}</div>

            <div class="content">

                <form id="create-inject-form" class="ui form" method="post" action="{{ route('administrator.inject.store', ['package_id' => request()->get('package_id')]) }}">

                    @csrf

                    <div class="two fields">

                        @component('layouts.semantic-ui.components.input-text', [
                            'name' => 'name',
                            'old' => 'name',
                            'type' => 'text',
                            'label' => 'Nama',
                            'placeholder' => 'Isi nama',
                            'required' => true,
                        ])
                        @endcomponent

                        <div class="field @if(isset($hasError) && $hasError) error @endif">
                            <label for="input-option">{{ 'Daftar Pilihan' }}</label>
                            <select id="input-option" class="ui search fluid dropdown" name="option_id" required>
                                <option value="">Pilih daftar pilihan</option>
                                @foreach($options as $item)
                                    <option value="{{ $item->id }}" @if(old('option_id') == $item->id) selected="" @endif>{{ $item->title }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                </form>

            </div>

            <div class="actions">

                <button class="ui positive right labeled icon button" type="submit" form="create-inject-form">
                    {{ __('Tambah Keterkaitan') }}
                    <i class="plus icon"></i>
                </button>

            </div>

        </div>

    @endif

@endsection


@section('script')

    @component('administrator.component.select-package-js')
    @endcomponent

    <script src="{{ asset('data-tables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('data-tables/dataTables.semanticui.min.js') }}"></script>

    @if(request()->has('package_id'))
        <script>
            function showCreateInjectModal() {
                $('#create-modal')
                    .modal({
                        onApprove: function () {
                            return false;
                        }
                    })
                    .modal('show')
                ;
            }
        </script>
    @endif

@endsection