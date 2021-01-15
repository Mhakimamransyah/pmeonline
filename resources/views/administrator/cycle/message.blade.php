@if(!$cycle->errors()->isEmpty())

    <div class="ui negative message">
        <div class="header">{{ __('Terdapat ') . $cycle->errors()->count() . __(' Kesalahan dalam Siklus ' . $cycle->getName() ) }}</div>
        <ol>
            @foreach ($cycle->errors()->all() as $error)
                <li>{!! $error !!}</li>
            @endforeach
        </ol>
    </div>

@endif

@if(!$cycle->hasNotStarted())

    <div class="ui icon positive message">
        <i class="recycle icon"></i>
        <div class="content">
            <div class="header">
                {{ __('Siklus ' . $cycle->getName() . ' Sudah Berjalan') }}
            </div>
            <p>{{ __('Perubahan tidak bisa dilakukan terhadap siklus yang sudah berjalan.') }}</p>
        </div>
    </div>

@endif