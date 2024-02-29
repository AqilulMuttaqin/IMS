@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <h5>Data Barang</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-striped" id="dataBarangGudang">
                        <thead>
                            <tr>
                                <th style="width: 20px">No</th>
                                {{-- <th>Kode JS</th> --}}
                                <th>Nama</th>
                                <th>Stok</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
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

            var table = $('#dataBarangGudang').DataTable({
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
                    // {
                    //     data: 'kode_js',
                    //     name: 'kode_js'
                    // },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'total_qty',
                        name: 'total_qty'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function() {
                            return `
                                <button type="button" class="btn btn-sm btn-primary">
                                    <i class="bx bx-edit-alt"></i>
                                </button>
                            `;
                        }
                    }
                ]
            });
        });
    </script>
@endsection
