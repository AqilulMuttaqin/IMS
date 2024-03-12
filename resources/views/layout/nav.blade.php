<!-- Session Untuk Mendapatkan Data User -->
@php
    $userData = session('user');
@endphp

<!-- Content Header Navbar -->
<header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav d-flex">
            <!-- Sidebar Toggle -->
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2"></i>
                </a>
            </li>
            <!-- Pages Content -->
            <li class="nav-item text-nowrap">
                <ol class="breadcrumb bg-transparent m-2">
                    <li class="breadcrumb-item text-sm opacity-5">Pages</li>
                    <li class="breadcrumb-item text-sm text-dark">{{ $title }}</li>
                </ol>
            </li>
        </ul>
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                <!-- Item Dropdown Profile -->
                <li class="nav-item dropdown">
                    <!-- Navbar Item Profile -->
                    <a class="nav-link d-flex align-items-center gap-1" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown">
                        <i class="ti ti-user fs-6"></i>
                        <p class="mb-0 fs-3 me-2">{{ ucwords($userData['name']) }}</p>
                        <img src="{{ asset('src/assets/images/profile/user-1.jpg') }}" alt="" width="35" height="35" class="rounded-circle">
                    </a>
                    <!-- Dropdown Menu Item Profile -->
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                        <div class="message-body">
                            <div class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-user fs-6"></i>
                                @if ($userData['role'] === 'user')
                                    <p class="mb-0 fs-3">User</p>
                                @elseif($userData['role'] === 'admin')
                                    <p class="mb-0 fs-3">Staff</p>
                                @elseif($userData['role'] === 'spv')
                                    <p class="mb-0 fs-3">Supervisor</p>
                                @else
                                    <p class="mb-0 fs-3">Undefined Role</p>
                                @endif
                            </div>
                            <!-- Form Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="btn btn-outline-danger mx-3 mt-2 d-block">Logout</a>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
