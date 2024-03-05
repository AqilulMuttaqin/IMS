@extends('layout.app')

@section('content')
    <!-- Container Content Data User -->
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-4">
                    <h5>Data User</h5>
                </div>
                <div class="col-sm-8">
                    <div class="d-flex justify-content-end text-end">
                        <button type="button" class="btn btn-sm btn-primary d-flex align-items-center me-2"
                            id="tambahDataBtn">
                            Tambah Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Tabel User -->
            <div class="table-responsive text-nowrap">
                <table class="table table-striped" id="dataUser">
                    <thead>
                        <tr>
                            <th style="width: 20px">No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Role</th>
                            <th>Lokasi</th>
                            <th style="width: 30px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTable Data User -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal - Tambah dan Edit User -->
    <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="userForm">
                        <div class="form-group mb-3">
                            <label for="NIK">NIK</label>
                            <input type="text" class="form-control form-control-user" id="NIK" name="NIK" required autofocus value="" maxlength="6" minlength="6">
                        </div>
                        <div class="form-group mb-3">
                            <label for="name">NAMA</label>
                            <input type="text" class="form-control form-control-user" id="name" name="name" required autofocus value="">
                        </div>
                        <div class="form-group mb-3">
                            <label for="role">ROLE</label>
                            <select class="form-control form-control-user" id="role" name="role" required>>
                                <option value="" disabled selected></option>
                                <option value="spv">Supervisor</option>
                                <option value="admin">Staff Gudang</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="lokasi">LOKASI</label>
                            <select class="form-control form-control-user" id="lokasi" name="lokasi" required>>
                                <option value="" disabled selected></option>
                                @foreach($lokasi as $item)
                                    <option value="{{ $item->id}}">{{$item->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">PASSWORD</label>
                            <input type="text" class="form-control form-control-user" id="password" name="password" required autofocus value="">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitBtn" onclick="submitUserForm()">Save Change</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#dataUser').DataTable({
                processing: false,
                serverSide: true,
                ajax: {
                    url: '{{ url()->current() }}',
                    type: 'GET'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'NIK',
                        name: 'NIK'
                    },
                    {
                        data: 'name',
                        name: 'nama'
                    },
                    {
                        data: 'role',
                        name: 'role'
                    },
                    {
                        data: 'lokasi.nama',
                        name: 'lokasi.nama'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            var deleteRoute =
                                "{{ route('spv.hapus-user', ['user' => ':user']) }}";
                            var deleteUrl = deleteRoute.replace(':user', row.NIK);
                            return `
                                <div class="dropdown">
                                    <button type="button" class="btn p-0" data-bs-toggle="dropdown">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <button type="button" class="dropdown-item edit-btn" data-js="${row.NIK}"><i class="ti ti-edit me-1"></i>
                                            Edit</button>
                                        <form action="${deleteUrl}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="dropdown-item confirm-delete"><i class="ti ti-trash me-1"></i>Delete</button>
                                        </form>
                                    </div>
                                </div>
                            `;
                        }
                    }
                ]
            });

            $('#dataUser').on('click', '.confirm-delete', function() {
                var row = table.row($(this).closest('tr')).data();
                var NIK = row.NIK;
                var form = $(this).closest('form');

                Swal.fire({
                    title: "Anda Yakin?",
                    text: "Data tidak dapat dikembalikan setelah dihapus!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Hapus"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            $('#dataUser').on('click', '.edit-btn', function() {
                var NIK = $(this).data('nik');
                var rowData = table.row($(this).parents('tr')).data();

                $('#NIK').val(rowData.NIK).prop('disabled', true);
                $('#name').val(rowData.name);
                $('#role').val(rowData.role);
                $('#password').val(rowData.pw);
                $('#lokasi').val(rowData.lokasi_id);
                $('#submitBtn').text('Edit');
                $('#userModalLabel').text('Edit Data User');
                $('#userForm').attr('action', '{{ route('spv.update-user', ['user' => ':user']) }}'.replace(
                    ':user', rowData.NIK));

                $('#userModal').modal('show');
            });

            $('#tambahDataBtn').click(function() {
                resetFormFields();
                $('#NIK').prop('disabled', false);
                $('#submitBtn').text('Submit');
                $('#userModalLabel').text('Tambah User');
                $('#userForm').attr('action', '{{ route('spv.tambah-user') }}');

                $('#userModal').modal('show');
            });

            function resetFormFields() {
                $('#NIK').val('');
                $('#name').val('');
                $('#role').val('');
                $('#password').val('');
                $('#lokasi').val('');
            }
        });

        function submitUserForm() {
            var nikInput = $('#NIK').val();
            var passwordInput = $('#password').val();

            if (nikInput.length < 6) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "NIK harus 6 digit!",
                });
                return false;
            } else if (passwordInput < 6) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Password kurang dari 6 karakter!"
                });
                return false;
            }

            var formData = $('#userForm').serialize();
            var actionUrl = $('#userForm').attr('action');
            var method = 'POST';

            if (actionUrl.includes('user-update')) {
                method = 'PUT';
            }

            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: actionUrl,
                type: method,
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    $('#dataUser').DataTable().ajax.reload();
                    $('#userModal').modal('hide');
                    Swal.fire({
                        title: "Success",
                        text: "Data Berhasil Disimpan",
                        icon: "success",
                        timer: 3500
                    });
                },
                error: function(xhr, status, error) {}
            });
        }
    </script>
@endsection
