<a class="ui orange label" href="{{ route('administrator.cycle.package.show', ['id' => $package->getId()]) }}">{{ $package->getLabel() }}</a>
<a class="ui teal label" href="{{ route('administrator.cycle.package.index', ['cycleId' => $package->getCycle()->getId()]) }}">{{ 'Siklus ' . $package->getCycle()->getName() }}</a>

@component('administrator.cycle.indicator', [
        'cycle' => $package->getCycle(),
    ])
@endcomponent