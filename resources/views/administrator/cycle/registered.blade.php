@extends('layouts.semantic-ui.dashboard')

@section('style')

    @include('layouts.moment-js.css')
    @include('layouts.datatables.css')

    <style>
        #invoice-id:before {
            content: '#';
        }
        .hide-on-loading {
            visibility: hidden;
        }
    </style>

@endsection

@section('content')

    @include('layouts.semantic-ui.components.progress-html-custom')

    <div class="medium-form hide-on-loading">

        <div class="medium-form-content">

            <div class="ui breadcrumb">
                <a href="{{ route('administrator.cycle.index') }}" class="section"><i class="recycle icon"></i>{{ __('Siklus') }}</a>
                <i class="right arrow icon divider"></i>
                <a class="section" href="{{ route('administrator.cycle.show', ['id' => $cycle->getId()]) }}">{{ __($cycle->getName()) }}</a>
                <i class="right arrow icon divider"></i>
                <div class="active section">{{ __('Daftar Pendaftar') }}</div>
            </div>

            @include('administrator.cycle.laboratory-list')

        </div>

    </div>

@endsection

@section('script')

    @include('layouts.moment-js.js')
    @include('layouts.datatables.js')

    <script>
        let dataSourceUrl = '{{ route('administrator.cycle.registered.data', ['cycleId' => $cycle->getId()]) }}';
        let cycleId = '{{ $cycle->getId() }}';
        let listType = 'registered';
    </script>

    @include('administrator.cycle.laboratory-list-js')

@endsection