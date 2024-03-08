@extends('layout.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-5">
                    <h5>Data Detail Barang</h5>
                </div>
                <div class="col-sm-7">
                    <div class="d-flex justify-content-end text-end">
                        <button type="button" class="btn btn-sm btn-success d-flex align-items-center" id="exportBtn">
                            <i class="ti ti-file-export me-1"></i>
                            Export Excel
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table w-100" id="dataDetailBarang">
                    <thead>
                        <tr>
                            <th style="width: 20px">No</th>
                            <th>Kode JS</th>
                            <th>Nama</th>
                            <th>Invoice Num.</th>
                            <th>PO Num.</th>
                            <th>Lokasi</th>
                            <th>Qty</th>
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
                    {{-- <div class="row mb-2">
                        <div class="col-sm-9">
                            <div class="text-muted">Lokasi</div>
                        </div>
                        <div class="col-sm-3">
                            <div class="text-muted">Qty</div>
                        </div>
                    </div>
                    <div id="lokasiContainer"></div> --}}
                    <div class="table-responsive text-nowrap">
                        <table id="lokasiTable" class="table table-striped w-100">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Lokasi</th>
                                    <th>Qty</th>
                                </tr>
                            </thead>
                            <tbody id="lokasiTableBody"></tbody>
                        </table>
                    </div>
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
            var groupColumn = 2;
            var table = $('#dataDetailBarang').DataTable({
                columnDefs: [{ visible: false, targets: [groupColumn, 1] }],
                processing: false,
                serverSide: true,
                scrollX: true,
                ajax: {
                    url: '{{ url()->current() }}',
                    type: 'GET'
                },
                columns: [
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    // {
                    //     data: 'DT_RowIndex',
                    //     name: 'DT_RowIndex'
                    // },
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
                    }
                ],
                order: [[groupColumn, 'asc']], // Order by the grouping column
                drawCallback: function(settings) {
                    var api = this.api();
                    var rows = api.rows({ page: 'current' }).nodes();
                    var last = null;

                    api.column(groupColumn, { page: 'current' })
                        .data()
                        .each(function(group, i) {
                            if (last !== group) {
                                // Calculate sum of total_qty for the current group
                                var groupSum = api
                                    .rows(function(idx, data, node) {
                                        return data.barang.nama === group;
                                    })
                                    .data()
                                    .pluck('total_qty')
                                    .reduce(function(sum, qty) {
                                        return sum + parseInt(qty);
                                    }, 0);

                                $(rows)
                                    .eq(i)
                                    
                                    .before('<tr class="group" style="background-color: #dae2e8"><td colspan="1"></td><td colspan="2">' + group + '</td><td><button data-id="'+group+'" class="btn btn-sm btn-success d-flex align-items-center btn-lihat-lokasi-total">Lihat Lokasi</button></td><td colspan="1">' + groupSum + '</td></tr>');
                                last = group;
                            }
                        });
                }
            });

            // $('#dataDetailBarang tbody').on('click', 'tr.group', function() {
            //     var currentOrder = table.order()[0];
            //     if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
            //         table.order([groupColumn, 'desc']).draw();
            //     } else {
            //         table.order([groupColumn, 'asc']).draw();
            //     }
            // });

            $('#dataDetailBarang').on('click', '.btn-lihat-lokasi', function() {

                var row = $(this).closest('tr');
                var data = table.row(row).data();
                var barangNama = data.barang.nama;

                var lokasiTotals = [];
                $.each(data.lokasi, function(index, lokasi) {
                    var lokasiNama = lokasi.nama;
                    var lokasiQty = lokasi.pivot.qty;

                    lokasiTotals.push({
                        Lokasi: lokasiNama,
                        Qty: lokasiQty
                    });
                });

                $('#lokasiModalLabel').text('Daftar Lokasi untuk ' + barangNama);
                $('#lokasiTableBody').empty();

                var lokasiTable = $('#lokasiTable').DataTable({
                    data: lokasiTotals,
                    columns: [
                        {
                            data: null,
                            render: function(data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        { data: 'Lokasi' },
                        { data: 'Qty' }
                    ],
                    destroy: true
                });

                $('#lokasiModal').modal('show');
            });

            $('#dataDetailBarang').on('click', '.btn-lihat-lokasi-total', function() {
                var group = $(this).data('id');

                $('#lokasiModalLabel').text('Daftar Lokasi untuk ' + group);
                $('#lokasiTableBody').empty();

                var lokasiTable = $('#lokasiTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('spv.getLokasiQty') }}",
                        data: function(d) {
                            d.nama = group;
                        }
                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                        { data: 'lokasi', name: 'lokasi' },
                        { data: 'total_qty', name: 'total_qty' }
                    ],
                    destroy: true
                });

                $('#lokasiModal').modal('show');
            });
        });
    </script>
@endsection
