@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-4 mb-4">
                <div class="card">
                    <div class="card-body d-flex justify-content-between">
                        <div class="me-2">
                            <span class="fw-semibold d-block mb-1">Profit</span>
                            <h3 class="card-title mb-2">$12,628</h3>
                        </div>
                        <div class="card-title d-flex align-items-center justify-content-center">
                            <div class="avatar flex-shrink-0">
                                <img src="../assets/img/icons/unicons/chart-success.png" alt="chart success"
                                    class="rounded" />
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
                                <img src="../assets/img/icons/unicons/chart-success.png" alt="chart success"
                                    class="rounded" />
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
                                <img src="../assets/img/icons/unicons/chart-success.png" alt="chart success"
                                    class="rounded" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-4">
            <h3 class="text-center text-primary">Pesanan Masuk <i class="bx bx-down-arrow-alt" style="font-size: 1em;"></i>
            </h3>
        </div>

        <div class="row">
            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card">
                    <div class="card-header pb-1">
                        <h6 class="text-center">Pesanan Line .....</h6>
                        <hr>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <label for="label">Nama/Label</label>
                            </div>
                            <div class="col-6">
                                <p id="label">: Pesanan 1</p>
                            </div>
                            <div class="col-6">
                                <label for="detail">Detail</label>
                            </div>
                            <div class="col-6">
                                <p id="detail">: <button type="button" class="btn btn-sm btn-primary" id="btnDetail"
                                        data-bs-toggle="modal" data-bs-target="#detailKonfirmasiModal">
                                        <i class="bx bx-show"></i>
                                    </button>
                                </p>
                            </div>
                            <hr>
                            <div class="col-12">
                                <button type="button" class="btn btn-warning w-100">
                                    Konfirmasi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card">
                    <div class="card-header pb-1">
                        <h6 class="text-center">Pesanan Line .....</h6>
                        <hr>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <label for="label">Nama/Label</label>
                            </div>
                            <div class="col-6">
                                <p id="label">: Pesanan 1</p>
                            </div>
                            <div class="col-6">
                                <label for="detail">Detail</label>
                            </div>
                            <div class="col-6">
                                <p id="detail">: <button type="button" class="btn btn-sm btn-primary" id="btnDetail"
                                    data-bs-toggle="modal" data-bs-target="#detailKonfirmasiModal">
                                        <i class="bx bx-show"></i>
                                    </button>
                                </p>
                            </div>
                            <hr>
                            <div class="col-12">
                                <button type="button" class="btn btn-warning w-100">
                                    Konfirmasi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailKonfirmasiModal" tabindex="-1" role="dialog"
        aria-labelledby="detailKonfirmasiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailKonfirmasiModalLabel">Detail Pesanan Line ...</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-xxl">
                        <div class="row mb-3">
                            <label class="col-sm-8 col-form-label" for="label">Nama/Label Pesanan</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control text-center" id="label" name="label" value="pesanan 1" disabled>
                            </div>
                        </div>
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
                                        name="barang-1" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-8 col-form-label" for="barang-2">Kertas</label>
                            <div class="col-sm-4">
                                <div class="input-group number-spinner">
                                    <input type="text" class="form-control text-center" value="2" id="barang-2"
                                        name="barang-2" disabled>
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
