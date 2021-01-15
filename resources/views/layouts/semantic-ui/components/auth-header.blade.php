<div class="ui fixed main menu desktop-header hide-on-loading">
    <div class="ui content">
        <div class="header item">
            {{ config('app.name', 'Laravel') }}
        </div>
    </div>
    <div class="right menu">
        <div class="ui right aligned dropdown item">
            {{ \Illuminate\Support\Facades\Auth::user()->getName() }}
            <i class="dropdown icon"></i>
            <div class="menu">
                <a class="item" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="logout icon"></i>
                    {{ __('Logout') }}
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="ui fixed main menu mobile-header hide-on-loading">
    <div class="ui container">
        <a class="launch icon item" onclick="openMobileSidebarMenu()">
            <i class="content icon"></i>
        </a>

        <div class="header item">
            {{ config('app.name', 'Laravel') }}
        </div>

    </div>
</div>

<script>
    function openMobileSidebarMenu() {
        $('.mobile-menu')
            .sidebar('toggle');
    }
</script>