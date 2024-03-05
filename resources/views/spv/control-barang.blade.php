@extends('layout.app')

@section('content')
    <!-- Container Content Update Stok -->
    <div class="card">
        <div class="nav-align-top mb-4">
            <ul class="nav nav-pills nav-fill border" role="tablist" style="border-radius: 8px;">
                <!-- Menu 1 - Form Barang Keluar -->
                <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#menu-1"
                        aria-controls="menu-1" aria-selected="true">
                        <i class="ti ti-logout me-1"></i> Form Barang Keluar
                    </button>
                </li>
                <!-- Menu 2 - Form Barang Masuk -->
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#menu-2"
                        aria-controls="menu-2" aria-selected="false">
                        <i class="ti ti-login me-1"></i> Form Barang Masuk
                    </button>
                </li>
            </ul>
            <div class="card-body">
                <div class="tab-content">
                    <!-- Content Menu 1 -->
                    <div class="tab-pane fade show active" id="menu-1" role="tabpanel">
                        <form>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Barang</label>
                                <select id="nama" name="nama" class="form-select" required>
                                    <option></option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="kodejs" class="form-label">Kode JS</label>
                                <input type="text" class="form-control" id="kodejs" name="kodejs" disabled required>
                            </div>
                            <div class="mb-3">
                                <label for="po-num" class="form-label">PO Number</label>
                                <input type="text" class="form-control" id="po-num" name="po-num" required>
                            </div>
                            <div class="mb-3">
                                <label for="inc-num" class="form-label">Invoice Number</label>
                                <input type="text" class="form-control" id="inv-num" name="inv-num" required>
                            </div>
                            <div class="mb-3">
                                <label for="qty" class="form-label">QTY</label>
                                <input type="number" class="form-control" id="qty" name="qty" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                    <!-- Content Menu 2 -->
                    <div class="tab-pane fade" id="menu-2" role="tabpanel">
                        <form>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Barang</label>
                                <select id="nama" name="nama" class="form-select" required>
                                    <option></option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="kodejs" class="form-label">Kode JS</label>
                                <input type="text" class="form-control" id="kodejs" name="kodejs" disabled required>
                            </div>
                            <div class="mb-3">
                                <label for="po-num" class="form-label">PO Number</label>
                                <input type="text" class="form-control" id="po-num" name="po-num" required>
                            </div>
                            <div class="mb-3">
                                <label for="inc-num" class="form-label">Invoice Number</label>
                                <input type="text" class="form-control" id="inv-num" name="inv-num" required>
                            </div>
                            <div class="mb-3">
                                <label for="qty" class="form-label">QTY</label>
                                <input type="number" class="form-control" id="qty" name="qty" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
