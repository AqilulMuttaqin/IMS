@extends('layout.app')

@section('content')
    <!-- Container Content Data Pesanan -->
    <div class="card">
        <div class="card-header">
            <h5>Data Pesanan</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-striped" id="dataPesanan">
                    <thead>
                        <tr>
                            <th style="width: 20px;">No</th>
                            <th>Nama Pemesan</th>
                            <th>Barang Pesanan</th>
                            <th>Qty</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTable Data Pesanan -->
                    </tbody>
                </table>
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
            var table = $('#dataPesanan').DataTable({
                processing: true,
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
                        data: 'user.name',
                        name: 'user.name'
                    },
                    {
                        data: function(row) {
                            return row.barang.map(function(item) {
                                return item.nama;
                            }).join('<br>');
                        },
                        name: 'barang.nama'
                    },
                    {
                        data: function(row) {
                            return row.barang.map(function(item) {
                                return item.pivot.qty;
                            }).join('<br>');
                        },
                        name: 'barang.pivot.qty'
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
                                case "ditolak":
                                    statusClass = "bg-danger";
                                    break;
                                default:
                                    statusClass = "";
                            }
                            return `
                                <td><span class="badge ${statusClass} me-1">` + data + `</span></td>
                            `;
                        }
                    },
                ]
            });
        });
    </script>
@endsection
