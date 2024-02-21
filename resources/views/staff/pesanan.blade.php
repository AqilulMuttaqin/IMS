@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h5 class="card-header">Pesanan</h5>
            <div class="table-responsive text-nowrap px-2">
                <table class="table table-striped">
                    <caption class="ms-4">
                        List of Projects
                    </caption>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pemesan</th>
                            <th>Barang Pesanan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Albert Cook</td>
                            <td><a href="">Lihat Daftar</a></td>
                            <td><span class="badge bg-label-warning me-1">Pending</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
