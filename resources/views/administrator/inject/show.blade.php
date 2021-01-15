@extends('layouts.semantic-ui.dashboard')

@section('content')

    <div class="medium-form">

        <div class="medium-form-content">

            <div class="ui raised green clearing segment">

                <a class="ui green ribbon label ribbon-sub-segment">{{ $inject->name . ' Paket ' . $inject->package->label }}</a>

                <form id="main-form" class="ui form" method="post" action="{{ route('administrator.inject.update', ['inject' => $inject->id]) }}">

                    @csrf

                    <div class="two fields">

                        @component('layouts.semantic-ui.components.input-text', [
                            'name' => 'name',
                            'old' => 'name',
                            'type' => 'text',
                            'label' => 'Nama',
                            'placeholder' => 'Isi nama',
                            'required' => true,
                            'value' => $inject->name,
                        ])
                        @endcomponent

                        <div class="field @if(isset($hasError) && $hasError) error @endif">
                            <label for="input-option">{{ 'Daftar Pilihan' }}</label>
                            <select id="input-option" class="ui search fluid dropdown" name="option_id" required>
                                <option value="">Pilih daftar pilihan</option>
                                @foreach($options as $item)
                                    <option value="{{ $item->id }}" @if($inject->option_id == $item->id) selected="" @endif>{{ $item->title }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                </form>

                <button class="ui primary button right floated" type="submit" form="main-form">
                    <i class="check icon"></i>
                    {{ __('Simpan Keterkaitan') }}
                </button>

            </div>

        </div>

    </div>

@endsection


@section('script')

@endsection