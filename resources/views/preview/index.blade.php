@extends('layouts.semantic-ui.blank-3')

@section('content')

    <div class="ui fluid clearing segment green raised">

        @component('preview.component.'.$name)
        @endcomponent

        <a class="ui right floated primary button" href="{{ $downloadLink }}" style="margin-right: 4px">
            <i class="download icon"></i>
            Unduh
        </a>
        <a class="ui right floated primary button" target="_blank" href="{{ $printLink }}" style="margin-right: 4px">
            <i class="print icon"></i>
            Cetak
        </a>

    </div>

@endsection