@extends('layouts.semantic-ui.dashboard')

@section('style')

    @include('layouts.datatables.css')

    <style>
        #tariff {
            visibility: hidden;
        }
        #tariff:after {
            visibility: visible;
            content: attr(data-display);
        }
        #quota:after {
            content: ' Peserta';
        }
    </style>

@endsection

@section('content')

    <div class="medium-form">

        <div class="medium-form-content">

            @include('administrator.cycle.package.index.header')

            <div class="ui segments">

                <div class="ui segment">

                    <a class="ui green ribbon label ribbon-sub-segment">{{ __('Daftar Paket Siklus ' . $cycle->getName()) }}</a>

                    <br/>

                    @include('administrator.cycle.package.index.label')

                    <br/>

                    <table class="ui striped table" id="package-data-tables">
                        <thead>
                        <tr>
                            <th width="5%">{{ __('#') }}</th>
                            <th>{{ __('Nama Paket') }}</th>
                            <th>{{ __('Kode Paket') }}</th>
                            <th>{{ __('Tarif') }}</th>
                            <th>{{ __('Target Peserta') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cycle->getPackages() as $package)
                            <tr>
                                <td class="ui center aligned">{{ __($package->getId()) }}</td>
                                <td><a href="{{ route('administrator.cycle.package.show', ['id' => $package->getId()]) }}">{{ __($package->getLabel()) }}</a></td>
                                <td>{{ __($package->getName()) }}</td>
                                <td class="right aligned"><span id="tariff" data-display="{{ $package->displayTariff() }}">{{ __($package->getTariff()) }}</span></td>
                                <td class="right aligned"><span id="quota">{{ __($package->getQuota()) }}</span></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>

                <div class="ui clearing segment">

                    @if ($cycle->hasNotStarted())

                        <button class="ui button blue right floated" onclick="showCreatePackageModal()"><i class="plus icon"></i>{{ __('Tambah Paket Siklus ' . $cycle->getName()) }}</button>

                    @else

                        <button disabled class="ui button green right floated"><i class="check icon"></i>{{ __('Siklus Sudah Berjalan') }}</button>

                    @endif

                </div>

            </div>

        </div>

    </div>

    <div class="ui modal" id="create-package-modal">

        <div class="header">{{ __('Tambah Paket Siklus ' . $cycle->getName()) }}</div>

        <div class="content">

            <form id="create-option-form" class="ui form" method="post" action="{{ route('administrator.cycle.package.create', ['cycle_id' => $cycle->getId()]) }}">

                @include('administrator.cycle.package.create.form')

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

        function showCreatePackageModal() {
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