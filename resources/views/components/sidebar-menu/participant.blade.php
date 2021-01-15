@php

$routeName = Route::currentRouteName();

@endphp

<li class="header"></li>

<li class="@if($routeName == 'participant.profile') active @endif">
    <a href="{{ route('participant.profile') }}">
        <i class="fa fa-user"></i> <span>Profil</span>
    </a>
</li>

<li class="@if(in_array($routeName, ['participant.laboratories', 'participant.laboratory.item'])) active @endif">
    <a href="{{ route('participant.laboratories') }}">
        <i class="fa fa-medkit"></i> <span>Laboratorium</span>
    </a>
</li>

<li class="@if(in_array($routeName, ['participant.password'])) active @endif">
    <a href="{{ route('participant.password') }}">
        <i class="fa fa-user-secret"></i> <span>{{ 'Perbaharui Password' }}</span>
    </a>
</li>

<li class="header"></li>

<li class="@if(in_array($routeName, ['participant.order', 'participant.order.display'])) active @endif">
    <a href="{{ route('participant.order') }}">
        <i class="fa fa-history"></i> <span>{{ __('Riwayat Pemesanan') }}</span>
    </a>
</li>

<li class="@if(in_array($routeName, ['participant.order.create', 'participant.order.display'])) active @endif">
    <a href="{{ route('participant.order.create') }}">
        <i class="fa fa-edit"></i> <span>{{ __('Daftar Uji PME') }}</span>
    </a>
</li>

<li class="@if($routeName == 'participant.payment-confirmation') active @endif">
    <a href="{{ route('participant.payment-confirmation') }}">
        <i class="fa fa-money"></i> <span>Konfirmasi Pembayaran</span>
    </a>
</li>

<li class="@if($routeName == 'participant.post-result') active @endif">
    <a href="{{ route('participant.post-result') }}">
        <i class="fa fa-paperclip"></i> <span>Isian Uji PME</span>
    </a>
</li>

<li class="@if($routeName == 'participant.survey.show-form') active @endif">
    <a href="{{ route('participant.survey.show-form', ['id' => '1']) }}">
        <i class="fa fa-check-square-o"></i> <span>Survey</span>
    </a>
</li>

<li class="@if($routeName == 'participant.reports') active @endif">
    <a href="{{ route('participant.reports') }}">
        <i class="fa fa-book"></i> <span>Laporan Hasil Evaluasi</span>
    </a>
</li>

<li class="@if($routeName == 'participant.certificates') active @endif">
    <a href="{{ route('participant.certificates') }}">
        <i class="fa fa-bookmark"></i> <span>Sertifikat Keikutsertaan</span>
    </a>
</li>

<li class="header"></li>

<li class="">
    <a href="{{ route('logout') }}"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fa fa-sign-out"></i> <span>{{ __('Logout') }}</span>
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</li>