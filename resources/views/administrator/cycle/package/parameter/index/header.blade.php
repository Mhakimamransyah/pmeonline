@include('administrator.cycle.package.parameter.index.breadcrumb')

@component('administrator.cycle.message', [
    'cycle' => $package->getCycle(),
])
@endcomponent