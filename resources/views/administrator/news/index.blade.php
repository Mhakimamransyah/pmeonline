@extends('layouts.semantic-ui.dashboard')

@section('content')
  <div class="medium-form">

        <div class="medium-form-content">

            <div class="ui segments">

                <div class="ui segment">

                    <a class="ui green ribbon label ribbon-sub-segment">{{ __('Berita') }}</a>

                    <table class="ui striped table data-tables">
                        <thead>
                        <tr>
                            <th width="5%">
                                {{ __('#') }}
                            </th>
                            <th>
                                {{ __('Judul') }}
                            </th>
                            <th>
                                {{ __('File') }}
                            </th>
                            <th>
                                {{ __('Isi') }}
                            </th>
                            <th>
                                {{ __('Status') }}
                            </th>
                            <th>
                                {{ __('Opsi') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $no = 1; ?>
                        @foreach($news as $news)
                            <tr>
                                <td class="ui center aligned">{{ $no++ }}</td>
                                <td class="ui">{{ $news->title }}</td>
                                <td class="ui"><img width="150px" src="{{ url('/data_file/'.$news->gambar) }}"></td>
                                <td class="ui">{{ $news->body }}</td>
                                <td class="ui">{{ $news->active }}</td>
                                <td>
                                    <a href="{{ route('administrator.news.edit', ['id' => $news->id]) }}" title="Edit">
                                        <button class="ui circular blue button"><i class="edit icon"></i></button>
                                    </a>
                                    
                                    <a href="{{ route('administrator.news.destroy', ['id' => $news->id]) }}" title="Delete">
                                        <button class="ui circular red button"><i class="trash icon"></i></button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>

                <div class="ui clearing segment">

                    <button class="ui blue button right floated" onclick="showCreateNewsModal()">
                        <i class="plus icon"></i>
                        {{ __('Buat Berita') }}
                    </button>

                </div>

            </div>

        </div>

    </div>

    <div class="ui modal" id="create-news-modal">

        <div class="header">{{ __('Buat Berita') }}</div>

        <div class="content">

            <form id="create-news-form" class="ui form" method="post" action="{{ route('administrator.news.create') }}" enctype="multipart/form-data">

                @csrf

                @component('layouts.semantic-ui.components.input-text', [
                    'name' => 'title',
                    'old' => 'title',
                    'type' => 'text',
                    'label' => 'Judul',
                    'placeholder' => 'Isi Judul Berita',
                    'required' => true,
                ])
                @endcomponent

                @component('layouts.semantic-ui.components.input-text', [
                    'name' => 'gambar',
                    'old' => 'gambar',
                    'type' => 'file',
                    'label' => 'Gambar',
                    'placeholder' => 'Upload Gambar',
                    'required' => true,
                ])
                @endcomponent

                @component('layouts.semantic-ui.components.input-text', [
                    'name' => 'body',
                    'old' => 'body',
                    'type' => 'text',
                    'label' => 'Isi Berita',
                    'placeholder' => 'Isi Berita',
                    'required' => true,
                ])
                @endcomponent

                @component('layouts.semantic-ui.components.input-text', [
                    'name' => 'active',
                    'old' => 'active',
                    'type' => 'text',
                    'label' => 'Status',
                    'placeholder' => 'Isi Status',
                    'required' => true,
                ])
                @endcomponent

            </form>

        </div>

        <div class="actions">

            <button class="ui positive right labeled icon button" type="submit" form="create-news-form">
                {{ __('Simpan') }}
                <i class="check icon"></i>
            </button>

        </div>

    </div>
@endsection


@section('script')

      @include('layouts.datatables.js')

    <script>
        function showCreateNewsModal() {
            $('#create-news-modal')
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