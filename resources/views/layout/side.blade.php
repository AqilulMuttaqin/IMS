<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="./index.html" class="text-nowrap logo-img">
                <img src="{{ asset('src/assets/images/logos/dark-logo.svg') }}" width="180" alt="" />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
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
                        <a class="sidebar-link {{ $title === 'Update Stok' ? 'active' : ''}}" href="{{ route('staff.update-stok')}}" aria-expanded="false">
                            <span>
                                <i class="ti ti-refresh"></i>
                            </span>
                            <span class="hide-menu">Update Stok</span>
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
                        <a class="sidebar-link {{ $title === 'Data Master Barang' ? 'active' : ''}}" href="{{ route('staff.barang')}}" aria-expanded="false">
                            <span>
                                <i class="ti ti-article"></i>
                            </span>
                            <span class="hide-menu">Master Barang</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ $title === 'Barang Gudang' ? 'active' : ''}}" href="{{ route('staff.data-barang')}}" aria-expanded="false">
                            <span>
                                <i class="ti ti-building-warehouse"></i>
                            </span>
                            <span class="hide-menu">Barang Gudang</span>
                        </a>
                    </li>
                @endif
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
