<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} - Production Inventory SAI</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo.png') }}" />
    <link rel="stylesheet" href="{{ asset('src/assets/css/styles.min.css') }}" />
    <script src="{{ asset('src/assets/js/jquery-3.6.4.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/jquery.dataTables.min.css') }}">
    <script type="text/javascript" charset="utf8" src="{{ asset('src/assets/js/jquery.dataTables.js') }}"></script>
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        @include('layout.side')
        <div class="body-wrapper">
            @include('layout.nav')
            <div class="container-fluid">
                @yield('content')
            </div>
            @include('sweetalert::alert')
        </div>
    </div>
    <script src="{{ asset('src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('src/assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('src/assets/js/app.min.js') }}"></script>
    <script src="{{ asset('src/assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('src/assets/libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('src/assets/js/dashboard.js') }}"></script>
</body>

</html>
