@extends('layouts.semantic-ui.dashboard')

@section('style')

    @include('layouts.moment-js.css')

@endsection

@section('content')

    <div class="medium-form">

        <div class="medium-form-content">

            <div class="ui breadcrumb">
                <a href="{{ route('administrator.cycle.index') }}" class="section"><i class="recycle icon"></i>{{ __('Siklus') }}</a>
                <i class="right arrow icon divider"></i>
                <div class="active section">{{ __($cycle->getName()) }}</div>
            </div>

            @include('administrator.cycle.message')

            <div class="ui segments">

                <div class="ui clearing segment">

                    <a class="ui green ribbon label ribbon-sub-segment">{{ __('Siklus ') . $cycle->getName() }}</a>

                    <br/>

                    @include('administrator.cycle.indicator')

                    <br/>
                    <br/>

                    @include('administrator.cycle.show.form')

                </div>

                <div class="ui clearing segment">

                    <a class="ui right floated button" href="{{ route('administrator.cycle.package.index', ['cycleId' => $cycle->getId()]) }}">
                        {{ __('Lihat Daftar Paket Siklus ' . $cycle->getName()) }}
                        <i class="right chevron icon"></i>
                    </a>

                    <br/>
                    <br/>
                    <br/>

                    <a class="ui right floated button" href="{{ route('administrator.cycle.registered', ['cycleId' => $cycle->getId()]) }}">
                        {{ __('Lihat Pendaftar Siklus ' . $cycle->getName()) }}
                        <i class="right chevron icon"></i>
                    </a>

                    <br/>
                    <br/>
                    <br/>

                    <a class="ui right floated button" href="{{ route('administrator.cycle.participant', ['cycleId' => $cycle->getId()]) }}">
                        {{ __('Lihat Peserta Siklus ' . $cycle->getName()) }}
                        <i class="right chevron icon"></i>
                    </a>

                    <br/>
                    <br/>
                    <br/>

                    <a class="ui right floated button" href="{{ route('administrator.cycle.signature', ['cycleId' => $cycle->getId()]) }}">
                        {{ __('Atur Penandatangan Hasil Evaluasi ' . $cycle->getName()) }}
                        <i class="right chevron icon"></i>
                    </a>

                    <br/>
                    <br/>
                    <br/>

                    <a class="ui right floated button" href="{{ route('administrator.cycle.unpaid', ['cycleId' => $cycle->getId()]) }}">
                        {{ __('Lihat Tagihan Belum Terbayar Siklus ' . $cycle->getName()) }}
                        <i class="right chevron icon"></i>
                    </a>

                </div>

            </div>

            <div class="ui segments">

                <div class="ui clearing segment">

                    <button class="ui right floated red button" onclick="showDeleteCycleModal()">
                        <i class="trash icon"></i>
                        {{ __('Hapus Siklus ' . $cycle->getName()) }}
                    </button>

                </div>

            </div>

        </div>

    </div>


    <div class="ui modal" id="delete-cycle-modal">

        <div class="header">{{ __('Hapus Siklus ' . $cycle->getName()) }}</div>

        <div class="content">

            <p>Apakah Anda yakin menghapus siklus {{ $cycle->getName() }}</p>

            <form id="delete-form" class="ui form" method="post" action="{{ route('administrator.cycle.delete', ['cycle' => $cycle->id]) }}">

                <input type="hidden" name="_method" value="DELETE">

                @csrf

            </form>

        </div>

        <div class="actions">

            <button class="ui negative right labeled icon button" type="submit" form="delete-form">
                {{ __('Hapus') }}
                <i class="trash icon"></i>
            </button>

        </div>

    </div>

@endsection

@section('script')
    @include('layouts.moment-js.js')

    <script>
        function showDeleteCycleModal() {
            $('#delete-cycle-modal')
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