@extends('layout.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Data Status Pesanan</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-striped w-100" id="dataStatusPesanan">
                    <thead>
                        <tr>
                            <th style="width: 20px">No</th>
                            <th>Kode Pesan</th>
                            <th>Nama Pesanan</th>
                            <th>Tanggal Dibuat</th>
                            <th>Tanggal Selesai</th>
                            <th style="width: 90px">Status</th>
                            <th style="width: 90px">Detail Pesanan</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="statusPesananModal" tabindex="-1" role="dialog" aria-labelledby="statusPesananModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusPesananModalLabel">Detail Pesanan Anda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-xxl" id="modal-body">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
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
            var table = $('#dataStatusPesanan').DataTable({
                processing: false,
                serverSide: true,
                scrollX: true,
                order: [
                    [2, 'desc']
                ],
                ajax: {
                    url: '{{ url()->current() }}',
                    type: 'GET'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: null
                    },
                    {
                        data: 'user.name',
                        name: 'user.name'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, row, meta) {
                            var formattedDate = moment.utc(data).tz('Asia/Jakarta').format(
                                'D MMM YYYY');
                            return `
                                <td class="text-center">` + formattedDate + `</td>
                            `;
                        }
                    },
                    {
                        data: 'edited_at',
                        name: 'null',
                        render: function(data, row, meta) {
                            if (row.status !== 'selesai') {
                                return `
                                    <td class="text-center">-</td>
                                `;
                            } else {
                                var formattedDate = moment.utc(data).tz('Asia/Jakarta').format(
                                    'D MMM YYYY');
                                return `
                                    <td class="text-center">` + formattedDate + `</td>
                                `;
                            };
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, full, meta) {
                            var statusClass;
                            switch (data) {
                                case "pending":
                                    statusClass = "bg-danger";
                                    break;
                                case "disiapkan":
                                    statusClass = "bg-warning";
                                    break;
                                case "dikirim":
                                    statusClass = "bg-info";
                                    break;
                                case "terkirim":
                                    statusClass = "bg-secondary";
                                    break;
                                case "selesai":
                                    statusClass = "bg-success";
                                    break;
                                default:
                                    statusClass = "";
                            }
                            return `
                                <td><span class="badge ${statusClass} me-1">` + data + `</span></td>
                            `;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, row, meta) {
                            return `
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-info" data-id="${row.id}" id="showCart">
                                    <i class="ti ti-eye"></i>
                                </button>
                            </td>
                            `;
                        }
                    }
                ]
            });

            $('#dataStatusPesanan').on('click', '#showCart', function() {
                var id = $(this).data('id');
                var rowData = table.row($(this).parents('tr')).data();

                var pesananId = $(this).data('pesanan-id');
                var modalTitle = $('#statusPesananModal').find('.modal-title');
                var modalBody = $('#statusPesananModal').find('#modal-body');

                modalTitle.text('Detail Pesanan ' + rowData.user.name);
                modalBody.empty();
                modalBody.append(`
                    <div class="row mb-3">
                        <div class="col-sm-3 mb-2">Nama</div>
                        <div class="col-sm-1">:</div>
                        <div class="col-sm-8">${rowData.user.name}</div>
                        <div class="col-sm-3 mb-2">Tanggal</div>
                        <div class="col-sm-1">:</div>
                        <div class="col-sm-8">${moment.utc(rowData.created_at).tz('Asia/Jakarta').format('D MMM YYYY')}</div>
                        <div class="col-sm-3 mb-2">Kode Pesan</div>
                        <div class="col-sm-1">:</div>
                        <div class="col-sm-8">${rowData.kode_pesanan}</div>
                    </div>
                    <div class="table-responsive border text-nowrap" style="border-radius: 10px;">
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 20px">No</th>
                                    <th>Nama Barang</th>
                                    <th>Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                `);

                rowData.barang.forEach(function(barang, index) {
                    modalBody.find('tbody').append(`
                        <tr class="text-center">
                            <td>${index + 1}</td>
                            <td>${barang.nama}</td>
                            <td>${barang.pivot.qty}</td>
                        </tr>
                    `);
                });

                modalBody.append(`
                            </tbody>
                        </table>
                    </div>
                `);

                $('#statusPesananModal').modal('show');
            });
        });
    </script>
@endsection
