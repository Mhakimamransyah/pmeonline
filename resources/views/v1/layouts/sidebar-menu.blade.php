@php
    $route_name = Route::currentRouteName();
    $role_id = Auth::user()->roles()->first()->id;
    $sidebar_menus = \App\SidebarMenu::where('role_id', $role_id)->where('shown', true)->orderBy('sequence', 'asc')->get();
@endphp

<li class="header"></li>

@foreach($sidebar_menus as $menu)

    @if($menu->route_name == null)

        <li class="header"></li>

    @else

        <li class="@if($route_name == $menu->route_name) active @endif">
            <a href="{{ route($menu->route_name) }}">
                <i class="{{ $menu->icon }}"></i> <span>{{ $menu->label }}</span>
            </a>
        </li>

    @endif

@endforeach

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