@if(Session::has('success'))
    <div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <p>{!! Session::get('success')  !!}</p>
    </div>
@endif