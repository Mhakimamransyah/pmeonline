<aside class="main-sidebar">

    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            @if(Auth::user()->isAdministrator())
                @include('components.sidebar-menu.administrator')
            @elseif(Auth::user()->isParticipant())
                @include('components.sidebar-menu.participant')
            @endif
        </ul>
    </section>

</aside>