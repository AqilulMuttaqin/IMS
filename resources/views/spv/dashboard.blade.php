@extends('layout.app')

@section('content')
    {{-- <div class="row">
        <div class="col-4 mb-4">
            <div class="card">
                <div class="card-body d-flex justify-content-between">
                    <div class="me-2">
                        <span class="fw-semibold d-block mb-1">Profit</span>
                        <h3 class="card-title mb-2">$12,628</h3>
                    </div>
                    <div class="card-title d-flex align-items-center justify-content-center">
                        <div class="avatar flex-shrink-0">
                            <img src="../assets/img/icons/unicons/chart-success.png" alt="chart success" class="rounded" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4 mb-4">
            <div class="card">
                <div class="card-body d-flex justify-content-between">
                    <div class="me-2">
                        <span class="fw-semibold d-block mb-1">Profit</span>
                        <h3 class="card-title mb-2">$12,628</h3>
                    </div>
                    <div class="card-title d-flex align-items-center justify-content-center">
                        <div class="avatar flex-shrink-0">
                            <img src="../assets/img/icons/unicons/chart-success.png" alt="chart success" class="rounded" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4 mb-4">
            <div class="card">
                <div class="card-body d-flex justify-content-between">
                    <div class="me-2">
                        <span class="fw-semibold d-block mb-1">Profit</span>
                        <h3 class="card-title mb-2">$12,628</h3>
                    </div>
                    <div class="card-title d-flex align-items-center justify-content-center">
                        <div class="avatar flex-shrink-0">
                            <img src="../assets/img/icons/unicons/chart-success.png" alt="chart success" class="rounded" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="card w-100">
        <div class="card-body">
            <div class="mb-3 mb-sm-0">
                <h5 class="card-title fw-semibold">Sales Overview</h5>
            </div>
            <div id="chart" style="height: 40px"></div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-5">
                    <h5>Detail History Barang</h5>
                </div>
                <div class="col-sm-7">
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
                <table class="table w-100" id="dataDetailBarang">
                    <thead>
                        <tr>
                            <th style="width: 20px">No</th>
                            <th>Kode JS</th>
                            <th>Nama</th>
                            <th>In</th>
                            <th>Out</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
