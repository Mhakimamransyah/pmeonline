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
                            <th>
                                {{ __('Tarif') }}
                            </th>
                            <th>
                                {{ __('Opsi') }}
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
                                <td>
                                    <a href="{{ route('administrator.rate.edit', ['id' => $rate->id]) }}" title="Edit">
                                        <button class="ui circular blue button"><i class="edit icon"></i></button>
                                    </a>
                                    
                                    <a href="{{ route('administrator.rate.destroy', ['id' => $rate->id]) }}" title="Delete">
                                        <button class="ui circular red button"><i class="trash icon"></i></button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>

                <div class="ui clearing segment">

                    <button class="ui blue button right floated" onclick="showCreateRateModal()">
                        <i class="plus icon"></i>
                        {{ __('Buat Tarif') }}
                    </button>

                </div>

            </div>

        </div>

    </div>

    <div class="ui modal" id="create-rate-modal">

        <div class="header">{{ __('Buat Tarif') }}</div>

        <div class="content">

            <form id="create-rate-form" class="ui form" method="post" action="{{ route('administrator.rate.create') }}">

                @csrf

                @component('layouts.semantic-ui.components.input-text', [
                    'name' => 'bidang',
                    'old' => 'bidang',
                    'type' => 'text',
                    'label' => 'Bidang',
                    'placeholder' => 'Isi Bidang',
                    'required' => true,
                ])
                @endcomponent

                @component('layouts.semantic-ui.components.input-text', [
                    'name' => 'jmlsample',
                    'old' => 'jmlsample',
                    'type' => 'text',
                    'label' => 'Jumlah Sampel',
                    'placeholder' => 'Isi Jumlah Sampel',
                    'required' => true,
                ])
                @endcomponent

                @component('layouts.semantic-ui.components.input-text', [
                    'name' => 'parameter',
                    'old' => 'parameter',
                    'type' => 'text',
                    'label' => 'Parameter',
                    'placeholder' => 'Isi Parameter',
                    'required' => true,
                ])
                @endcomponent

                @component('layouts.semantic-ui.components.input-text', [
                    'name' => 'tarif',
                    'old' => 'tarif',
                    'type' => 'number',
                    'label' => 'Tarif',
                    'placeholder' => 'Isi Tarif ',
                    'required' => true,
                ])
                @endcomponent

            </form>

        </div>

        <div class="actions">

            <button class="ui positive right labeled icon button" type="submit" form="create-rate-form">
                {{ __('Simpan') }}
                <i class="check icon"></i>
            </button>

        </div>

    </div>
@endsection


@section('script')

      @include('layouts.datatables.js')

    <script>
        function showCreateRateModal() {
            $('#create-rate-modal')
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