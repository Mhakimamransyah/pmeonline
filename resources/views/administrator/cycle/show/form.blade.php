@if($cycle->hasNotStarted())
    @include('administrator.cycle.show.form-input')
@else
    @include('administrator.cycle.show.form-readonly')
@endif