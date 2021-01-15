@extends('layouts.semantic-ui.dashboard')

@section('content')

    <div class="ui segment clearing info message">
        <div class="header">
            Lakukan Perhitungan
        </div>
        <p>
            Klik tombol untuk memulai perhitungan.
        </p>
        <form class="ui form" method="post" action="{{ route('installation.scoring.auto-calculate') }}">
            @csrf
            <div class="ui field">
                <label for="input-cycle">Siklus</label>
                <select id="input-cycle" class="ui search fluid dropdown" name="cycle_id">
                    <option value="">Pilih Siklus</option>
                    @foreach($cycles as $cycle)
                        <option @if(request()->get('cycle_id') == $cycle->id) selected @endif value="{{ $cycle->id }}">{{ $cycle->name }}</option>
                    @endforeach
                </select>
            </div>
            <button class="right floated ui button primary" type="submit">Lakukan Perhitungan</button>
        </form>
    </div>

@endsection
