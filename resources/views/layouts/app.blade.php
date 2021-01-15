@php
    $routeName = Route::currentRouteName();
@endphp

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
<body class="hold-transition skin-green-light layout-top-nav">
    <div id="app" class="wrapper">
        <header class="main-header">
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="{{ route('homepage') }}" class="navbar-brand"><b>PME BBLK Palembang</b></a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                    </div>
                    <!-- /.navbar-collapse -->
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            {{--<li class="@if($routeName == 'homepage') active @endif">--}}
                                {{--<a href="{{ route('homepage') }}">Panduan</a>--}}
                            {{--</li>--}}
                            <li class="@if($routeName == 'register') active @endif">
                                <a href="{{ route('register') }}">Registrasi</a>
                            </li>
                            <li class="@if($routeName == 'login') active @endif">
                                <a href="{{ route('login') }}">Login</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.navbar-custom-menu -->
                </div>
                <!-- /.container-fluid -->
            </nav>
        </header>

        <!-- Full Width Column -->
        <div class="content-wrapper">
            <div class="container">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    @yield('content-header')
                </section>

                <!-- Main content -->
                <section class="content">
                    @include('layouts.dashboard.error')
                    @yield('content')
                </section>
                <!-- /.content -->
            </div>
            <!-- /.container -->
        </div>
        <!-- /.content-wrapper -->

        @include('layouts.dashboard.footer')

    </div>

    @include('layouts.dashboard.js')

</body>
</html>
