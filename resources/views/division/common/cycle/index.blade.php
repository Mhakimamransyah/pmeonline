@extends('layouts.semantic-ui.dashboard')

@section('style')

    @include('layouts.moment-js.css')
    @include('layouts.datatables.css')

@endsection

@section('content')

    <div class="medium-form">

        <div class="medium-form-content">

            <div class="ui breadcrumb">
                <div class="active section"><i class="recycle icon"></i>{{ __('Siklus') }}</div>
            </div>

            @include('layouts.dashboard.legacy-error')

            <div class="ui segments">

                <div class="ui segment">

                    <a class="ui green ribbon label ribbon-sub-segment">{{ __('Siklus') }}</a>

                    <table class="ui striped table">
                        <thead>
                        <tr>
                            <th class="ui center aligned" width="5%">
                                {{ __('#') }}
                            </th>
                            <th>
                                {{ __('Siklus') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cycles as $cycle)
                            <tr>
                                <td class="center aligned">
                                    {{ $cycle->getId() }}
                                </td>
                                <td>
                                    <a href="{{ route($showRouteName, ['cycleId' => $cycle->getId()]) }}">{{ $cycle->getName() }}</a>
                                </td>
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

    @include('layouts.moment-js.js')
    @include('layouts.datatables.js')

@endsection