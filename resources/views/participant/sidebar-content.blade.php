<a class="item @if($routeName == 'participant.dashboard.show') active @endif"
   href="{{ route('dashboard') }}">
    <i class="left dashboard icon"></i>
    {{ __('Dashboard') }}
</a>

<a class="item @if($routeName == 'participant.profile.show') active @endif"
   href="{{ route('participant.profile.show') }}">
    <i class="left user icon"></i>
    {{ __('Profil') }}
</a>

<a class="item @if(in_array($routeName, ['participant.laboratory.index', 'participant.laboratory.show'])) active @endif"
   href="{{ route('participant.laboratory.index') }}">
    <i class="left hospital outline icon"></i>
    {{ __('Laboratorium') }}
</a>

<br/>

<a class="item @if(in_array($routeName, ['participant.invoice.index', 'participant.invoice.show'])) active @endif"
   href="{{ route('participant.invoice.index') }}">
    <i class="left history icon"></i>
    {{ __('Riwayat Pemesanan') }}
</a>

<a class="item @if(in_array($routeName, ['participant.invoice.show-create-form'])) active @endif"
   href="{{ route('participant.invoice.show-create-form') }}">
    <i class="left shopping cart icon"></i>
    {{ __('Daftar Uji PME') }}
</a>

<a class="item @if(in_array($routeName, ['participant.payment.index', 'participant.payment.show-create-form', 'participant.payment.show'])) active @endif"
   href="{{ route('participant.payment.index') }}">
    <i class="left money bill alternate outline icon"></i>
    {{ __('Konfirmasi Pembayaran') }}
</a>

<br/>

<a class="item @if($routeName == 'participant.submit.schedule') active @endif"
   href="{{ route('participant.submit.schedule') }}">
    <i class="left calendar icon"></i>
    {{ __('Jadwal Pengisian') }}
</a>

<a class="item @if($routeName == 'participant.submit.index') active @endif"
   href="{{ route('participant.submit.index') }}">
    <i class="left pencil alternate icon"></i>
    {{ __('Isian Uji PME') }}
</a>

<a class="item @if($routeName == 'participant.report.index') active @endif"
   href="{{ route('participant.report.index') }}">
    <i class="left chart bar outline icon"></i>
    {{ __('Laporan Hasil Evaluasi') }}
</a>

<a class="item @if($routeName == 'participant.certificate.index') active @endif"
   href="{{ route('participant.certificate.index') }}">
    <i class="left certificate icon"></i>
    {{ __('Sertifikat Keikutsertaan') }}
</a>

<br/>

<a class="item @if($routeName == 'participant.survey.index') active @endif"
   href="{{ route('participant.survey.index') }}">
    <i class="left edit outline icon"></i>
    {{ __('Survey') }}
</a>

<a class="item @if($routeName == 'participant.schedule.index') active @endif"
   href="{{ route('participant.schedule.index') }}">
    <i class="left history icon"></i>
    {{ __('Jadwal PNPME') }}
</a>

<a class="item @if($routeName == 'participant.rate.index') active @endif"
   href="{{ route('participant.rate.index') }}">
    <i class="left dollar sign icon"></i>
    {{ __('Info Tarif') }}
</a>