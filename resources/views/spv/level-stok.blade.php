@extends('layout.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Data Stok Barang</h5>
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
                            <th>Qty Gudang</th>
                            <th>Qty All</th>
                        </tr>
                    </thead>
                    <tbody>
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
                    <p>Stok Gudang Kurang Dari Batas Minimum</p>
                    <span class="badge border border-dark rounded-pill me-2 ms-4" style="height: 20px; margin-top: 2px; background-color: #cffffd"> </span>
                    <p>Stok Gudang Lebih Dari Batas Maximum</p>
                </div>
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
                        data: 'total_qty_gudang',
                        name: 'total_qty_gudang'
                    },
                    {
                        data: 'total_qty',
                        name: 'total_qty'
                    },
                ],
                createdRow: function(row, data, dataIndex) {
                    if (data.total_qty_gudang <= data.min_stok) {
                        $(row).attr('style', 'background-color: #ffb0b0');
                    } else if (data.total_qty_gudang >= data.max_stok) {
                        $(row).attr('style', 'background-color: #cffffd');
                    }
                }
            });
        });
    </script>
@endsection
