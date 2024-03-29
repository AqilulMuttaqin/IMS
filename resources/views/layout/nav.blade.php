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
                <!-- Item Lokasi -->
                @if (auth()->user() && auth()->user()->role == 'user')
                    <li class="nav-item d-flex align-items-center gap-2" style="cursor: pointer">
                        <i class="ti ti-map-pin fs-6"></i>
                        <p class="mb-0 fs-3 me-2">{{ ucwords($userData['lokasi']['nama']) }}</p>
                    </li>
                @endif
                <!-- Item Dropdown Profile -->
                <li class="nav-item dropdown">
                    <!-- Navbar Item Profile -->
                    <a class="nav-link d-flex align-items-center gap-2" href="javascript:void(0)" id="drop2"
                        data-bs-toggle="dropdown">
                        <i class="ti ti-user fs-6"></i>
                        <p class="mb-0 fs-3 me-2">{{ ucwords(strtolower($userData['name'])) }}</p>
                        <img src="{{ asset('src/assets/images/profile/user-1.jpg') }}" alt="" width="35"
                            height="35" class="rounded-circle">
                    </a>
                    <!-- Dropdown Menu Item Profile -->
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                        <div class="message-body">
                            <div class="d-flex align-items-center gap-2 dropdown-item" style="cursor: pointer">
                                <i class="ti ti-users fs-6"></i>
                                @if ($userData['role'] === 'user')
                                    <p class="mb-0 fs-3">User Level</p>
                                @elseif($userData['role'] === 'admin')
                                    <p class="mb-0 fs-3">Staff Level</p>
                                @elseif($userData['role'] === 'spv')
                                    <p class="mb-0 fs-3">Supervisor Level</p>
                                @else
                                    <p class="mb-0 fs-3">Undefined Role</p>
                                @endif
                            </div>
                            <div class="d-flex align-items-center gap-2 dropdown-item" style="cursor: pointer">
                                <i class="ti ti-map-pin fs-6"></i>{{ ucwords(strtolower($userData['lokasi']['nama'])) }}
                            </div>
                            @if (auth()->user() && auth()->user()->role == 'user')
                                <a href="{{ route('user.profile')}}">
                                    <div class="d-flex align-items-center gap-2 dropdown-item" style="cursor: pointer">
                                        <i class="ti ti-user fs-6"></i>
                                        Profile
                                    </div>
                                </a>
                            @endif
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

{{-- <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileModalLabel">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="userForm">
                    <div class="form-group mb-3">
                        <label for="NIK">NIK</label>
                        <input type="text" class="form-control form-control-user" id="NIK" name="NIK"
                            required autofocus value="{{auth()->user()->NIK}}" maxlength="6" minlength="6">
                    </div>
                    <div class="form-group mb-3">
                        <label for="name">NAMA</label>
                        <input type="text" class="form-control form-control-user" id="name" name="name"
                            required autofocus value="{{auth()->user()->name}}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="user-lokasi">user-lokasi</label>
                        <select id="user-lokasi" name="user-lokasi" class="form-select" required></select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="role">ROLE</label>
                        <select class="form-control form-control-user" id="role" name="role" required>>
                            <option value="{{auth()->user()->role}}" disabled selected>{{auth()->user()->role}}</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitBtn" onclick="submitUserForm()">Save
                    Change</button>
            </div>
        </div>
    </div>
</div> --}}

<script>
    $('.edit-btn').on('click', function() {
        $('#profileModal').modal('show');
    });

    $('#profileModal').find('#user-lokasi').select2({
        theme: 'bootstrap-5',
        placeholder: ' Lokasi ...',
        minimumInputLength: 3,
        ajax: {
            url: "{{ route('spv.get-lokasi') }}",
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.nama,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    }).addClass('form-select');
</script>
