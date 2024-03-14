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
            <table class="table w-100" id="dataHistoryPesanan">
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
@endsection