@extends('layouts.semantic-ui.dashboard')

@section('content')

    <div class="medium-form">

        <div class="medium-form-content">

            @include('administrator.cycle.package.show.header')

            <div class="ui segments">

                <div class="ui clearing segment">

                    <a class="ui green ribbon label ribbon-sub-segment">{{ __('Paket ') . $package->getLabel() }}</a>

                    <br/>

                    @include('administrator.cycle.package.show.label')

                    <br/>
                    <br/>

                    @include('administrator.cycle.package.show.form')

                </div>

                <div class="ui clearing segment">

                    <a class="ui button right floated" href="{{ route('administrator.cycle.package.parameter.index', ['packageId' => $package->getId()]) }}">
                        {{ __('Lihat Daftar Parameter Paket ' . $package->getLabel() . ' Siklus ' . $package->getCycle()->getName() ) }}
                        <i class="ui right chevron icon"></i>
                    </a>

                </div>

            </div>

            <div class="ui clearing segment">

                <a class="ui negative button right floated" onclick="showModal()">
                    <i class="ui trash icon"></i>
                    {{ __('Hapus Paket ' . $package->getLabel() . ' Siklus ' . $package->getCycle()->getName() ) }}
                </a>

            </div>

        </div>

    </div>

    <div class="ui modal" id="modal">

        <div class="header">{{ __('Hapus Paket ' . $package->getLabel() . ' Siklus ' . $package->getCycle()->getName() ) }}</div>

        <div class="content">

            <p>Apakah Anda yakin hendak menghapus paket {{ $package->getLabel() }} siklus {{ $package->getCycle()->getName() }}?</p>

        </div>

        <div class="actions">

            <form id="delete-form" class="ui form" method="post" action="{{ route('administrator.cycle.package.delete', ['packageId' => $package->id]) }}">

                @csrf

                <input name="_method" value="DELETE" hidden>

                <button class="ui negative right labeled icon button" type="submit" form="delete-form">
                    <i class="trash icon"></i>
                    {{ __('Ya, Hapus') }}
                </button>

            </form>

        </div>

    </div>

@endsection


@section('script')

    <script>
        function showModal() {
            $('#modal')
                .modal('show')
            ;
        }
    </script>

@endsection