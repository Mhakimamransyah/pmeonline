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

                    @foreach($packages as $package)

                    <table class="ui striped table">
                        <thead>
                        <tr>
                            <th class="ui center aligned" width="5%">
                                {{ __('#') }}
                            </th>
                            <th>
                                {{ __('Paket ' . $package->getLabel()) }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($package->getParameters() as $parameter)
                            <tr>
                                <td class="center aligned">
                                    {{ $parameter->getId() }}
                                </td>
                                <td>
                                    <a href="{{ route('statistic-redirect.by-parameter', ['parameter_id' => $parameter->getId()]) }}">{{ $parameter->getLabel() }}</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    @endforeach

                </div>

            </div>

        </div>

    </div>

@endsection

@section('script')

    @include('layouts.moment-js.js')
    @include('layouts.datatables.js')

@endsection