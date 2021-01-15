<a class="item @if(\Illuminate\Support\Str::contains($routeName, 'submits.index')) active @endif"
   href="{{ route('submits.index') }}">
    <i class="left edit icon"></i>
    {{ __('Isian Peserta') }}
</a>

<a class="item @if(\Illuminate\Support\Str::contains($routeName, 'division.immunology.cycle')) active @endif"
   href="{{ route('division.immunology.cycle.index') }}">
    <i class="left recycle icon"></i>
    {{ __('Siklus') }}
</a>
