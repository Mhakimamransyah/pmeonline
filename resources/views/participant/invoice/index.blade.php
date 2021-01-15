@extends('layouts.semantic-ui.dashboard')

@section('content')

    <div class="medium-form">

        <div class="medium-form-content">

            @if(!$invoices->isEmpty())

                @foreach($invoices as $invoice)

                    @include('participant.invoice.overview')

                @endforeach

            @else

                @include('participant.invoice.no-item')

            @endif

        </div>

    </div>

@endsection
