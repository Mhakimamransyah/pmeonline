@if($package->getCycle()->hasNotStarted())
    @include('administrator.cycle.package.show.form-input')
@else
    @include('administrator.cycle.package.show.form-readonly')
@endif