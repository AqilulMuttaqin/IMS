<!-- Content Sidebar -->
<aside class="left-sidebar">
    <div>
        <!-- Brand Sidebar Logo -->
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="#" class="text-nowrap logo-img pt-3">
                <img src="{{ asset('images/shin-psc.png') }}" width="200" alt="" />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar Navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <!-- Sidebar Menu User -->
                @if (auth()->user() && auth()->user()->role == 'user')
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Home</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ $title === 'Dashboard' ? 'active' : ''}}" href="{{ route('user.home')}}" aria-expanded="false">
                            <span>
                                <i class="ti ti-layout-dashboard"></i>
                            </span>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Pages</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ $title === 'Pesanan' ? 'active' : ''}}" href="{{ route('user.pesanan')}}" aria-expanded="false">
                            <span>
                                <i class="ti ti-shopping-cart"></i>
                            </span>
                            <span class="hide-menu">Data Pesanan</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ $title === 'Data Barang' ? 'active' : ''}}" href="{{ route('user.barang')}}" aria-expanded="false">
                            <span>
                                <i class="ti ti-article"></i>
                            </span>
                            <span class="hide-menu">Data Barang</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ $title === 'Profile' ? 'active' : ''}}" href="{{ route('user.profile')}}" aria-expanded="false">
                            <span>
                                <i class="ti ti-user"></i>
                            </span>
                            <span class="hide-menu">Profile</span>
                        </a>
                    </li>
                @endif
                <!-- Sidebar Menu Admin -->
                @if (auth()->user() && auth()->user()->role == 'admin')
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Home</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ $title === 'Dashboard' ? 'active' : ''}}" href="{{ route('staff.dashboard')}}" aria-expanded="false">
                            <span>
                                <i class="ti ti-layout-dashboard"></i>
                            </span>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Pages</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ $title === 'Barang Gudang' ? 'active' : ''}}" href="{{ route('staff.data-barang')}}" aria-expanded="false">
                            <span>
                                <i class="ti ti-building-warehouse"></i>
                            </span>
                            <span class="hide-menu">Barang Gudang</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ $title === 'Pesanan' ? 'active' : ''}}" href="{{ route('staff.pesanan')}}" aria-expanded="false">
                            <span>
                                <i class="ti ti-shopping-cart"></i>
                            </span>
                            <span class="hide-menu">Data Pesanan</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ $title === 'Update Stok' ? 'active' : ''}}" href="{{ route('staff.update-stok')}}" aria-expanded="false">
                            <span>
                                <i class="ti ti-refresh"></i>
                            </span>
                            <span class="hide-menu">Update Stok</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ $title === 'Data Master Barang' ? 'active' : ''}}" href="{{ route('staff.barang')}}" aria-expanded="false">
                            <span>
                                <i class="ti ti-article"></i>
                            </span>
                            <span class="hide-menu">Master Barang</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ $title === 'Input Data STO' ? 'active' : ''}}" href="{{ route('staff.input-sto')}}" aria-expanded="false">
                            <span>
                                <i class="ti ti-checkup-list"></i>
                            </span>
                            <span class="hide-menu">Input STO</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ $title === 'Data Hasil STO' ? 'active' : ''}}" href="{{ route('staff.hasil-sto')}}" aria-expanded="false">
                            <span>
                                <i class="ti ti-checklist"></i>
                            </span>
                            <span class="hide-menu">Data STO</span>
                        </a>
                    </li>
                @endif
                <!-- Sidebar Menu SPV -->
                @if (auth()->user() && auth()->user()->role == 'spv')
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Home</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ $title === 'Dashboard' ? 'active' : ''}}" href="{{ route('spv.dashboard')}}" aria-expanded="false">
                            <span>
                                <i class="ti ti-layout-dashboard"></i>
                            </span>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Pages</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ $title === 'Data Master Barang' ? 'active' : ''}}" href="{{ route('spv.master-barang')}}" aria-expanded="false">
                            <span>
                                <i class="ti ti-article"></i>
                            </span>
                            <span class="hide-menu">Master Barang</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ $title === 'Data Detail Barang' ? 'active' : ''}}" href="{{ route('spv.detail-barang')}}" aria-expanded="false">
                            <span>
                                <i class="ti ti-cards"></i>
                            </span>
                            <span class="hide-menu">Detail Barang</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ $title === 'Data Stok Barang' ? 'active' : ''}}" href="{{ route('spv.level-stok')}}" aria-expanded="false">
                            <span>
                                <i class="ti ti-database"></i>
                            </span>
                            <span class="hide-menu">Level Stok</span>
                        </a>
                    </li>
                    {{-- <li class="sidebar-item">
                        <a class="sidebar-link {{ $title === 'History Pesanan' ? 'active' : ''}}" href="{{ route('spv.history-pesanan')}}" aria-expanded="false">
                            <span>
                                <i class="ti ti-shopping-cart"></i>
                            </span>
                            <span class="hide-menu">History Pesanan</span>
                        </a>
                    </li> --}}
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ $title === 'In-Out Barang' ? 'active' : ''}}" href="{{ route('spv.in-out')}}" aria-expanded="false">
                            <span>
                                <i class="ti ti-history-toggle"></i>
                            </span>
                            <span class="hide-menu">In-Out Barang</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ $title === 'Control Barang' ? 'active' : ''}}" href="{{ route('spv.control-barang')}}" aria-expanded="false">
                            <span>
                                <i class="ti ti-refresh-alert"></i>
                            </span>
                            <span class="hide-menu">Control Barang</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ $title === 'Data Lokasi' ? 'active' : ''}}" href="{{ route('spv.lokasi')}}" aria-expanded="false">
                            <span>
                                <i class="ti ti-map-pin"></i>
                            </span>
                            <span class="hide-menu">Data Lokasi</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ $title === 'Data User' ? 'active' : ''}}" href="{{ route('spv.user')}}" aria-expanded="false">
                            <span>
                                <i class="ti ti-users"></i>
                            </span>
                            <span class="hide-menu">Data User</span>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>
