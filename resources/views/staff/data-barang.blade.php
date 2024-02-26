@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="row">
                <div class="col-sm-4">
                    <h5 class="card-header">Data Barang</h5>
                </div>
                <div class="col-sm-8">
                    <div class="d-flex justify-content-end text-end pt-3 pe-3 mb-3">
                        <div class="dropdown text-end me-2">
                            <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                Download QR Code
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('download-zip') }}"><i
                                        class="bx bxs-file-archive me-1"></i> Download ZIP</a>
                                <a class="dropdown-item" href="{{ route('download-pdf') }}"><i
                                        class="bx bxs-file-pdf me-1"></i> Download PDF</a>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-primary d-flex align-items-center me-2" id="tambahBtn"
                            data-bs-toggle="modal" data-bs-target="#barangModal">
                            <i class="bx bx-plus me-1"></i>
                            Tambah Data
                        </button>
                        <button type="button" class="btn btn-sm btn-success d-flex align-items-center" id="importBtn">
                            <i class="bx bx-import me-1"></i>
                            Import Excel
                        </button>
                    </div>
                </div>
            </div>
            <div class="table-responsive text-nowrap pt-0 p-3">
                <table class="table table-striped" id="dataBarang">
                    <thead>
                        <tr>
                            <th style="width: 20px">No</th>
                            <th>Kode JS</th>
                            <th>Nama</th>
                            <th class="text-center">Min</th>
                            <th class="text-center">Max</th>
                            <th class="text-center">Price($)</th>
                            <th class="text-center" style="width: 90px">QR Code</th>
                            <th style="width: 30px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($barang as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $item->kode_js }}</td>
                                <td>{{ $item->nama }}</td>
                                <td class="text-center">{{ $item->min_stok }}</td>
                                <td class="text-center">{{ $item->max_stok }}</td>
                                <td class="text-center">{{ $item->harga }}</td>
                                <td>
                                    <div class="qrcode">
                                        <button class="btn btn-sm btn-primary d-flex align-items-center view-qr-code"
                                            data-id="{{ $item->kode_js }}" data-nama="{{ $item->nama }}">
                                            <i class="bx bxs-barcode me-1"></i>
                                            QR code
                                        </button>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#"><i class="bx bx-edit-alt me-1"></i>
                                                Edit</a>
                                            <form id="deleteForm{{ $item->kode_js }}" action="{{ route('staff.hapus-barang', $item->kode_js) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a type="submit" class="deleteBtn dropdown-item"><i class="bx bx-trash me-1"></i>Delete</a>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="qrCodeModal" tabindex="-1" role="dialog" aria-labelledby="qrCodeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrCodeModalLabel">QR Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex justify-content-center align-items-center">
                    <div id="qrCodeContainer"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-primary download-qr-code">Download QR Code</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="barangModal" tabindex="-1" role="dialog" aria-labelledby="barangModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="barangModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="barangForm">
                        <div class="form-group mb-3">
                            <label for="nojs">NO. JS</label>
                            <input type="text" class="form-control form-control-user" id="kode_js" name="kode_js"
                                required autofocus value="" maxlength="6" minlength="6">
                        </div>
                        <div class="form-group mb-3">
                            <label for="nama">NAMA</label>
                            <input type="text" class="form-control form-control-user" id="nama" name="nama"
                                required autofocus value="">
                        </div>
                        <div class="form-group mb-3">
                            <label for="stok">MIN</label>
                            <input type="text" class="form-control form-control-user" id="min_stok" name="min_stok"
                                required autofocus value="">
                        </div>
                        <div class="form-group mb-3">
                            <label for="stok">MAX</label>
                            <input type="text" class="form-control form-control-user" id="max_stok" name="max_stok"
                                required autofocus value="">
                        </div>
                        <div class="form-group mb-3">
                            <label for="stok">PRICE</label>
                            <input type="text" class="form-control form-control-user" id="harga" name="harga"
                                required autofocus value="">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-primary" id="submitBtn"
                        onclick="submitBarangForm()">Save Change</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#dataBarang').DataTable({
                processing: true,
                serveSide: true,
                scrollX: true,
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return '<td class="text-center">' + (meta.row + 1) + '</td>';
                        }
                    },
                    {
                        data: 'kode_js',
                        name: 'kode_js',
                        render: function(data, type, row, meta) {
                            return '<td>' + data + '</td>';
                        }
                    },
                    {
                        data: 'nama',
                        name: 'nama',
                        render: function(data, type, row, meta) {
                            return '<td>' + data + '</td>';
                        }
                    },
                    {
                        data: 'min_stok',
                        name: 'min_stok',
                        render: function(data, type, row, meta) {
                            return '<td class="text-center">' + data + '</td>';
                        }
                    },
                    {
                        data: 'max_stok',
                        name: 'max_stok',
                        render: function(data, type, row, meta) {
                            return '<td class="text-center">' + data + '</td>';
                        }
                    },
                    {
                        data: 'harga',
                        name: 'harga',
                        render: function(data, type, row, meta) {
                            return '<td class="text-center">' + data + '</td>';
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            return `
                                <td>
                                    <div class="qrcode">
                                        <button class="btn btn-sm btn-primary d-flex align-items-center view-qr-code"
                                            data-id="{{ $item->kode_js }}" data-nama="{{ $item->nama }}">
                                            <i class="bx bxs-barcode me-1"></i>
                                            QR code
                                        </button>
                                    </div>
                                </td>
                            `;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            return `
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#"><i class="bx bx-edit-alt me-1"></i>
                                                Edit</a>
                                            <form id="deleteForm{{ $item->kode_js }}" action="{{ route('staff.hapus-barang', $item->kode_js) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a type="submit" class="deleteBtn dropdown-item"><i class="bx bx-trash me-1"></i>Delete</a>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            `;
                        }
                    }
                ],
                drawCallback: function(settings) {
                    var pageInfo = table.page.info();
                    var start = pageInfo.start;
                    var api = this.api();

                    api.column(0, {
                        order: 'applied',
                        search: 'applied'
                    }).nodes().each(function(cell, i) {
                        cell.innerHTML = start + i + 1;
                    });
                }
            })
        })
    </script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
            $('#tambahBtn').click(function() {
                resetFormFields();
                $('#submitBtn').text('Submit');
                $('#barangModalLabel').text('Tambah data Barang');
                $('#barangForm').attr('action', '{{ route('staff.tambah-barang') }}');

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
                var formId = $(this).closest('form').attr('id');
                $('#' + formId).submit();
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
                    $('#barangModal').modal('hide');
                    Swal.fire({
                        title: "Success",
                        text: "Data Berhasil Disimpan",
                        icon: "success",
                        timer: 3500
                    });
                    window.reload();
                },
                error: function(xhr, status, error) {}
            });
        }
    </script>
@endpush
