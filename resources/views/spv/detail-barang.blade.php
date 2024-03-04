@extends('layout.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-4">
                    <h5>Data Detail Barang</h5>
                </div>
                <div class="col-sm-8">
                    <div class="d-flex justify-content-end text-end">
                        <button type="button" class="btn btn-sm btn-primary d-flex align-items-center" id="tambahBtn"
                            data-bs-toggle="modal" data-bs-target="#detailBarangModal">
                            Tambah Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-striped" id="dataDetailBarang">
                    <thead>
                        <tr>
                            <th style="width: 20px">No</th>
                            <th>Kode JS</th>
                            <th>Nama</th>
                            <th>Invoice Num.</th>
                            <th>PO Num.</th>
                            <th>Lokasi</th>
                            <th>Qty</th>
                            <th style="width: 30px;">Actions</th>
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
                    <h5 class="modal-title" id="lokasiModalLabel">Daftar Lokasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-sm-9">
                            <div class="text-muted">Lokasi</div>
                        </div>
                        <div class="col-sm-3">
                            <div class="text-muted">Qty</div>
                        </div>
                    </div>
                    <div id="lokasiContainer"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="modal fade" id="detailBarangModal" tabindex="-1" role="dialog" aria-labelledby="detailBarangModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailBarangModalLabel">Tambah Data Barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="barangForm">
                            <div class="form-group mb-3">
                                <label for="nojs">NO. JS</label>
                                <input type="text" class="form-control form-control-user" id="nojs" name="nojs"
                                    required autofocus value="" maxlength="6" minlength="6">
                            </div>
                            <div class="form-group mb-3">
                                <label for="nama">NAMA</label>
                                <input type="text" class="form-control form-control-user" id="nama" name="nama"
                                    required autofocus value="">
                            </div>
                            <div class="form-group mb-3">
                                <label for="stok">STOK</label>
                                <input type="text" class="form-control form-control-user" id="stok" name="stok"
                                    required autofocus value="">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-sm btn-primary" id="submitBtn" onclick="submitUserForm()">Save
                            Change</button>
                    </div>
                </div>
            </div>
        </div> -->


    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#dataDetailBarang').DataTable({
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
                        data: 'kode_js',
                        name: 'kode_js'
                    },
                    {
                        data: 'barang.nama',
                        name: 'barang.nama'
                    },
                    {
                        data: 'inv_number',
                        name: 'inv_number'
                    },
                    {
                        data: 'PO_number',
                        name: 'PO_number'
                    },
                    {
                        data: null,
                        name: 'lokasi.nama',
                        render: function(data, type, row) {
                            return `
                            <button class="btn btn-sm btn-primary d-flex align-items-center btn-lihat-lokasi">
                                Lihat Lokasi
                            </button>
                            `;
                        }
                    },
                    {
                        data: 'total_qty',
                        name: 'lokasi.pivot.qty'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function() {
                            return `
                                <div class="dropdown">
                                    <button type="button" class="btn p-0" data-bs-toggle="dropdown">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#"><i class="ti ti-edit me-1"></i>
                                            Edit</a>
                                        <a class="dropdown-item" href="#"><i class="ti ti-trash me-1"></i>
                                            Delete</a>
                                    </div>
                                </div>
                            `;
                        }
                    }
                ]
            });

            $('#dataDetailBarang').on('click', '.btn-lihat-lokasi', function() {
                var row = $(this).closest('tr');
                var data = table.row(row).data();

                var dataBarang = data.kode_js;
                var barangNama = data.barang.nama;

                var lokasiHtml = '';
                $.each(data.lokasi, function(index, lokasi) {
                    lokasiHtml += '<div class="row"><div class="col-sm-9">' + (index + 1) + '. ' +
                        lokasi.nama + '</div><div class="col-sm-3">: ' + lokasi.pivot.qty +
                        '</div></div>';
                });

                $('#lokasiModalLabel').text('Daftar Lokasi untuk ' + barangNama);
                $('#lokasiContainer').html(lokasiHtml);
                $('#lokasiModal').modal('show');
            });
        });
    </script>
@endsection
