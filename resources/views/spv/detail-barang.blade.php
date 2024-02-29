@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
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
                                <i class="bx bx-plus me-1"></i>
                                Tambah Data
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataDetailBarang">
                        <thead>
                            <tr>
                                <th style="width: 20px">No</th>
                                <th class="text-center">Kode JS</th>
                                <th>Nama</th>
                                <th>Invoice Num.</th>
                                <th>PO Num.</th>
                                <th>Lokasi</th>
                                <th class="text-center">Qty</th>
                                <th style="width: 30px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="lokasiModal" tabindex="-1" role="dialog" aria-labelledby="lokasiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lokasiModalLabel">Daftar Lokasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex justify-content-center align-items-center">
                    <div id="lokasiContainer"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="modal fade" id="detailBarangModal" tabindex="-1" role="dialog" aria-labelledby="detailBarangModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
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
                                <i class="bx bx-show-alt me-1"></i>
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
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#"><i class="bx bx-edit-alt me-1"></i>
                                            Edit</a>
                                        <a class="dropdown-item" href="#"><i class="bx bx-trash me-1"></i>
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
                    lokasiHtml += '<div>' + (index + 1) + '. ' + lokasi.nama + ' - Qty: ' + lokasi.pivot.qty + '</div>';
                });

                $('#lokasiModalLabel').text('Daftar Lokasi untuk ' + barangNama);
                $('#lokasiContainer').html(lokasiHtml);
                $('#lokasiModal').modal('show');
            });
        });
    </script>
@endsection
