<div class="ui breadcrumb">
    <a href="{{ route('administrator.cycle.index') }}" class="section"><i class="recycle icon"></i>{{ __('Siklus') }}</a>
    <i class="right arrow icon divider"></i>
    <a class="section" href="{{ route('administrator.cycle.show', ['id' => $package->getCycle()->getId()]) }}">{{ __($package->getCycle()->getName()) }}</a>
    <i class="right arrow icon divider"></i>
    <a class="section" href="{{ route('administrator.cycle.package.index', ['cycleId' => $package->getCycle()->getId()]) }}">{{ __('Daftar Paket') }}</a>
    <i class="right arrow icon divider"></i>
    <div class="active section">{{ __($package->getLabel()) }}</div>
</div>