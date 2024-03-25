@extends('layout.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-4">
                    <h5>Data Lokasi</h5>
                </div>
                <div class="col-sm-8">
                    <div class="d-flex justify-content-end text-end">
                        <div class="dropdown text-end me-2">
                            <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-bs-toggle="dropdown">
                                Import & Export
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('export-lokasi') }}">
                                    <i class="ti ti-file-export me-1"></i> Export Excel</a>
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#importModal" style="cursor: pointer;">
                                    <i class="ti ti-file-import me-1"></i> Import Excel</a>
                                <a class="dropdown-item" href="">
                                    <i class="ti ti-file-download me-1"></i> Format Import</a>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-primary d-flex align-items-center" id="tambahBtn"
                            data-bs-toggle="modal" data-bs-target="#lokasiModal">
                            Tambah Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-striped w-100" id="dataLokasi">
                    <thead>
                        <tr>
                            <th style="width: 20px">No</th>
                            <th>Nama Lokasi</th>
                            <th style="width: 90px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="note">
                <p class="text-danger">* Note: Data Lokasi (GUDANG PRODUKSI, SIAP SCRAP & SCRAP) tidak boleh diubah!!!</p>
            </div>
        </div>
    </div>

    <div class="modal fade" id="lokasiModal" tabindex="-1" role="dialog" aria-labelledby="lokasiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lokasiModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="lokasiForm">
                        <div class="form-group mb-3">
                            <label for="nama">NAMA LOKASI</label>
                            <input type="text" class="form-control form-control-user" id="nama" name="nama"
                                required autofocus value="">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitBtn"
                        onclick="submitLokasiForm()">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="importForm" method="POST" action="{{ route('spv.import-lokasi') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="import">File Excel</label>
                            <input type="file" class="form-control form-control-user" id="file" name="file"
                                accept=".xlsx, .xls" required autofocus>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="submitBtn">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#dataLokasi').DataTable({
                processing: false,
                serverSide: true,
                scrollX: true,
                ajax: {
                    url: '{{ url()->current() }}',
                    type: 'GET'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            var deleteRoute =
                                "{{ route('spv.hapus-lokasi', ['lokasi' => ':lokasi']) }}";
                            var deleteUrl = deleteRoute.replace(':lokasi', row.id);
                            return `
                                <div class="dropdown">
                                    <button type="button" class="btn p-0" data-bs-toggle="dropdown">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <button type="button" class="dropdown-item edit-btn" data-id="${row.id}"><i class="ti ti-edit me-1"></i>
                                            Edit</button>
                                        <form action="${deleteUrl}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="dropdown-item deleteBtn"><i class="ti ti-trash me-1"></i>Delete</button>
                                        </form>
                                    </div>
                                </div>
                            `;
                        }
                    }
                ]
            });

            $('#dataLokasi').on('click', '.edit-btn', function() {
                var id = $(this).data('id');
                var rowData = table.row($(this).parents('tr')).data();

                $('#nama').val(rowData.nama);
                $('#submitBtn').text('Edit');
                $('#lokasiModalLabel').text('Edit Data Lokasi');
                $('#lokasiForm').attr('action', '{{ route('spv.update-lokasi', ['id' => ':id']) }}'
                    .replace(':id', rowData.id));

                $('#lokasiModal').modal('show');
            })

            $('#tambahBtn').click(function() {
                resetFormFields();
                $('#submitBtn').text('Submit');
                $('#lokasiModalLabel').text('Tambah Data Lokasi');
                $('#lokasiForm').attr('action', '{{ route('spv.tambah-lokasi') }}');

                $('#lokasiModal').modal('show');
            });

            function resetFormFields() {
                $('#nama').val('');
            }

            $('#dataLokasi').on('click', '.deleteBtn', function() {
                var form = $(this).closest('form');
                var deleteUrl = form.attr('action');

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
                        $.ajax({
                            type: 'POST',
                            url: deleteUrl,
                            data: form.serialize(),
                            success: function(response) {
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    text: 'Data berhasil dihapus',
                                    icon: 'success',
                                    timer: 3500
                                });
                                table.ajax.reload();
                            },
                            error: function(error) {
                                console.error('Error deleting user:', error);

                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    icon: 'error',
                                    text: 'Terjadi kesalahan saat menghapus data!',
                                    timer: 3500
                                });
                            }
                        });
                    }
                });
            });
        });

        function submitLokasiForm() {
            var formData = $('#lokasiForm').serialize();
            var actionUrl = $('#lokasiForm').attr('action');
            var method = 'POST';

            if (actionUrl.includes('update-lokasi')) {
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
                    $('#dataLokasi').DataTable().ajax.reload();
                    $('#lokasiModal').modal('hide');
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        text: "Data Berhasil Disimpan",
                        icon: "success",
                        timer: 3500
                    });
                },
                error: function(error) {
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        text: "Error!! Duplicate Lokasi",
                        icon: "error",
                        timer: 3500
                    })
                }
            });
        }
    </script>
@endsection
