@extends('layout.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-4">
                    <h5>Data Master Barang</h5>
                </div>
                <div class="col-sm-8">
                    <div class="d-flex justify-content-end text-end">
                        <div class="dropdown text-end me-2">
                            <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                Download QR Code
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('download-zip') }}"><i
                                        class="ti ti-file-zip me-1"></i> Download ZIP</a>
                                <a class="dropdown-item" href="{{ route('download-pdf') }}" target="_blank"><i
                                        class="ti ti-file-text me-1"></i> Download PDF</a>
                            </div>
                        </div>
                        <div class="dropdown text-end me-2">
                            <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-bs-toggle="dropdown">
                                Impor & Ekspor
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('spv.export-barang') }}"><i
                                        class="ti ti-file-export me-1"></i> Export
                                    Excel</a>
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#importModal"
                                    style="cursor: pointer;"><i class="ti ti-file-import me-1"></i> Import Excel</a>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-primary d-flex align-items-center" id="tambahBtn"
                            data-bs-toggle="modal" data-bs-target="#barangModal">
                            Tambah Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table w-100" id="dataBarang">
                    <thead>
                        <tr>
                            <th style="width: 20px">No</th>
                            <th>Kode JS</th>
                            <th>Nama</th>
                            <th>Min</th>
                            <th>Max</th>
                            <th>Price($)</th>
                            <th>Qty</th>
                            <th style="width: 90px">QR Code</th>
                            <th style="width: 30px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="qrCodeModal" tabindex="-1" role="dialog" aria-labelledby="qrCodeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrCodeModalLabel">QR Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex justify-content-center align-items-center">
                    <div id="qrCodeContainer"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-primary download-qr-code">Download QR Code</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="barangModal" tabindex="-1" role="dialog" aria-labelledby="barangModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="barangModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="barangForm">
                        <div class="form-group mb-3">
                            <label for="kode_js">NO. JS</label>
                            <input type="text" class="form-control form-control-user" id="kode_js" name="kode_js"
                                required autofocus value="" maxlength="6" minlength="6">
                        </div>
                        <div class="form-group mb-3">
                            <label for="nama">NAMA</label>
                            <input type="text" class="form-control form-control-user" id="nama" name="nama"
                                required autofocus value="">
                        </div>
                        <div class="form-group mb-3">
                            <label for="min_stok">MIN</label>
                            <input type="number" class="form-control form-control-user" id="min_stok" name="min_stok"
                                required autofocus value="">
                        </div>
                        <div class="form-group mb-3">
                            <label for="max_stok">MAX</label>
                            <input type="number" class="form-control form-control-user" id="max_stok" name="max_stok"
                                required autofocus value="">
                        </div>
                        <div class="form-group mb-3">
                            <label for="harga">PRICE</label>
                            <input type="number" class="form-control form-control-user" id="harga" name="harga"
                                required autofocus value="">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitBtn"
                        onclick="submitBarangForm()">Submit</button>
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
                <form id="importForm" method="POST" action="{{ route('spv.import-barang') }}"
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

            var table = $('#dataBarang').DataTable({
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
                        data: 'kode_js',
                        name: 'kode_js'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'min_stok',
                        name: 'min_stok'
                    },
                    {
                        data: 'max_stok',
                        name: 'max_stok'
                    },
                    {
                        data: 'harga',
                        name: 'harga'
                    },
                    {
                        data: 'total_qty',
                        name: 'total_qty'
                    },
                    {
                        data: 'qr_code',
                        name: 'qr_code',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return `
                                <div class="qrcode">
                                    <button class="btn btn-sm btn-primary d-flex align-items-center view-qr-code"
                                        data-id="${row.kode_js}" data-nama="${row.nama}">
                                        <i class="ti ti-qrcode me-1"></i>
                                        QR code
                                    </button>
                                </div>
                            `;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            var deleteRoute =
                                "{{ route('spv.hapus-barang', ['barang' => ':barang']) }}";
                            var deleteUrl = deleteRoute.replace(':barang', row.kode_js);
                            return `
                                <div class="dropdown">
                                    <button type="button" class="btn p-0"
                                        data-bs-toggle="dropdown">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <button type="button" class="dropdown-item detail-btn" data-js="${row.kode_js}">
                                            <i class="ti ti-eye me-1"></i>
                                            Detail Lokasi
                                        </button>
                                        <button type="button" class="dropdown-item edit-btn" data-js="${row.kode_js}">
                                            <i class="ti ti-edit me-1"></i>
                                            Edit
                                        </button>
                                        <form action="${deleteUrl}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="dropdown-item deleteBtn">
                                                <i class="ti ti-trash me-1"></i>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            `;
                        }
                    }
                ],
                createdRow: function(row, data, dataIndex) {
                    if (data.total_qty <= data.min_stok) {
                        $(row).attr('style', 'background-color: #ffb0b0');
                    } else if (data.total_qty >= data.max_stok) {
                        $(row).attr('style', 'background-color: #cffffd');
                    }
                }
            });

            var id;
            var nama;
            $(document).on('click', '.view-qr-code', function() {
                id = $(this).data('id');
                nama = $(this).data('nama');

                var qrCodeContent = id;

                $.ajax({
                    url: '{{ route('qr.generate') }}',
                    method: 'POST',
                    data: {
                        qrCodeContent: qrCodeContent,
                        nama: nama
                    },
                    success: function(response) {
                        $('#qrCodeContainer').html(
                            '<img style="width: 100%; height: auto;" src="data:image/png;base64,' +
                            response + '">');
                        $('#qrCodeModal').modal('show');
                    }
                });
            });

            $(document).on('click', '.download-qr-code', function() {
                var qrCodeContent = id;

                $.ajax({
                    url: '{{ route('qr.download') }}',
                    method: 'POST',
                    data: {
                        qrCodeContent: qrCodeContent,
                        nama: nama
                    },
                    xhrFields: {
                        responseType: 'blob'
                    },
                    success: function(blob) {
                        var url = window.URL.createObjectURL(blob);

                        var link = document.createElement('a');
                        link.href = url;
                        link.download = '' + nama + '.png';
                        document.body.appendChild(link);

                        link.click();

                        window.URL.revokeObjectURL(url);
                        document.body.removeChild(link);
                    }
                });
            });

            $('#dataBarang').on('click', '.edit-btn', function() {
                var js = $(this).data('js');
                var rowData = table.row($(this).parents('tr')).data();

                $('#kode_js').val(rowData.kode_js);
                $('#nama').val(rowData.nama);
                $('#min_stok').val(rowData.min_stok);
                $('#max_stok').val(rowData.max_stok);
                $('#harga').val(rowData.harga);
                $('#submitBtn').text('Edit');
                $('#barangModalLabel').text('Edit Data Barang');
                $('#barangForm').attr('action', '{{ route('spv.update-barang', ['barang' => ':barang']) }}'
                    .replace(':barang', rowData.kode_js));

                $('#barangModal').modal('show');
            });

            $('#tambahBtn').click(function() {
                resetFormFields();
                $('#submitBtn').text('Submit');
                $('#barangModalLabel').text('Tambah data Barang');
                $('#barangForm').attr('action', '{{ route('spv.tambah-barang') }}');

                $('#barangModal').modal('show');
            });

            function resetFormFields() {
                $('#kode_js').val('');
                $('#nama').val('');
                $('#min_stok').val('');
                $('#max_stok').val('');
                $('#harga').val('');
            }

            $(document).on('click', '.deleteBtn', function() {
                var row = table.row($(this).closest('tr')).data();
                var kode_js = row.kode_js;
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
        });

        function submitBarangForm() {
            var formData = $('#barangForm').serialize();
            var actionUrl = $('#barangForm').attr('action');
            var method = 'POST';

            if (actionUrl.includes('update-barang')) {
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
                    $('#dataBarang').DataTable().ajax.reload();
                    $('#barangModal').modal('hide');

                    Swal.fire({
                        title: "Success",
                        text: "Data Berhasil Disimpan",
                        icon: "success",
                        timer: 3500,
                    });
                },
                error: function(xhr, status, error) {}
            });
        }
    </script>
@endsection
