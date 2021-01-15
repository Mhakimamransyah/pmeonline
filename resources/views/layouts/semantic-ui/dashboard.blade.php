<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('style')

</head>
<body class="site" id="app">

<div class="pme dashboard">
    <div class="ui sidebar left">
        @include('layouts.semantic-ui.sidebar')
    </div>
    <div class="ui secondary green inverted menu">
        <a id="sidebar-toggle" class="item">
            <i class="bars icon"></i>
        </a>
        <div class="item">
            {{ env('APP_NAME') }}
        </div>
        <div class="right menu">
        </div>
    </div>
    <div id="main-content">
        @yield('content')
    </div>
</div>

@include('layouts.semantic-ui.components.footer')

<script src="{{ asset('js/app.js') }}"></script>
<script>
    $('.ui.dropdown')
        .dropdown({
            clearable: true,
            fullTextSearch: true,
        });
    $('.message .close')
        .on('click', function() {
            $(this)
                .closest('.message')
                .transition('fade');
        });

    $menu = $('#toc');
    $menu.sidebar({
            dimPage          : true,
            transition       : 'overlay',
            mobileTransition : 'uncover'
        });
    $menu.sidebar('attach events', '.launch.button, .view-ui, .launch.item');

    $sidebarToggle = $('#sidebar-toggle').on('click', function () {
        $('.ui.sidebar').toggleClass('visible');
        $('#sidebar-toggle').toggleClass('toggled');
        $('#main-content').toggleClass('toggled');
    });
    let width = $(window).width();
    if (width > 600) {
        $('.ui.sidebar').toggleClass('visible');
        $sidebarToggle.toggleClass('toggled');
        $('#main-content').toggleClass('toggled');
    }
    $('.ui.accordion')
        .accordion();
</script>

@yield('script')

@include('layouts.dashboard.success')

@include('layouts.dashboard.error')

@include('layouts.semantic-ui.components.progress-js')

</body>
</html>
