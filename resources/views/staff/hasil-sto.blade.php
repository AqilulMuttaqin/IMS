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
                        {{-- <!-- Dropdown Action Download Qr COde (zip,pdf) -->
                        <div class="dropdown text-end me-2">
                            <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                Download QR Code
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('download-zip') }}"><i
                                        class="ti ti-file-zip me-1"></i> Download ZIP</a>
                                <a class="dropdown-item" href="{{ route('download-pdf') }}" target="_blank"><i
                                        class="ti ti-file-text me-1"></i> Download PDF</a>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table w-100" id="dataBarang">
                    <thead>
                        <tr>
                            <th style="width: 20px">No</th>
                            <th>Tanggal STO</th>
                            <th>Kode JS</th>
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                            <th>Qty Real</th>
                            <th>Qty STO</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection