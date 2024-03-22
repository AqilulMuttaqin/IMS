<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Production Stationery Control SAI</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo.png') }}" />
    <link rel="stylesheet" href="{{ asset('src/assets/css/styles.min.css?v=1.1') }}" />
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-sm-10 col-md-8 col-lg-6 col-xxl-6">
                        <div class="card mb-0">
                            <div class="card-body">
                                <!-- Logo dan Judul Project -->
                                <a href="#" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="{{ asset('images/shin-psc.png') }}" width="250" alt="">
                                </a>
                                <p class="text-center">Production Stationery Control</p>
                                @if (Session::has('alert-type'))
                                    <div class="alert alert-{{ Session::get('alert-type') }}">
                                        {{ Session::get('alert-message') }}
                                    </div>
                                @endif
                                <!-- Form Login -->
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="nik" name="nik" placeholder="Enter your Nik" autocomplete="off" required />
                                        <label for="nik" class="form-label">Nik</label>
                                    </div>
                                    <div class=" form-floating mb-5">
                                        <input type="password" id="password" class="form-control" name="password" placeholder="Enter your password" autocomplete="off" aria-describedby="password" required />
                                        <label class="form-label" for="password">Password</label>
                                    </div>
                                    <hr>
                                    <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign In</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('src/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
