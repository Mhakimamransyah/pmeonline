<a class="item @if(request()->route()->named('installation.submit.index')) active @endif"
   href="{{ route('installation.submit.index') }}">
    <i class="left eye icon"></i>
    {{ __('Lihat Isian Peserta') }}
</a>

<a class="item @if(request()->route()->named('installation.scoring.index')) active @endif"
   href="{{ route('installation.scoring.index') }}">
    <i class="left edit icon"></i>
    {{ __('Penilaian') }}
</a>

<a class="item @if(request()->route()->named('installation.submit.index-null')) active @endif"
   href="{{ route('installation.submit.index-null') }}">
    <i class="left eye slash icon"></i>
    {{ __('Belum Diisi') }}
</a>

<br/>

<a class="item @if(request()->route()->named('installation.score.index')) active @endif"
   href="{{ route('installation.score.index') }}">
    <i class="left check square outline icon"></i>
    {{ __('Hasil Penilaian') }}
</a>

<a class="item @if(request()->route()->named('installation.certificate.index')) active @endif"
   href="{{ route('installation.certificate.index') }}">
    <i class="left certificate icon"></i>
    {{ __('Sertifikat') }}
</a>

<a class="item @if(request()->route()->named('installation.rekap-isian.index')) active @endif"
   href="{{ route('installation.rekap-isian.index') }}">
    <i class="left paste icon"></i>
    {{ __('Rekap Isian Peserta') }}
</a>

<a class="item @if(request()->route()->named('installation.statistic.index')) active @endif"
   href="{{ route('installation.statistic.index') }}">
    <i class="left chart bar icon"></i>
    {{ __('Rekap Hasil Evaluasi') }}
</a>

