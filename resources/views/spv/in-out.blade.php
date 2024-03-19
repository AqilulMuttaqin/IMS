@extends('layout.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-5">
                    <h5>Data In-Out Barang</h5>
                </div>
                <div class="col-sm-7">
                    <div class="d-flex justify-content-end text-end">
                        <button type="button" class="btn btn-sm btn-success d-flex align-items-center" id="exportBtn" onclick="submitExport()">
                            <i class="ti ti-file-export me-1"></i>
                            Export Excel
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row align-items-center mb-3">
                <div class="col-auto d-flex">
                    <div class="label">Filter Data Pesanan : </div>
                </div>
                <div class="col-auto d-flex align-items-center">
                    <label for="start_date" class="me-1">Start,</label>
                    <input type="date" class="form-control" id="start_date" name="start_date"
                        value="">
                </div>
                <div class="col-auto d-flex align-items-center">
                    <label for="end_date" class="me-1">End,</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="">
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-striped w-100" id="dataHistoriPesanan">
                    <thead>
                        <tr>
                            <th style="width: 20px">No</th>
                            <th>Tanggal</th>
                            <th>Barang</th>
                            <th>Remark</th>
                            <th>Lokasi Awal</th>
                            <th>Lokasi Akhir</th>
                            <th>Qty</th>
                            <th>Sebelum</th>
                            <th>Sesudah</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
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
            var table = $('#dataHistoriPesanan').DataTable({
                processing: false,
                serverSide: true,
                scrollX: true,
                ajax: {
                    url: '{{ url()->current() }}',
                    data: function(d) {
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                    }
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id'
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
                        data: 'data_barang.barang.nama',
                        name: 'data_barang.barang.nama'
                    },
                    {
                        data: 'remark',
                        name: 'remark'
                    },
                    {
                        data: 'lokasi_awal.nama',
                        name: 'lokasi_awal.nama'
                    },
                    {
                        data: 'lokasi_akhir.nama',
                        name: 'lokasi_akhir.nama'
                    },
                    {
                        data: 'qty',
                        name: 'qty'
                    },
                    {
                        data: 'qty_awal',
                        name: 'qty_awal'
                    },
                    {
                        data: 'qty_akhir',
                        name: 'qty_akhir'
                    },
                ],
            })
        });

        function submitExport(){
            const exportLink = "{{ route('spv.export-perubahan') }}";
            window.location.href = exportLink;
        }
    </script>
@endsection
