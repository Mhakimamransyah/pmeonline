@if($parameter->getPackage()->getCycle()->hasNotStarted())
    @include('administrator.cycle.package.parameter.show.form-input')
@else
    @include('administrator.cycle.package.parameter.show.form-readonly')
@endif