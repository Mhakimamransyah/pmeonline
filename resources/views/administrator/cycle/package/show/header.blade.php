@include('administrator.cycle.package.show.breadcrumb')

@component('administrator.cycle.message', [
    'cycle' => $package->getCycle(),
])
@endcomponent