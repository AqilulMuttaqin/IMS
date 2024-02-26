<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="#" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('assets/img/logo.png')}}" alt="" width="30">
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2" style="text-transform: uppercase;">ims</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        @if (auth()->user() && auth()->user()->role == 'admin')
            <li class="menu-item {{ $title === 'Dashboard' ? 'active' : '' }}">
                <a href="{{ route('staff.dashboard')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Dashboard">Dashboard</div>
                </a>
            </li>
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Pages</span>
            </li>
            <li class="menu-item {{ $title === 'Update Stok' ? 'active' : '' }}">
                <a href="{{ route('staff.update-stok')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-refresh"></i>
                    <div data-i18n="Update Stok">Update Stok</div>
                </a>
            </li>
            <li class="menu-item {{ $title === 'Pesanan' ? 'active' : '' }}">
                <a href="{{ route('staff.pesanan')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-cart-alt"></i>
                    <div data-i18n="Pesanan">Pesanan</div>
                </a>
            </li>
            <li class="menu-item {{ $title === 'Data Barang' ? 'active' : '' }}">
                <a href="{{ route('staff.barang')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-data"></i>
                    <div data-i18n="Data Barang">Data Barang</div>
                </a>
            </li>
            <li class="menu-item {{ $title === 'Data Detail Barang' ? 'active' : '' }}">
                <a href="{{ route('staff.data-barang')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-data"></i>
                    <div data-i18n="Data Barang">Data Detail Barang</div>
                </a>
            </li>
        @endif
        {{-- <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-data"></i>
                <div data-i18n="Data Barang">Data Barang</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Gudang">Gudang</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Line">Line</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cart-alt"></i>
                <div data-i18n="Pesanan">Pesanan</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Request">Request</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Status">Status</div>
                    </a>
                </li>
            </ul>
        </li> --}}
    </ul>
</aside>
