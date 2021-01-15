@extends('layouts.semantic-ui.blank')

@section('content')
    <div class="ui error clearing message segment" style="margin-top: 64px;">
        <div class="header">
            {{ __('Tidak Diizinkan') }}
        </div>
        {{ __('Permintaan Anda tidak dapat diproses karena Anda tidak memiliki izin untuk mengaksesnya.') }}
        <br/>
        <a class="ui button right floated" href="{{ url()->previous() }}" style="text-decoration: none !important;">
            <i class="chevron left icon"></i>
            {{ __('Kembali') }}
        </a>
    </div>
@endsection