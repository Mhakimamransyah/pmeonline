@include('administrator.cycle.package.parameter.show.breadcrumb')

@component('administrator.cycle.message', [
    'cycle' => $parameter->getPackage()->getCycle(),
])
@endcomponent