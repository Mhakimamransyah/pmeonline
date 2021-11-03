@extends('layouts.semantic-ui.dashboard')

@section('content')
    @foreach($news as $news)
    <div class="ui clearing segment">

        <a class="ui green ribbon label">Pemberitahuan</a>

        <div class="ui divided items">
            <div class="ui item">
                <div class="content">
                    <img width="350px" src="{{ url('/data_file/'.$news->gambar) }}"> <br/>
                     <h3 class="header">{{ $news->title }}</h3> <br/>
                        {{ $news->body }} 
                    <div class="extra">
                        <a href="{{ route('participant.news.show', ['id' => $news->id]) }}" class="ui right floated button">
                            {{ __('Lihat Detail') }}
                            <i class="right chevron icon"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

@endsection