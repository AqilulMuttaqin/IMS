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
                        <button type="button" class="btn btn-sm btn-primary d-flex align-items-center" id="tambahBtn"
                            data-bs-toggle="modal" data-bs-target="#lokasiModal">
                            <i class="ti ti-plus me-1"></i>
                            Tambah Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-striped" id="dataLokasi">
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
                                            <button type="submit" class="dropdown-item deleteBtn"><i class="ti ti-trash me-1"></i>Delete</button>
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

            $(document).on('click', '.deleteBtn', function() {
                var formId = $(this).closest('form').attr('id');
                $('#' + formId).submit();
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
                    // alert()->success('SuccessAlert','Lorem ipsum dolor sit amet.');
                    // toast('Success Toast','success');
                },
                error: function(xhr, status, error) {}
            });
        }
    </script>
@endsection
