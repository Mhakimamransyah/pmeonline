@extends('layouts.semantic-ui.dashboard')

@section('content')

    <div class="medium-form">

        <div class="medium-form-content">

            @include('administrator.cycle.package.parameter.show.header')

            <div class="ui clearing segment">

                <a class="ui green ribbon label ribbon-sub-segment">{{ __('Parameter ') . $parameter->getLabel() }}</a>

                <br/>

                @include('administrator.cycle.package.parameter.show.label')

                <br/>
                <br/>

                @include('administrator.cycle.package.parameter.show.form')

            </div>

            <div class="ui clearing segment">

                <a class="ui negative button right floated" onclick="showModal()">
                    <i class="ui trash icon"></i>
                    {{ __('Hapus Parameter ' . $parameter->getLabel()) }}
                </a>

            </div>

        </div>

    </div>

    <div class="ui modal" id="modal">

        <div class="header">{{ __('Hapus Parameter ' . $parameter->getLabel()) }}</div>

        <div class="content">

            <p>Apakah Anda yakin hendak menghapus parameter {{ $parameter->getLabel() }}?</p>

        </div>

        <div class="actions">

            <form id="delete-form" class="ui form" method="post" action="{{ route('administrator.cycle.package.parameter.delete', ['parameter' => $parameter->getId()]) }}">

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