<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>{{ $title }} - Production Inventory SAI</title>
    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/logo.png')}}" />
    <link href="{{ asset('assets/css/css2.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css')}}" />
    <script src="{{ asset('assets/vendor/js/helpers.js')}}"></script>
    <script src="{{ asset('assets/js/config.js')}}"></script>
    <script src="{{ asset('assets/js/jquery-3.7.0.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css')}}">
    <script type="text/javascript" charset="utf8" src="{{ asset('assets/js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{ asset('assets/js/jquery.dataTables.js')}}"></script>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @include('layouts.sidebar')
            <div class="layout-page">
                @include('layouts.navbar')
                <div class="content-wrapper">
                    @yield('content')
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <script>
        new DataTable('#dataBarangUser');
        new DataTable('#dataBarangReady');
        new DataTable('#dataStatusPesanan');
    </script>
    <!-- <script src="{{ asset('assets/vendor/libs/jquery/jquery.js')}}"></script> -->
    <script src="{{ asset('assets/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js')}}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js')}}"></script>
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
    <script src="{{ asset('assets/js/main.js')}}"></script>
    <script src="{{ asset('assets/js/dashboards-analytics.js')}}"></script>
    <script async defer src="{{ asset('assets/js/buttons.js')}}"></script>
    <script src="{{ asset('assets/js/html2canvas.min.js')}}"></script>

    @stack('scripts')
</body>

</html>
