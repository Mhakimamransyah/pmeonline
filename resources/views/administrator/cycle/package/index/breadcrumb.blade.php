<div class="ui breadcrumb">
    <a href="{{ route('administrator.cycle.index') }}" class="section"><i class="recycle icon"></i>{{ __('Siklus') }}</a>
    <i class="right arrow icon divider"></i>
    <a class="section" href="{{ route('administrator.cycle.show', ['id' => $cycle->getId()]) }}">{{ __($cycle->getName()) }}</a>
    <i class="right arrow icon divider"></i>
    <div class="active section">{{ __('Daftar Paket') }}</div>
</div>