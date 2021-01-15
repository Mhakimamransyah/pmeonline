@if($cycle->hasDone())
        <a class="ui purple label cycle-info">{{ __('Sudah Selesai') }}</a>
@endif
@if($cycle->hasNotStarted())
        <a class="ui green label cycle-info">{{ __('Belum Dimulai') }}</a>
@endif
@if($cycle->isOpenRegistration())
        <a class="ui blue label cycle-info">{{ __('Pendaftaran Dibuka') }}</a>
@endif
@if($cycle->isOpenSubmit())
        <a class="ui blue label cycle-info">{{ __('Pengisian Laporan Dibuka') }}</a>
@endif
@if(!$cycle->errors()->isEmpty())
        <a class="ui red label cycle-info" data-tooltip="{{ __('Terdapat ' . $cycle->errors()->count()) . ' kesalahan dalam siklus ' . $cycle->getName() }}"><i class="exclamation triangle icon"></i>{{ __($cycle->errors()->count()) }}</a>
@endif