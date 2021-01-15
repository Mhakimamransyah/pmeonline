@foreach($invoice->getCycles() as $cycle)
    <a class="ui teal label"><i class="recycle icon"></i>{{ 'Siklus ' . $cycle->name }}</a>
@endforeach
@include('participant.invoice.overview-state')