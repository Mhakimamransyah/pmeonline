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

<main class="site-content ui main container">
    @yield('content')
</main>

@include('layouts.semantic-ui.components.footer')

@yield('script')

@include('layouts.dashboard.error')

@include('layouts.dashboard.success')

</body>
</html>
