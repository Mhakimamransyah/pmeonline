<a class="ui orange label" href="{{ route('administrator.cycle.package.show', ['id' => $parameter->getPackage()->getId()]) }}">
    {{ $parameter->getPackage()->getLabel() }}
</a>

<a class="ui teal label" href="{{ route('administrator.cycle.package.index', ['cycleId' => $parameter->getPackage()->getCycle()->getId()]) }}">
    {{ 'Siklus ' . $parameter->getPackage()->getCycle()->getName() }}
</a>

<a class="ui label">{{ '#' . $parameter->getId() }}</a>

@component('administrator.cycle.indicator', [
        'cycle' => $parameter->getPackage()->getCycle(),
    ])
@endcomponent