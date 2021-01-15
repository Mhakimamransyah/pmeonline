@extends('layouts.semantic-ui.blank-2')

@section('style')

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

    @include('administrator.cycle.export-list')

@endsection

@section('script')

    @include('layouts.datatables.js')

    <script>
        let dataSourceUrl = '{{ route('administrator.cycle.participant.export.data', ['cycleId' => $cycle->getId()]) }}';
        let packages = JSON.parse('{!! json_encode($cycle->getPackages()) !!}');
        let cycleId = '{{ $cycle->getId() }}';
    </script>

    @include('administrator.cycle.export-list-js')

@endsection