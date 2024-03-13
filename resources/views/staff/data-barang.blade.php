@extends('layout.app')

@section('content')
    <!-- Container Content Data Master Barang -->
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-4">
                    <h5>Data Barang</h5>
                </div>
                <div class="col-sm-8">
                    <div class="d-flex justify-content-end text-end">
                        <!-- Dropdown Action Download Qr COde (zip,pdf) -->
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
                            <th>Satuan</th>
                            <th>Min</th>
                            <th>Max</th>
                            <th>Price($)</th>
                            <th>Kategori</th>
                            <th>Qty</th>
                            <th style="width: 90px">QR Code</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTable Data Master Barang -->
                    </tbody>
                </table>
            </div>
            <div class="row mt-3">
                <div class="col-lg-2 col-md-3 col-sm-12 d-flex">
                    <p class="fw-bold h6">Keterangan</p>
                    <p class="fw-bold ms-5">:</p>
                </div>
                <div class="col-lg-10 col-md-9 col-sm-12 d-flex">
                    <span class="badge border border-dark rounded-pill me-2" style="height: 20px; margin-top: 2px; background-color: #ffb0b0"> </span>
                    <p>Stok Kurang Dari Batas Minimum</p>
                    <span class="badge border border-dark rounded-pill me-2 ms-4" style="height: 20px; margin-top: 2px; background-color: #cffffd"> </span>
                    <p>Stok Lebih Dari Batas Maximum</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal - Qr Code -->
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

    <!-- JavaScript -->
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
                        data: 'satuan',
                        name: 'satuan'
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
                        data: 'kategori',
                        name: 'kategori'
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
                                    <button class="btn btn-sm btn-primary d-flex align-items-center view-qr-code" data-id="${row.kode_js}" data-nama="${row.nama}">
                                        <i class="ti ti-qrcode me-1"></i>
                                        QR code
                                    </button>
                                </div>
                            `;
                        }
                    },
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
                    $('#dataBarang').DataTable().ajax.reload();
                    $('#barangModal').modal('hide');
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
