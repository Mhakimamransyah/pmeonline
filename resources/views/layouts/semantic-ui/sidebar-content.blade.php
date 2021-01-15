<div class="ui styled fluid accordion inverted" style="background: #388e3c;">
    <div class="title">
        <i class="dropdown icon"></i>
        {{ auth()->user()->name }}
    </div>
    <div class="content">
        <div class="menu">
            <a class="item @if(in_array($routeName, ['auth.change-password.show'])) active @endif"
               href="{{ route('auth.change-password.show') }}" style="padding: 12px">
                <i class="left key icon"></i>
                {{ __('Ubah Password') }}
            </a>
            <a class="item" href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="padding: 12px">
                <i class="left logout icon"></i>
                {{ __('Logout') }}
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </a>
        </div>
    </div>
</div>

<br/>

@if(Auth::user()->getRole()->is(App\Role::participant()))

    @include('participant.sidebar-content')

@elseif(Auth::user()->getRole()->is(App\Role::administrator()))

    @include('administrator.sidebar-content')

@elseif(Auth::user()->isInstallation())

    @include('instalasi.sidebar-content')

@endif