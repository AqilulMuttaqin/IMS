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
                                <input type="text" class="form-control" id="kodejsMutasi" name="kodejsMutasi" readonly required>
                            </div>
                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah di Lokasi</label>
                                <input type="number" class="form-control" id="jumlah" name="jumlah" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="qtyMutasi" class="form-label">QTY Untuk Mutasi</label>
                                <input type="number" class="form-control" id="qtyMutasi" name="qtyMutasi" placeholder="Input Qty ..." oninput="validateInput(this)" required>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-8 offset-sm-4 text-danger" id="error-message" style="display:none;"></div>
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
                        <form method="POST" action="{{ route('spv.input-barang') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Barang</label>
                                <select id="nama" name="nama" class="form-select" required>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="kodejs" class="form-label">Kode JS</label>
                                <input type="text" class="form-control" id="kodejs" name="kodejs" readonly required>
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

<script>
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
    $(document).ready(function () {
        $('.nav-link').on('show.bs.tab', function (event) {
            var target = $(event.target).attr('data-bs-target');
            $(target).find('.select2').select2();
        });
    });
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
            url: "{{ route('spv.get-barang') }}",
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
