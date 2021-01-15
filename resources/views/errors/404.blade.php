@extends('layouts.semantic-ui.blank')

@section('content')
    <div class="ui error clearing message segment" style="margin-top: 64px;">
        <div class="header">
            {{ __('Tidak Ditemukan') }}
        </div>
        {{ __('Permintaan Anda tidak dapat diproses karena kami tidak menemukan apa yang Anda cari.') }}
        <br/>
        <a class="ui button right floated" href="{{ url()->previous() }}" style="text-decoration: none !important;">
            <i class="chevron left icon"></i>
            {{ __('Kembali') }}
        </a>
    </div>
@endsection