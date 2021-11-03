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

                    <a class="ui green ribbon label ribbon-sub-segment">Ubah Berita</a>

                    <br/>
                    @foreach($news as $item)
                    <form id="create-option-form" class="ui form" method="post" action="{{ route('administrator.news.update', ['table' => request('table'), 'id' => request('id'), 'table_id' => request('table_id'),]) }}">

                        @csrf

                        <div class="ui three fields">

                            @component('layouts.semantic-ui.components.input-text', [
                                'name' => 'title',
                                'old' => 'title',
                                'type' => 'text',
                                'label' => 'Judul',
                                'placeholder' => 'Isi bidang',
                                'value' => $item->title,
                                'required' => true,
                            ])
                            @endcomponent

                            @component('layouts.semantic-ui.components.input-text', [
                                'name' => 'gambar',
                                'old' => 'gambar',
                                'type' => 'file',
                                'value' => $item->gambar,
                                'label' => 'Gambar',
                                'placeholder' => 'Isi Gambar',
                                'required' => true,
                            ])
                            @endcomponent

                            @component('layouts.semantic-ui.components.input-text', [
                                'name' => 'body',
                                'old' => 'body',
                                'type' => 'text',
                                'value' => $item->body,
                                'label' => 'Isi',
                                'placeholder' => 'Isi Surat',
                                'required' => true,
                            ])
                            @endcomponent

                            @component('layouts.semantic-ui.components.input-text', [
                                'name' => 'active',
                                'old' => 'active',
                                'type' => 'text',
                                'value' => $item->active,
                                'label' => 'Status',
                                'placeholder' => 'Isi Status',
                                'required' => true,
                            ])
                            @endcomponent

                        </div>
                   
                    @endforeach
                       
                </div>

                <div class="ui clearing segment">

                    <button class="ui blue button right floated" type="submit" form="create-option-form">
                        <i class="save icon"></i>
                        {{ __('Simpan Berita') }}
                    </button>

                </div>
             </form>
            </div>

        </div>

    </div>

@endsection
