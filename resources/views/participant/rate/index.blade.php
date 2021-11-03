@extends('layouts.semantic-ui.dashboard')

@section('content')
  <div class="medium-form">

        <div class="medium-form-content">

            <div class="ui segments">

                <div class="ui segment">

                    <a class="ui green ribbon label ribbon-sub-segment">{{ __('Info Tarif') }}</a>

                    <table class="ui striped table data-tables">
                        <thead>
                        <tr>
                            <th width="5%">
                                {{ __('#') }}
                            </th>
                            <th>
                                {{ __('Bidang') }}
                            </th>
                            <th>
                                {{ __('Jumlah Sampel') }}
                            </th>
                            <th>
                                {{ __('Parameter') }}
                            </th>
                            <th width="12%">
                                {{ __('Tarif') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $no = 1; ?>
                        @foreach($rate as $rate)
                            <tr>
                                <td class="ui center aligned">{{ $no++ }}</td>
                                <td class="ui">{{ $rate->bidang }}</td>
                                <td class="ui">{{ $rate->jmlsample }}</td>
                                <td class="ui">{{ $rate->parameter }}</td>
                                <td class="ui">Rp {{ number_format($rate->tarif, 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>


            </div>

        </div>

    </div>

@endsection


@section('script')

      @include('layouts.datatables.js')

@endsection