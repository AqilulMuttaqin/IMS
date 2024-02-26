@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="row">
                <div class="col-sm-4">
                    <h5 class="card-header">Data Status Pesanan</h5>
                </div>
                {{-- <div class="col-sm-8">
                <div class="d-flex justify-content-end text-end pt-3 pe-3 mb-3">
                    <button type="button" class="btn btn-sm btn-warning d-flex align-items-center" id="showCart"
                        data-bs-toggle="modal" data-bs-target="#keranjangModal">
                        <i class="bx bxs-cart-alt me-1"></i>
                        Lihat Keranjang
                    </button>
                </div>
            </div> --}}
            </div>
            <div class="table-responsive text-nowrap pt-0 p-3">
                <table class="table table-striped" id="dataStatusPesanan">
                    <thead>
                        <tr>
                            <th style="width: 20px">No</th>
                            <th>Nama Pesanan</th>
                            <th class="text-center" style="width: 90px">Status</th>
                            <th class="text-center" style="width: 90px">Detail Pesanan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">1</td>
                            <td>Pesanan 1</td>
                            <td class="text-center">
                                <span class="badge bg-label-warning">
                                    Ngenteni Dikonfirm
                                </span>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-info" id="showCart" data-bs-toggle="modal"
                                    data-bs-target="#statusPesananModal">
                                    <i class="bx bx-show"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">2</td>
                            <td>Pesanan 2</td>
                            <td class="text-center">
                                <span class="badge bg-label-primary">
                                    Sek Proses
                                </span>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-info" id="showCart" data-bs-toggle="modal"
                                    data-bs-target="#statusPesananModal">
                                    <i class="bx bx-show"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="statusPesananModal" tabindex="-1" role="dialog" aria-labelledby="statusPesananModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusPesananModalLabel">Detail Pesanan Anda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-xxl">
                        <div class="row mb-3">
                            <label class="col-sm-8 col-form-label" for="Jumlah"></label>
                            <div class="col-sm-4">
                                <div class="text-muted text-center">Jumlah</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-8 col-form-label" for="barang-1">Bolpoin</label>
                            <div class="col-sm-4">
                                <div class="input-group number-spinner">
                                    <input type="text" class="form-control text-center" value="3" id="barang-1"
                                        name="barang-1" oninput="validateInput(this)">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-8 col-form-label" for="barang-2">Kertas</label>
                            <div class="col-sm-4">
                                <div class="input-group number-spinner">
                                    <input type="text" class="form-control text-center" value="2" id="barang-2"
                                        name="barang-2" oninput="validateInput(this)">
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="text-end">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
