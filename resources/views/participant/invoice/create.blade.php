@extends('layouts.semantic-ui.dashboard')

@section('content')

    <div class="medium-form">

        <div class="medium-form-content">

            @include('layouts.dashboard.legacy-error')

            <div class="ui clearing segment">

                <a class="ui green ribbon label ribbon-sub-segment">{{ __('Pilih Laboratorium') }}</a>

                <form action="{{ route('participant.invoice.create') }}" method="post" class="ui form">

                    @csrf

                    <div class="small-form">

                        <div class="small-form-content ui field">

                            @component('layouts.semantic-ui.components.input-select', [
                                'name' => 'laboratory_id',
                                'old' => 'laboratory_id',
                                'label' => 'Laboratorium',
                                'placeholder' => '-- Pilih laboratorium --',
                                'items' => $laboratories,
                            ])
                            @endcomponent

                        </div>

                    </div>

                    <a class="ui green ribbon label ribbon-sub-segment">{{ __('Pilih Paket Pengujian Pemantapan Mutu Eksternal') }}</a>

                    <table class="ui table">
                        <thead>
                        <tr>
                            <th width="15%">{{ __('Siklus') }}</th>
                            <th width="5%">{{ __('') }}</th>
                            <th width="60%">{{ __('Bidang / Parameter') }}</th>
                            <th width="20%" class="center aligned">{{ __('Tarif') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cycles as $cycle)
                            @if ($cycle->getPackages()->isNotEmpty())
                                <tr>
                                    <td style="vertical-align: middle" class="center aligned" rowspan="{{ $cycle->packages->count() }}">
                                        <span class="ui tag teal label">{{ $cycle->name }}</span>
                                    </td>
                                    @foreach($cycle->packages as $package)
                                        <td class="center aligned">
                                            <div class="ui fitted checkbox package">
                                                <input type="checkbox" name="selected_packages[{{ $package->id }}]" data-tariff="{{ $package->tariff }}">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <b>{{ $package->getLabel() }}</b>&nbsp;
                                            <small>
                                                <i>
                                                    {{ $package->parameters->count() }} parameter
                                                </i>
                                            </small>
                                            <br/>
                                            @foreach($package->getParameters() as $parameter)
                                                <span class="ui label" style="margin: 2px 0 2px;">{{ $parameter->label }}</span>
                                            @endforeach
                                            <span class="ui tag label">{{ $package->getCycle()->name }}</span>
                                        </td>
                                        <td class="right aligned" style="vertical-align: middle">
                                            {{ 'Rp ' . number_format($package->tariff, 0, ',', '.') . ',-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th><h3 class="right aligned">{{ __('Total') }}</h3></th>
                            <th class="right aligned"><h3 id="total_cost">{{ $cost ?? 'Rp 0,-' }}</h3></th>
                        </tr>
                        </tfoot>

                    </table>

                    <div class="ui checkbox field">
                        <input type="checkbox" required name="acceptance">
                        <label>{{ __('Saya telah memeriksa pemesanan Paket PME di atas.') }}</label>
                    </div>

                    <br/>

                    <button class="ui blue button right floated">
                        {{ __('Buat Pesanan') }}
                        <i class="chevron right icon"></i>
                    </button>

                </form>

            </div>

        </div>

    </div>

@endsection

@section('script')
    <script>
        var cost = 0;

        $('.package').checkbox({
            onChecked: function () {
                itemCost = $(this).data('tariff');
                cost += itemCost;
                $('#total_cost').text('Rp ' + cost.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ',-');
            },
            onUnchecked: function () {
                itemCost = $(this).data('tariff');
                cost -= itemCost;
                $('#total_cost').text('Rp ' + cost.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ',-');
            },
        });
    </script>
@endsection
