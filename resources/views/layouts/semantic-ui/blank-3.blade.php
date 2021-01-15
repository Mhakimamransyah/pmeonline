<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="site">

<main class="site-content ui main container" style="margin-top: 24px; margin-bottom: 24px;">
    @yield('content')
</main>

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
</script>

@yield('script')

@include('layouts.dashboard.error')

@include('layouts.dashboard.success')

</body>

<style>
    .site {
        background-color: #fafafa;
    }
</style>
</html>
