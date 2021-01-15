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

                    <a class="ui label"><i class="ui table icon"></i>{{ request('table') }}</a>

                    <br/>
                    <br/>

                    <form id="create-option-form" class="ui form" method="post" action="{{ route('administrator.option.table.item.update', ['table' => request('table'), 'id' => request('id'), 'table_id' => request('table_id'),]) }}">

                        @csrf

                        <div class="ui two fields">

                            @component('layouts.semantic-ui.components.input-text', [
                                'name' => 'value',
                                'old' => 'value',
                                'type' => 'text',
                                'label' => 'Value',
                                'placeholder' => 'Isi value',
                                'value' => $item->value,
                                'required' => true,
                            ])
                            @endcomponent

                            @component('layouts.semantic-ui.components.input-text', [
                                'name' => 'text',
                                'old' => 'text',
                                'type' => 'text',
                                'value' => $item->text,
                                'label' => 'Text',
                                'placeholder' => 'Isi text',
                                'required' => true,
                            ])
                            @endcomponent

                        </div>

                        @if(isset($item->opt_1))

                            @for($i = 1; $i <= 10;)

                                <div class="ui two fields">

                                    @component('layouts.semantic-ui.components.input-text', [
                                        'name' => 'opt_'.$i,
                                        'old' => 'opt_'.$i,
                                        'type' => 'text',
                                        'label' => 'Opt #'.$i,
                                        'placeholder' => 'Isi opt#'.$i,
                                        'value' => $item->{'opt_'.$i},
                                    ])
                                    @endcomponent

                                    @php($i++)

                                    @component('layouts.semantic-ui.components.input-text', [
                                        'name' => 'opt_'.$i,
                                        'old' => 'opt_'.$i,
                                        'type' => 'text',
                                        'value' => $item->{'opt_'.$i},
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

                <div class="ui clearing segment">

                    <button class="ui blue button right floated" type="submit" form="create-option-form">
                        <i class="save icon"></i>
                        {{ __('Simpan Pilihan') }}
                    </button>

                </div>

            </div>

        </div>

    </div>

@endsection
