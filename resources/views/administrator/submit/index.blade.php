@extends('layouts.semantic-ui.dashboard')

@section('style')

    @include('layouts.datatables.css')

    <style>
        tr.purple {
            background: #ede7f6!important;
            color: #512da8!important;
        }
    </style>

@endsection

@section('content')

    <div class="medium-form">

        <div class="medium-form-content">

            <div class="ui clearing segment raised">

                <form class="ui form">

                    <a class="ui green ribbon label ribbon-sub-segment">{{ __('Pencarian') }}</a>

                    <div class="ui three fields">

                        <div class="four wide field">
                            <label for="input-filter-cycle">{{ __('Siklus') }}</label>
                            <select id="input-filter-cycle" class="ui search fluid dropdown" name="{{ __('cycle_id') }}">
                                <option value="">{{ __('Pilih Siklus') }}</option>
                                @foreach($optionCycles as $cycle)
                                    <option value="{{ $cycle->id }}" @if(request('cycle_id') == $cycle->id) selected="" @endif>{{ $cycle->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="seven wide field">
                            <label for="input-filter-laboratory">{{ __('Instansi') }}</label>
                            <select id="input-filter-laboratory" class="ui search fluid dropdown" name="{{ __('laboratory_id') }}">
                                <option value="">{{ __('Pilih Instansi') }}</option>
                                @foreach($optionLaboratories as $laboratory)
                                    <option value="{{ $laboratory->id }}" @if(request('laboratory_id') == $laboratory->id) selected="" @endif>{{ $laboratory->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="five wide field">
                            <label for="input-filter-laboratory">{{ __('Status') }}</label>
                            <select id="input-filter-laboratory" class="ui search fluid dropdown" name="{{ __('state_id') }}">
                                <option value="">{{ __('Pilih Status Isian') }}</option>
                                <option value="1" @if(request('state_id') == 1) selected="" @endif>{{ __('Belum Diisi') }}</option>
                                <option value="2" @if(request('state_id') == 2) selected="" @endif>{{ __('Belum Dikirim') }}</option>
                                <option value="3" @if(request('state_id') == 3) selected="" @endif>{{ __('Terkirim & Belum Terverifikasi') }}</option>
                                <option value="4" @if(request('state_id') == 4) selected="" @endif>{{ __('Terverifikasi') }}</option>
                            </select>
                        </div>

                    </div>

                    <button type="submit" class="ui button blue right floated">
                        <i class="search icon"></i>
                        {{ __('Cari Isian Peserta') }}
                    </button>

                </form>

            </div>

            <div class="ui segment raised">

                <a class="ui green ribbon label ribbon-sub-segment">{{ __('Isian Peserta') }}</a>

                <table class="ui striped celled table data-tables">
                    <thead>
                    <tr>
                        <th style="width: 5%">
                            {{ __('#') }}
                        </th>
                        <th style="width: 45%">
                            {{ __('Instansi') }}
                        </th>
                        <th style="width: 15%">
                            {{ __('Siklus') }}
                        </th>
                        <th style="width: 30%">
                            {{ __('Paket') }}
                        </th>
                        <th>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @php($index = 1)
                    @foreach($result as $item)
                        <tr class="@if($item->submit == null) negative @elseif($item->submit->verified) purple @elseif($item->submit->sent) positive @else warning @endif">
                            <td class="center aligned" data-tooltip="Order ID : #{{ $item->id }}">{{ $index }}</td>
                            <td><span data-tooltip="{{ __($item->invoice->laboratory->user->name) . ' - ' . __($item->invoice->laboratory->user->phone_number ?? '') }}">{{ $item->invoice->laboratory->name }}</span></td>
                            <td>{{ $item->package->cycle->name }}</td>
                            <td>{{ $item->package->label }}</td>
                            <td class="selectable center aligned">
                                <a href="{{ route('administrator.submit.show', ['order_id' => $item->id]) }}" target="_blank">
                                    <i class="search icon"></i>
                                </a>
                            </td>
                        </tr>
                        @php($index++)
                    @endforeach
                    </tbody>
                </table>

            </div>

        </div>

    </div>

@endsection

@section('script')

    @include('layouts.datatables.js')

@endsection