@extends('layouts.semantic-ui.dashboard')

@section('content')
  <div class="medium-form">

        <div class="medium-form-content">

            <div class="ui segments">

                <div class="ui segment">

                    <a class="ui green ribbon label ribbon-sub-segment">{{ __('Jadwal PME') }}</a>

                    <table class="ui striped table data-tables">
                        <thead>
                        <tr>
                            <th width="5%">
                                {{ __('#') }}
                            </th>
                            <th>
                                {{ __('Kegiatan') }}
                            </th>
                            <th>
                                {{ __('Siklus 1') }}
                            </th>
                            <th>
                                {{ __('Siklus 2') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $no = 1; ?>
                        @foreach($schedule as $schedule)
                            <tr>
                                <td class="ui center aligned">{{ $no++ }}</td>
                                <td class="ui">{{ $schedule->kegiatan }}</td>
                                <td class="ui">{{ $schedule->siklus_1 }}</td>
                                <td class="ui">{{ $schedule->siklus_2 }}</td>
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