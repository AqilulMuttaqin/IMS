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
                        <form method="POST" action="{{ route('spv.mutasi-barang') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="lokasiMutasi" class="form-label">LOKASI AWAL</label>
                                <select id="lokasiMutasi" name="lokasiMutasi" class="form-select" required>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="namaMutasi" class="form-label">Nama Barang</label>
                                <select id="namaMutasi" name="namaMutasi" class="form-select" required>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="kodejsMutasi" class="form-label">Kode JS</label>
                                <input type="text" class="form-control" id="kodejsMutasi" name="kodejsMutasi" placeholder="Input Kode JS ..." readonly required>
                            </div>
                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah di Lokasi</label>
                                <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Input Jumlah di Lokasi ..." readonly>
                            </div>
                            <div class="mb-3">
                                <label for="qtyMutasi" class="form-label">QTY Untuk Mutasi</label>
                                <input type="number" class="form-control" id="qtyMutasi" name="qtyMutasi" placeholder="Input Qty ..." oninput="validateInput(this)" required>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-8 offset-sm-4 text-danger" id="error-message" style="display:none;"></div>
                            </div>
                            <div class="mb-3">
                                <label for="remark" class="form-label">REMARKS</label>
                                <select id="remark" name="remark" class="form-select" onchange="toggleInput(this);" required>
                                    <option value="Mutasi">Mutasi</option>
                                    <option value="Adjust Stock">Adjust Stock</option>
                                    <option value="Adjust Stock STO">Adjust Stock STO</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div id="otherRemark" class="mb-3" style="display: none;">
                                <label for="otherRemarkInput" class="form-label">Other Remark</label>
                                <input type="text" id="otherRemarkInput" name="otherRemark" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="lokasiAkhir" class="form-label">LOKASI AKHIR</label>
                                <select id="lokasiAkhir" name="lokasiAkhir" class="form-select" required>
                                </select>
                            </div>
                            <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                    <!-- Content Menu 2 -->
                    <div class="tab-pane fade" id="menu-2" role="tabpanel">
                        <div class="d-flex justify-content-end text-end">
                            <button type="button" class="btn btn-sm btn-success d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#importModal">
                                <i class="ti ti-file-import me-1"></i>
                                Import Excel
                            </button>
                        </div>
                        <form method="POST" action="{{ route('spv.input-barang') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Barang</label>
                                <select id="nama" name="nama" class="form-select" required>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="kodejs" class="form-label">Kode JS</label>
                                <input type="text" class="form-control" id="kodejs" name="kodejs" placeholder="Input Kode JS ..." readonly required>
                            </div>
                            <div class="mb-3">
                                <label for="PO_number" class="form-label">PO Number</label>
                                <input type="text" class="form-control" id="PO_number" name="PO_number" placeholder="Input PO Number ..." required>
                            </div>
                            <div class="mb-3">
                                <label for="inv_number" class="form-label">Invoice Number</label>
                                <input type="text" class="form-control" id="inv_number" name="inv_number" placeholder="Input Invoice Number" required>
                            </div>
                            <div class="mb-3">
                                <label for="qty" class="form-label">QTY</label>
                                <input type="number" class="form-control" id="qty" name="qty" placeholder="Input Qty ..." required>
                            </div>
                            <div class="mb-3">
                                <label for="lokasi" class="form-label">LOKASI</label>
                                <select id="lokasi" name="lokasi" class="form-select" required>
                                </select>
                            </div>
                            <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="importForm" method="POST" action="{{ route('spv.import-barang') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="import">File Excel</label>
                            <input type="file" class="form-control form-control-user" id="file" name="file"
                                accept=".xlsx, .xls" required autofocus>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="submitBtn">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
    function toggleInput(select) {
        var otherRemarkInput = document.getElementById("otherRemarkInput");
        if (select.value === "Other") {
            otherRemarkInput.value = "";
            otherRemarkInput.parentNode.style.display = "block";
        } else {
            otherRemarkInput.value = "";
            otherRemarkInput.parentNode.style.display = "none";
        }
    };
    
    const validateInput = (input) => {
        input.value = input.value.replace(/[^0-9]/g, '');
        const id = input.id;
        const data = input.value;
        const maxQty = parseInt($('#jumlah').val());
        const currentQty = parseInt(data);
        if (currentQty > maxQty) {
            $('#error-message').text('Jumlah melebihi stok yang tersedia').show();
            $('#submit').prop('disabled', true);
        } else {
            $('#error-message').hide();
            $('#submit').prop('disabled', false);
        }
    };
    const select2Elements = [
        { id: 'lokasi', url: "{{ route('spv.get-lokasi') }}" },
        { id: 'lokasiMutasi', url: "{{ route('spv.get-lokasi') }}" },
        { id: 'lokasiAkhir', url: "{{ route('spv.get-lokasi') }}" }
    ];

    select2Elements.forEach(element => {
        $(`#${element.id}`).select2({
            theme: 'bootstrap-5',
            placeholder: ' Input Lokasi ...',
            minimumInputLength: 3,
            ajax: {
                url: element.url,
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.nama,
                                id: item.id || item.kode_js 
                            };
                        })
                    };
                },
                cache: true
            }
        }).addClass('form-select');
    });

    $('#namaMutasi').select2({
        theme: 'bootstrap-5',
        placeholder: ' Input Barang ...',
        minimumInputLength: 3,
        ajax: {
            url: "{{ route('spv.get-barang') }}",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    lokasi: $('#lokasiMutasi').val(),
                    q: params.term,
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.nama,
                            id: item.kode_js
                        }
                    })
                };
            },
            cache: true
        }
    }).addClass('form-select');

    $('#nama').select2({
        theme: 'bootstrap-5',
        placeholder: ' Input Barang ...',
        minimumInputLength: 3,
        ajax: {
            url: '{{ url()->current() }}',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.nama,
                            id: item.kode_js
                        }
                    })
                };
            },
            cache: true
        }
    }).addClass('form-select');

    $('#nama').change(function() {
        var kodejs = $(this).val();
        var kodeJsField = $('#kodejs');
        kodeJsField.val(kodejs);
        //kodeJsField.prop('disabled', false);
    });
    $('#namaMutasi').change(function() {
        var kodejs = $(this).val();
        var kodeJsField = $('#kodejsMutasi');
        kodeJsField.val(kodejs);

        $.ajax({
            url: "{{ route('spv.get-qty') }}",
            type: 'GET',
            data: {
                kode_js: kodejs,
                lokasi: $('#lokasiMutasi').val()
            },
            success: function(response) {
                $('#jumlah').val(response);
            }
        });
        //kodeJsField.prop('disabled', false);
    });
</script>
@endsection
