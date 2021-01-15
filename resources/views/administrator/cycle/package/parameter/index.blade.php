@extends('layouts.semantic-ui.dashboard')

@section('style')

    @include('layouts.datatables.css')

@endsection

@section('content')

    <div class="medium-form">

        <div class="medium-form-content">

            @include('administrator.cycle.package.parameter.index.header')

            <div class="ui segments">

                <div class="ui segment">

                    <a class="ui green ribbon label ribbon-sub-segment">{{ __('Daftar Parameter Paket ' . $package->getLabel() . ' Siklus ' . $package->getCycle()->getName()) }}</a>

                    <br/>

                    @include('administrator.cycle.package.parameter.index.label')

                    <br/>
                    <br/>

                    <table class="ui striped table" id="package-data-tables">
                        <thead>
                        <tr>
                            <th width="5%">{{ __('#') }}</th>
                            <th>{{ __('Nama Parameter') }}</th>
                            <th>{{ __('Satuan') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($package->getParameters() as $parameter)
                            <tr>
                                <td class="ui center aligned">{{ __($parameter->getId()) }}</td>
                                <td><a href="{{ route('administrator.cycle.package.parameter.show', ['id' => $parameter->getId()]) }}">{{ __($parameter->getLabel()) }}</a></td>
                                <td>{{ __($parameter->getUnit()) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>

                <div class="ui clearing segment">

                    @if ($package->getCycle()->hasNotStarted())

                        <button class="ui button blue right floated" onclick="showCreateParameterModal()"><i class="plus icon"></i>{{ __('Tambah Parameter Paket ' . $package->getLabel() . ' Siklus ' . $package->getCycle()->getName()) }}</button>

                    @else

                        <button disabled class="ui button green right floated"><i class="check icon"></i>{{ __('Siklus Sudah Berjalan') }}</button>

                    @endif

                </div>

            </div>

        </div>

    </div>

    <div class="ui modal" id="create-package-modal">

        <div class="header">{{ __('Tambah Parameter Paket ' . $package->getLabel() . ' Siklus ' . $package->getCycle()->getName()) }}</div>

        <div class="content">

            <form id="create-option-form" class="ui form" method="post" action="{{ route('administrator.cycle.package.parameter.create', ['package_id' => $package->getId()]) }}">

                @include('administrator.cycle.package.parameter.create.form')

            </form>

        </div>

        <div class="actions">

            <button class="ui positive right labeled icon button" type="submit" form="create-option-form">
                {{ __('Simpan') }}
                <i class="check icon"></i>
            </button>

        </div>

    </div>

@endsection

@section('script')

    @include('layouts.datatables.js')

    <script>
        $('#package-data-tables').DataTable({
            "language" : {
                "url" : "{{ asset('data-tables/Indonesian.json') }}"
            },
            "paging": false,
        });

        function showCreateParameterModal() {
            $('#create-package-modal')
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