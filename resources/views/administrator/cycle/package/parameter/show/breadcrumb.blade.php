<div class="ui breadcrumb">
    <a href="{{ route('administrator.cycle.index') }}" class="section"><i class="recycle icon"></i>{{ __('Siklus') }}</a>
    <i class="right arrow icon divider"></i>
    <a class="section" href="{{ route('administrator.cycle.show', ['id' => $parameter->getPackage()->getCycle()->getId()]) }}">{{ __($parameter->getPackage()->getCycle()->getName()) }}</a>
    <i class="right arrow icon divider"></i>
    <a class="section" href="{{ route('administrator.cycle.package.index', ['cycleId' => $parameter->getPackage()->getCycle()->getId()]) }}">{{ __('Daftar Paket') }}</a>
    <i class="right arrow icon divider"></i>
    <a class="section" href="{{ route('administrator.cycle.package.show', ['id' => $parameter->getPackage()->getId()]) }}">{{ __($parameter->getPackage()->getLabel()) }}</a>
    <i class="right arrow icon divider"></i>
    <a class="section" href="{{ route('administrator.cycle.package.parameter.index', ['packageId' => $parameter->getPackage()->getId()]) }}">{{ __('Daftar Parameter') }}</a>
    <i class="right arrow icon divider"></i>
    <div class="active section">{{ __($parameter->getLabel()) }}</div>
</div>