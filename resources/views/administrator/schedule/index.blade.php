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
                            <th>
                                {{ __('Opsi') }}
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
                                <td>
                                    <a href="{{ route('administrator.schedule.edit', ['id' => $schedule->id]) }}" title="Edit">
                                        <button class="ui circular blue button"><i class="edit icon"></i></button>
                                    </a>
                                    
                                    <a href="{{ route('administrator.schedule.hapus', ['id' => $schedule->id]) }}" title="Delete">
                                        <button class="ui circular red button"><i class="trash icon"></i></button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>

                <div class="ui clearing segment">

                    <button class="ui blue button right floated" onclick="showCreateScheduleModal()">
                        <i class="plus icon"></i>
                        {{ __('Buat Jadwal PME') }}
                    </button>

                </div>

            </div>

        </div>

    </div>

    <div class="ui modal" id="create-schedule-modal">

        <div class="header">{{ __('Buat Jadwal PME') }}</div>

        <div class="content">

            <form id="create-schedule-form" class="ui form" method="post" action="{{ route('administrator.schedule.create') }}">

                @csrf

                @component('layouts.semantic-ui.components.input-text', [
                    'name' => 'kegiatan',
                    'old' => 'kegiatan',
                    'type' => 'text',
                    'label' => 'Kegiatan',
                    'placeholder' => 'Isi kegiatan',
                    'required' => true,
                ])
                @endcomponent

                @component('layouts.semantic-ui.components.input-text', [
                    'name' => 'siklus_1',
                    'old' => 'siklus_1',
                    'type' => 'text',
                    'label' => 'Siklus 1',
                    'placeholder' => 'Isi jadwal siklus 1',
                    'required' => true,
                ])
                @endcomponent

                @component('layouts.semantic-ui.components.input-text', [
                    'name' => 'siklus_2',
                    'old' => 'siklus_2',
                    'type' => 'text',
                    'label' => 'Siklus 2',
                    'placeholder' => 'Isi jadwal siklus 2',
                    'required' => true,
                ])
                @endcomponent

            </form>

        </div>

        <div class="actions">

            <button class="ui positive right labeled icon button" type="submit" form="create-schedule-form">
                {{ __('Simpan') }}
                <i class="check icon"></i>
            </button>

        </div>

    </div>
@endsection


@section('script')

      @include('layouts.datatables.js')

    <script>
        function showCreateScheduleModal() {
            $('#create-schedule-modal')
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