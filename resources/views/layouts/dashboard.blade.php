<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <title>PME BBLK Palembang</title>

    @yield('head')

    @include('layouts.dashboard.css')

    @yield('style-override')
</head>
<body class="hold-transition skin-green-light sidebar-mini">
<div class="wrapper">

    @include('layouts.dashboard.header')

    @include('layouts.dashboard.sidebar')

    <div class="content-wrapper">
        <section class="content-header">
            @yield('content-header')
        </section>

        <section class="content">
            @yield('content')
        </section>
    </div>

    @include('layouts.dashboard.footer')

</div>

@include('layouts.dashboard.js')

@include('layouts.dashboard.success')

</body>
</html>
