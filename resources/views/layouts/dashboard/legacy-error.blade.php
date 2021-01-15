@if ($errors->any())
    <div class="ui negative message">
        <div class="header">{{ __('Terdapat ') . $errors->count() . __(' Kesalahan') }}</div>
        <ol>
            @foreach ($errors->all() as $error)
                <li>{!! $error !!}</li>
            @endforeach
        </ol>
    </div>

@endif