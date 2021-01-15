@extends('layouts.semantic-ui.dashboard')

@section('style')

    @include('layouts.moment-js.css')
    @include('layouts.datatables.css')

@endsection

@section('content')

    <div class="medium-form">

        <div class="medium-form-content">

            @include('layouts.dashboard.legacy-error')

            <div class="ui segments">

                <div class="ui segment">

                    <a class="ui green ribbon label ribbon-sub-segment">{{ __('Daftar Paket') }}</a>

                    <table class="ui striped table">
                        <thead>
                        <tr>
                            <th class="ui center aligned" width="5%">
                                {{ __('#') }}
                            </th>
                            <th>
                                {{ __('Instansi / Laboratorium') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($index = 1)
                        @foreach($orders as $order)
                            <tr>
                                <td class="center aligned">
                                    {{ $index }}
                                </td>
                                <td>
                                    <a href="{{ route('certificates.show', ['order_id' => $order->id]) }}">
                                        {{ $order->invoice->laboratory->name }}
                                    </a>
                                </td>
                            </tr>
                            @php($index += 1)
                        @endforeach
                        </tbody>
                    </table>

                </div>

            </div>

        </div>

    </div>

@endsection

@section('script')

    @include('layouts.moment-js.js')
    @include('layouts.datatables.js')

@endsection