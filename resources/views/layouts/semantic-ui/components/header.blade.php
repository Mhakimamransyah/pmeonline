@php
    $route_name = Route::current()->getName();
@endphp
<header class="ui secondary green inverted menu">
    <div class="ui container">
        <a href="/" class="header item">
            {{ config('app.name', 'Laravel') }}
        </a>
        <div class="right menu">
            @guest
                <a href="{{ route('register') }}" class="item @if($route_name == 'register') active @endif">
                    Pendaftaran
                </a>
                <a href="{{ route('login') }}" class="item @if($route_name == 'login') active @endif">
                    Login
                </a>
            @endguest
            @auth
                <div class="ui dropdown item">{{ isset($laboratory) ? $laboratory->name : __('Laboratorium') }}<i class="dropdown icon"></i>
                    <div class="menu">
                        @foreach(Auth::user()->laboratories as $optionLaboratory)
                            <a href="{{ route('home', ['laboratory_id' => $optionLaboratory->id]) }}" class="item @if (isset($laboratory) && $optionLaboratory->is($laboratory)) active @endif">{{ $optionLaboratory->name }}</a>
                        @endforeach
                    </div>
                </div>
                <div class="ui dropdown item">{{ Auth::user()->name }}<i class="dropdown icon"></i>
                    <div class="menu">
                        <a href="{{ route('profile') }}" class="item @if($route_name == 'profile') active @endif">{{ __('Perbaharui Profil') }}</a>
                        <a href="{{ route('profile.password') }}" class="item @if($route_name == 'profile.password') active @endif">{{ __('Ubah Password') }}</a>
                        <a class="item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</header>