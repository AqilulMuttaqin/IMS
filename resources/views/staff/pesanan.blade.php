@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h5 class="card-header">Data Pesanan</h5>
            <div class="table-responsive text-nowrap p-3 pt-0">
                <table class="table table-striped" id="dataPesanan">
                    <thead>
                        <tr>
                            <th style="width: 20px;">No</th>
                            <th>Nama Pemesan</th>
                            <th>Barang Pesanan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <tr>
                            <td class="text-center">1</td>
                            <td>Albert Cook</td>
                            <td>
                                <button class="btn btn-sm btn-primary d-flex align-items-center">
                                    <i class="bx bx-show-alt me-1"></i>
                                    Lihat Pesanan
                                </button>
                            </td>
                            <td><span class="badge bg-label-info me-1">Request</span></td>
                        </tr>
                        <tr>
                            <td class="text-center">2</td>
                            <td>Jhon Dee</td>
                            <td>
                                <button class="btn btn-sm btn-primary d-flex align-items-center">
                                    <i class="bx bx-show-alt me-1"></i>
                                    Lihat Pesanan
                                </button>
                            </td>
                            <td><span class="badge bg-label-warning me-1">Pending</span></td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    @endsection
    
    @push('scripts')
        <script>
            $(document).ready(function () {
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
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                        { data: 'user.name', name: 'user.name' },
                        { data: 'status', 
                            name: 'status', 
                            render: function (data, type, full, meta) {
                                return `
                                <td><span class="badge bg-label-warning me-1">`+ data + `</span></td>
                                `;
                            }
                        },
                    ]
                });
            });
        </script>
    @endpush