<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ env('APP_NAME', 'Pemantapan Mutu Eksternal') }}</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <meta name="csrf-token" content="{{ csrf_token() }}" />

@yield('head-top')

    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/icheck/skins/square/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/morris.js/morris.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/jvectormap/jquery-jvectormap.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <style>
        .middle-vertical {
            vertical-align: middle !important;
        }
    </style>

    @yield('head-bottom')

</head>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">

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
                        @if(\Illuminate\Support\Facades\Auth::check())
                            <a href={{ route('v1.profile') }} class="">
                                <span class="hidden-xs">{{ \Illuminate\Support\Facades\Auth::user()->name }}</span>
                            </a>
                        @endif
                    </li>
                </ul>
            </div>

        </nav>

    </header>

    <aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu" data-widget="tree">
                @component('v1.layouts.sidebar-menu')
                @endcomponent
            </ul>
        </section>
    </aside>

    <div class="content-wrapper">

        <section class="content-header">
            @yield('content-header')
        </section>

        <section class="content">
            @yield('content')
        </section>

    </div>

    <footer class="main-footer">
        <div class="container">
            <div class="pull-right hidden-xs">
                <b>Version</b> {{ env('APP_VERSION', '0') }}
            </div>
            <strong>Copyright &copy; {{ env('APP_YEAR', '2018') }} <a
                        href="{{ env('APP_COPYRIGHT_HOMEPAGE', '#') }}">{{ env('APP_COPYRIGHT_HOLDER', 'Naufal Fachrian') }}</a>.</strong>
            {{ env('APP_COPYRIGHT_NOTE') }}
        </div>
    </footer>

    <div class="control-sidebar-bg"></div>

</div>

<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>

<script src="{{ asset('bower_components/jquery-ui/jquery-ui.min.js') }}"></script>

<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>

<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<script src="{{ asset('bower_components/raphael/raphael.min.js') }}"></script>

<script src="{{ asset('bower_components/morris.js/morris.min.js') }}"></script>

<script src="{{ asset('bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>

<script src="{{ asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>

<script src="{{ asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>

<script src="{{ asset('bower_components/jquery-knob/dist/jquery.knob.min.js') }}"></script>

<script src="{{ asset('bower_components/moment/min/moment.min.js') }}"></script>

<script src="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script src="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>

<script src="{{ asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('bower_components/fastclick/lib/fastclick.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>

<script>
    $(function () {
        $('.select2').select2();
    });
</script>

@yield('body-bottom')

</body>
</html>
