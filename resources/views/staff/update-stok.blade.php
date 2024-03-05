@extends('layout.app')

@section('content')
    <style>
        .nav-pills .nav-link {
            color: black;
        }

        .nav-pills .nav-link.active {
            color: white;
        }
    </style>
    <!-- Container Content Update Stok -->
    <div class="card">
        <div class="nav-align-top mb-4">
            <ul class="nav nav-pills nav-fill border" role="tablist" style="border-radius: 8px;">
                <!-- Menu 1 - Scan To Update -->
                <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#menu-1"
                        aria-controls="menu-1" aria-selected="true">
                        <i class="ti ti-scan me-1"></i> Scan To Update
                    </button>
                </li>
                <!-- Menu 2 - Form To Update -->
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#menu-2"
                        aria-controls="menu-2" aria-selected="false">
                        <i class="ti ti-file me-1"></i> Form To Update
                    </button>
                </li>
            </ul>
            <div class="card-body">
                <div class="tab-content">
                    <!-- Content Menu 1 -->
                    <div class="tab-pane row fade show active text-center" id="menu-1" role="tabpanel">
                        <div class="gif mb-3">
                            <h2 style="position: absolute; left: 50%; transform: translateX(-50%); margin-top: 12px;">Scan Kode Disini!
                            </h2>
                            <input type="text" class="form-control form-control-user" id="scannerInput" name="scannerInput" required autofocus style="color: transparent; height: 60px;">
                            <img src="{{ asset('images/scan.gif') }}" alt="GIF Image" style="width: 75%">
                        </div>
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

    <div class="modal fade" id="scannerInputModal" tabindex="-1" role="dialog"
        aria-labelledby="scannerInputModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scannerInputModalLabel">Update Stok</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-xxl" id="modal-body">
                        <<form>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Barang</label>
                                <select id="nama" name="nama" class="form-select" disabled required>
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
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('keypress', function(event) {
            if (event.keyCode === 13) {
                // var scannedData = event.target.value.trim();
                // document.getElementById('scannerInput').value = scannedData;
                var scannedData = document.getElementById('scannerInput').value;
                console.log(scannedData);
                $('#scannerInput').val('');
            }
        });
    </script>
@endsection
