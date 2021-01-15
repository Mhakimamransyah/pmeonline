<a class="item @if(in_array($routeName, ['administrator.dashboard.index', 'administrator.dashboard.show'])) active @endif"
   href="{{ route('dashboard') }}">
    <i class="left dashboard icon"></i>
    {{ __('Dashboard') }}
</a>

<a class="item @if(in_array($routeName, ['administrator.contact-person.index', 'administrator.contact-person.show'])) active @endif"
   href="{{ route('administrator.contact-person.index') }}">
    <i class="left user icon"></i>
    {{ __('Personil Penghubung') }}
</a>

<a class="item @if(in_array($routeName, ['administrator.laboratory.index', 'administrator.laboratory.show'])) active @endif"
   href="{{ route('administrator.laboratory.index') }}">
    <i class="left hospital outline icon"></i>
    {{ __('Laboratorium') }}
</a>

<br/>

<a class="item @if(\Illuminate\Support\Str::contains($routeName, 'administrator.cycle')) active @endif"
   href="{{ route('administrator.cycle.index') }}">
    <i class="left recycle icon"></i>
    {{ __('Siklus') }}
</a>

<a class="item @if(\Illuminate\Support\Str::contains($routeName, 'administrator.participant')) active @endif"
   href="{{ route('administrator.participant.index') }}">
    <i class="left hospital icon"></i>
    {{ __('Daftar Peserta') }}
</a>

<a class="item @if(\Illuminate\Support\Str::contains($routeName, 'administrator.submit.index')) active @endif"
   href="{{ route('administrator.submit.index') }}">
    <i class="left edit icon"></i>
    {{ __('Isian Peserta') }}
</a>

<a class="item @if(in_array($routeName, ['administrator.payment.index', 'administrator.payment.show'])) active @endif"
   href="{{ route('administrator.payment.index') }}">
    <i class="left money bill alternate outline icon"></i>
    {{ __('Konfirmasi Pembayaran') }}
</a>

<a class="item @if(in_array($routeName, ['administrator.certificate.index', 'certificates.show'])) active @endif"
   href="{{ route('administrator.certificate.index') }}">
    <i class="left certificate icon"></i>
    {{ __('Sertifikat') }}
</a>

<br/>

<a class="item @if(\Illuminate\Support\Str::contains($routeName, 'administrator.option')) active @endif"
   href="{{ route('administrator.option.index') }}">
    <i class="left list alternate outline icon"></i>
    {{ __('Daftar Pilihan') }}
</a>

<a class="item @if(\Illuminate\Support\Str::contains($routeName, 'administrator.inject')) active @endif"
   href="{{ route('administrator.inject.index') }}">
    <i class="left linkify icon"></i>
    {{ __('Kaitan Daftar ke Paket') }}
</a>
