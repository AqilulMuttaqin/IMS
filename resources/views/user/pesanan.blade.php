@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="row">
                <div class="col-sm-4">
                    <h5 class="card-header">Data Status Pesanan</h5>
                </div>
                {{-- <div class="col-sm-8">
                <div class="d-flex justify-content-end text-end pt-3 pe-3 mb-3">
                    <button type="button" class="btn btn-sm btn-warning d-flex align-items-center" id="showCart"
                        data-bs-toggle="modal" data-bs-target="#keranjangModal">
                        <i class="bx bxs-cart-alt me-1"></i>
                        Lihat Keranjang
                    </button>
                </div>
            </div> --}}
            </div>
            <div class="table-responsive text-nowrap pt-0 p-3">
                <table class="table table-striped" id="dataStatusPesanan">
                    <thead>
                        <tr>
                            <th style="width: 20px">No</th>
                            <th>Nama Pesanan</th>
                            <th>Tanggal Dibuat</th>
                            <th>Tanggal Selesai</th>
                            <th class="text-center" style="width: 90px">Status</th>
                            <th class="text-center" style="width: 90px">Detail Pesanan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">1</td>
                            <td>Pesanan 1</td>
                            <td class="text-center">
                                <span class="badge bg-label-warning">
                                    Ngenteni Dikonfirm
                                </span>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-info" id="showCart" data-bs-toggle="modal"
                                    data-bs-target="#statusPesananModal">
                                    <i class="bx bx-show"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">2</td>
                            <td>Pesanan 2</td>
                            <td class="text-center">
                                <span class="badge bg-label-primary">
                                    Sek Proses
                                </span>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-info" id="showCart" data-bs-toggle="modal"
                                    data-bs-target="#statusPesananModal">
                                    <i class="bx bx-show"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="statusPesananModal" tabindex="-1" role="dialog" aria-labelledby="statusPesananModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
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
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
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
                processing: true,
                serverSide: true,
                order: [[2, 'desc']],
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
                        data: 'user.name',
                        name: 'user.name'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, row, meta){
                            var formattedDate = moment.utc(data).tz('Asia/Jakarta').format('D MMM YYYY');
                            return `
                                <td class="text-center">`+formattedDate+`</td>
                            `;
                        }
                    },
                    {
                        data: 'edited_at',
                        name: 'null',
                        render: function(data, row, meta){
                            if(row.status !== 'selesai'){
                                return `
                                    <td class="text-center">-</td>
                                `;
                            }else{
                                var formattedDate = moment.utc(data).tz('Asia/Jakarta').format('D MMM YYYY');
                                return `
                                    <td class="text-center">`+formattedDate+`</td>
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
                                    statusClass = "bg-label-danger";
                                    break;
                                case "disiapkan":
                                    statusClass = "bg-label-warning";
                                    break;
                                case "dikirim":
                                    statusClass = "bg-label-info";
                                    break;
                                case "terkirim":
                                    statusClass = "bg-label-primary";
                                    break;
                                case "selesai":
                                    statusClass = "bg-label-info";
                                    break;
                                default:
                                    statusClass = "";
                            }
                            return `
                                <td><span class="badge ${statusClass} me-1">`+ data + `</span></td>
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
                                    <i class="bx bx-show"></i>
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
                            <label class="col-sm-8 col-form-label" for="Jumlah"></label>
                            <div class="col-sm-4">
                                <div class="text-muted text-center id="Jumlah"">Jumlah</div>
                            </div>
                        </div>
                        `);
                
                rowData.barang.forEach(function(barang, index) {
                    modalBody.append(`
                        <div class="row mb-3">
                            <label class="col-sm-8 col-form-label" for="barang-${index}">${barang.nama}</label>
                            <div class="col-sm-4">
                                <div class="input-group number-spinner">
                                    <input type="text" class="form-control text-center" value="${barang.pivot.qty}" id="barang-${index}"
                                        name="barang-${index}" oninput="validateInput(this)" disabled>
                                </div>
                            </div>
                        </div>
                    `);
                });

                modalBody.append(`
                        <div class="row justify-content-end">
                            <div class="text-end">
                            </div>
                        </div>
                        `);

                $('#statusPesananModal').modal('show');
            });
        });
    </script>
@endsection
