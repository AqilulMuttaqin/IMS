@extends('layout.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-4">
                    <h5>Data Barang Hasil STO</h5>
                </div>
                <div class="col-sm-8">
                    <div class="d-flex justify-content-end text-end">
                        <button type="button" class="btn btn-sm btn-success" onclick="submitExport()">
                            Export Excel
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row align-items-center mb-3">
                <div class="col-auto d-flex align-items-center text-nowrap">
                    <div class="label me-3">Filter Hasil STO : </div>
                    <input type="month" class="form-control" id="start_date" name="start_date"
                        value="{{ $bulan }}">
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table w-100" id="dataBarang">
                    <thead>
                        <tr>
                            <th style="width: 20px">No</th>
                            <th>Tanggal STO</th>
                            <th>Kode JS</th>
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                            <th>Qty</th>
                            <th>Actual Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

{{-- <script>
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
                    type: 'GET',
                    data: function(d) {
                        d.date = $('#start_date').val();
                    }
                },
                columns: [{
                        data: 'null',
                        name: 'null',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
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
                        data: 'kode_js',
                        name: 'kode_js',
                    },
                    {
                        data: 'barang.nama',
                        name: 'barang.nama',
                    },
                    {
                        data: 'barang.satuan',
                        name: 'barang.satuan',
                    },
                    {
                        data: 'qty',
                        name: 'qty',
                    },
                    {
                        data: 'actual_qty',
                        name: 'actual_qty',
                    }
                ]
            });

            $('#start_date').change(function() {
                table.draw();
            });
        });
        function submitExport() {
            const startDate = document.getElementById('start_date').value;
            const exportLink = `{{ route('staff.export-sto-gudang') }}?start_date=${startDate}`;
            window.location.href = exportLink;
        }
</script> --}}
@endsection