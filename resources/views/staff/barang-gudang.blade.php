@extends('layout.app')

@section('content')
    <!-- Container Content Data Barang Gudang -->
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    <h5>Data Barang</h5>
                </div>
                <div class="col-sm-6">
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
                <table class="table table-striped w-100" id="dataBarangGudang">
                    <thead>
                        <tr>
                            <th style="width: 20px;">No</th>
                            <th>Nama</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTable Data Barang Gudang -->
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

            var table = $('#dataBarangGudang').DataTable({
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
                        data: 'nama',
                        name: 'nama',
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `${row.total_qty} ${row.satuan}`;
                        }
                    },
                    // {
                    //     data: 'action',
                    //     name: 'action',
                    //     orderable: false,
                    //     searchable: false,
                    //     render: function() {
                    //         return `
                    //             <button type="button" class="btn btn-sm btn-primary">
                    //                 <i class="ti ti-edit"></i>
                    //             </button>
                    //         `;
                    //     }
                    // }
                ]
            });
        });
    </script>
@endsection
