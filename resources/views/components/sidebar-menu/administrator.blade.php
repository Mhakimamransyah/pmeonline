@php

$routeName = Route::currentRouteName();

$cycles = \App\Cycle::all();

@endphp

<li class="header"></li>

<li class="@if($routeName == 'v1.administrator.contact-person') active @endif">
    <a href="{{ route('v1.administrator.contact-person') }}">
        <i class="fa fa-user"></i> <span>Personil Penghubung</span>
    </a>
</li>

<li class="@if(in_array($routeName, ['administrator.laboratory.filter', 'administrator.laboratory.list'])) active @endif">
    <a href="{{ route('administrator.laboratory.list') }}">
        <i class="fa fa-medkit"></i> <span>Laboratorium</span>
    </a>
</li>

<li class="@if($routeName == 'administrator.order.filter') active @endif">
    <a href="{{ route('administrator.order.filter') }}">
        <i class="fa fa-shopping-cart"></i> <span>Pemesanan Paket PME</span>
    </a>
</li>

<li class="@if($routeName == 'administrator.invoice.filter') active @endif">
    <a href="{{ route('administrator.invoice.filter') }}">
        <i class="fa fa-dollar"></i> <span>Tagihan</span>
    </a>
</li>

<li class="@if(in_array($routeName, ['administrator.payment-confirmation.list', 'administrator.payment-confirmation.item'])) active @endif">
    <a href="{{ route('administrator.payment-confirmation.list') }}">
        <i class="fa fa-money"></i> <span>Konfirmasi Pembayaran</span>
    </a>
</li>

{{--<li class="@if($routeName == 'administrator.instruction.display') active @endif">--}}
    {{--<a href="{{ route('administrator.instruction.display') }}">--}}
        {{--<i class="fa fa-download"></i> <span>Petunjuk Teknis</span>--}}
    {{--</a>--}}
{{--</li>--}}

<li class="treeview @if(in_array($routeName, ['administrator.participant.filter'])) active @endif">
    <a href="#">
        <i class="fa fa-group"></i>
        <span>Peserta Siklus</span>
        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        @foreach($cycles as $cycle)
        <li class="@if(in_array($routeName, ['administrator.participant.filter'])) active @endif">
            <a href="{{ route('administrator.participant.filter', ['cycle' => $cycle->id ]) }}"><i class="fa fa-circle-o"></i> {{ $cycle->name }}</a>
        </li>
        @endforeach
    </ul>
</li>

<li class="@if(in_array($routeName, ['administrator.survey.index'])) active @endif">
    <a href="{{ route('administrator.survey.default') }}">
        <i class="fa fa-check-square-o"></i> <span>Survey</span>
    </a>
</li>

<li class="@if(in_array($routeName, ['v1.administrator.form-input'])) active @endif">
    <a href="{{ route('v1.administrator.form-input') }}">
        <i class="fa fa-pencil"></i> <span>Formulir Ujian Peserta</span>
    </a>
</li>

{{--<li class="">--}}
    {{--<a href="#">--}}
        {{--<i class="fa fa-certificate"></i> <span>Penilaian & Sertifikasi</span>--}}
    {{--</a>--}}
{{--</li>--}}

{{--<li class="header"></li>--}}

{{--<li class="">--}}
    {{--<a href="#">--}}
        {{--<i class="fa fa-table"></i> <span>Siklus</span>--}}
    {{--</a>--}}
{{--</li>--}}

{{--<li class="">--}}
    {{--<a href="#">--}}
        {{--<i class="fa fa-table"></i> <span>Paket</span>--}}
    {{--</a>--}}
{{--</li>--}}

{{--<li class="">--}}
    {{--<a href="#">--}}
        {{--<i class="fa fa-table"></i> <span>Parameter</span>--}}
    {{--</a>--}}
{{--</li>--}}

{{--<li class="">--}}
    {{--<a href="#">--}}
        {{--<i class="fa fa-table"></i> <span>Daftar Alat</span>--}}
    {{--</a>--}}
{{--</li>--}}

{{--<li class="">--}}
    {{--<a href="#">--}}
        {{--<i class="fa fa-table"></i> <span>Daftar Metodologi</span>--}}
    {{--</a>--}}
{{--</li>--}}

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