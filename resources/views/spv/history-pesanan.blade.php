@extends('layout.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-5">
                    <h5>Data History Pesanan</h5>
                </div>
                {{-- <div class="col-sm-7">
                <div class="d-flex justify-content-end text-end">
                    <button type="button" class="btn btn-sm btn-success d-flex align-items-center" id="exportBtn">
                        <i class="ti ti-file-export me-1"></i>
                        Export Excel
                    </button>
                </div>
            </div> --}}
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-striped w-100" id="dataHistoryPesanan">
                    <thead>
                        <tr>
                            <th style="width: 20px">No</th>
                            <th>Kode Pesan</th>
                            <th>Nama</th>
                            <th>Lokasi</th>
                            <th>Tanggal Pesan</th>
                            <th>Tanggal Selesai</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="historyPesananModal" tabindex="-1" role="dialog" aria-labelledby="historyPesananModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="historyPesananModalLabel">Detail Pesanan Anda</h5>
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
            var table = $('#dataHistoryPesanan').DataTable({
                processing: false,
                serverSide: true,
                scrollX: true,
                order: [
                    [3, 'desc']
                ],
                ajax: {
                    url: '{{ url()->current() }}',
                    type: 'GET'
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'kode_pesanan',
                        name: 'kode_pesanan'
                    },
                    {
                        data: 'user.name',
                        name: 'user.name'
                    },
                    {
                        data: null,
                        name: null
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
                        data: 'updated_at',
                        name: 'updated_at',
                        render: function(data, type, row, meta) {
                            if (row.status === 'selesai') {
                                var formattedDate = moment.utc(data).tz('Asia/Jakarta').format('D MMM YYYY');
                                return `<td class="text-center">` + formattedDate + `</td>`;
                            } else {
                                return `<td class="text-center">-</td>`;
                            }
                        }
                    },
                    {
                        data: 'detail',
                        name: 'detail',
                        render: function(data, type, row, meta) {
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

            $('#dataHistoryPesanan').on('click', '#showCart', function() {
                var id = $(this).data('id');
                console.log(id);
                var rowData = table.row($(this).parents('tr')).data();

                var pesananId = $(this).data('pesanan-id');
                var modalTitle = $('#historyPesananModal').find('.modal-title');
                var modalBody = $('#historyPesananModal').find('#modal-body');

                modalTitle.text('Detail Pesanan');
                modalBody.empty();
                modalBody.append(`
                    <div class="row mb-3">
                        <div class="col-sm-4 mb-2">Nama</div>
                        <div class="col-sm-1">:</div>
                        <div class="col-sm-7">${rowData.user.name}</div>
                        <div class="col-sm-4 mb-2">Lokasi</div>
                        <div class="col-sm-1">:</div>
                        <div class="col-sm-7">Ini Lokasi</div>
                        <div class="col-sm-4 mb-2">Tanggal Pesan</div>
                        <div class="col-sm-1">:</div>
                        <div class="col-sm-7">${moment.utc(rowData.created_at).tz('Asia/Jakarta').format('D MMM YYYY')}</div>
                        <div class="col-sm-4 mb-2">Tanggal Selesai</div>
                        <div class="col-sm-1">:</div>
                        <div class="col-sm-7">${moment.utc(rowData.updated_at).tz('Asia/Jakarta').format('D MMM YYYY')}</div>
                        <div class="col-sm-4 mb-2">Kode Pesan</div>
                        <div class="col-sm-1">:</div>
                        <div class="col-sm-7">${rowData.kode_pesanan}</div>
                    </div>
                    <div class="table-responsive border text-nowrap" style="border-radius: 10px;">
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 20px">No</th>
                                    <th>Nama Barang</th>
                                    <th>Keterangan</th>
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
                            <td>${barang.pivot.keterangan.charAt(0).toUpperCase() + barang.pivot.keterangan.slice(1)}</td>
                            <td>${barang.pivot.qty} ${barang.satuan}</td>
                        </tr>
                    `);
                });

                modalBody.append(`
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <p>* Note: ${rowData.catatan? rowData.catatan: "-"}</p>
                    </div>
                `);

                $('#historyPesananModal').modal('show');
            });
        });
    </script>
@endsection
