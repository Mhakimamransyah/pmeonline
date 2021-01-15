<header class="main-header">

    <a href="{{ route('dashboard') }}" class="logo" style="font-family: 'Source Sans Pro',sans-serif">
            <span class="logo-mini">
                <i class="fa fa-home"></i>
            </span>

        <span class="logo-lg">
                <strong>{{ env('APP_BRAND_LONG', 'BBLK') }}</strong>
            </span>
    </a>

    <nav class="navbar navbar-static-top">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="user user-menu">
                    <a href="@if(Auth::user()->isParticipant()) {{ route('participant.profile') }} @else # @endif" class="">
                        <span class="hidden-xs">{{ Auth::user()->name }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

</header>