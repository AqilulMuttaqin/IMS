<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} - Production Inventory SAI</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo.png') }}" />
    <link rel="stylesheet" href="{{ asset('src/assets/css/styles.min.css') }}" />
    <script src="{{ asset('src/assets/js/jquery-3.6.4.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/jquery.dataTables.min.css') }}">
    <script type="text/javascript" charset="utf8" src="{{ asset('src/assets/js/jquery.dataTables.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/select2.min.css') }}">
    <script type="text/javascript" charset="utf8" src="{{ asset('src/assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('src/assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('src/assets/js/moment-timezone-with-data.min.js') }}"></script>
    
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
</head>

<body>
    <!-- Content Page Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" ata-sidebar-position="fixed" data-header-position="fixed">
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
    <script src="{{ asset('src/assets/js/sweetalert2@11.js')}}"></script>
    <script src="{{ asset('src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('src/assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('src/assets/js/app.min.js') }}"></script>
    <script src="{{ asset('src/assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('src/assets/libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('src/assets/js/dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>

</html>
