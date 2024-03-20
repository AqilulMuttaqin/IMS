<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} - Production Stationery Control SAI</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo.png') }}" />
    <link rel="stylesheet" href="{{ asset('src/assets/css/styles.min.css?v=1.1') }}" />
    <script src="{{ asset('src/assets/js/jquery-3.6.4.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/jquery.dataTables.min.css') }}">
    <script type="text/javascript" charset="utf8" src="{{ asset('src/assets/js/jquery.dataTables.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/select2.min.css') }}">
    <script type="text/javascript" charset="utf8" src="{{ asset('src/assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('src/assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('src/assets/js/moment-timezone-with-data.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('src/assets/css/select2-bootstrap-5-theme.min.css') }}" />
    <link href="{{ asset('src/assets/css/bootstrap-toggle.min.css')}}" rel="stylesheet">
    <style>
        .nav-pills .nav-link {
            color: black;
        }

        .nav-pills .nav-link.active {
            color: white;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__placeholder {
            font-size: 14px;
            opacity: 0.8;
            font-weight: normal;
        }
    </style>
</head>

<body>
    <!-- Content Page Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Include -->
        @include('layout.side')
        <!-- Content Page Wrapper -->
        <div class="body-wrapper">
            <!-- Navbar Include -->
            @include('layout.nav')
            <!-- Container Content -->
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- Sweetalert -->
            @include('sweetalert::alert')
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('src/assets/js/bootstrap-toggle.min.js')}}"></script>
    <script src="{{ asset('src/assets/js/sweetalert2@11.js')}}"></script>
    <script src="{{ asset('src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('src/assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('src/assets/js/app.min.js') }}"></script>
    <script src="{{ asset('src/assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('src/assets/libs/simplebar/dist/simplebar.js') }}"></script>
    
</body>

</html>
