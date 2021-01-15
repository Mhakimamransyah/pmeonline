<a class="ui teal label" href="{{ route('administrator.cycle.package.index', ['cycleId' => $package->getCycle()->getId()]) }}">{{ 'Siklus ' . $package->getCycle()->getName() }}</a>
<a class="ui label">{{ '#' . $package->getId() }}</a>

@component('administrator.cycle.indicator', [
    'cycle' => $package->getCycle(),
])
@endcomponent