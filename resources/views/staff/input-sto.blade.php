@extends('layout.app')

@section('content')
    <div class="card">
        <div class="nav-align-top mb-4">
            <ul class="nav nav-pills nav-fill border" role="tablist" style="border-radius: 8px;">
                <!-- Menu 1 - Scan Barang STO -->
                <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#menu-1"
                        aria-controls="menu-1" aria-selected="true">
                        <i class="ti ti-scan me-1"></i> Scan Barang STO
                    </button>
                </li>
                <!-- Menu 2 - Form Barang STO -->
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#menu-2"
                        aria-controls="menu-2" aria-selected="false">
                        <i class="ti ti-file me-1"></i> Form Barang STO
                    </button>
                </li>
            </ul>
            <div class="card-body">
                <div class="tab-content">
                    <!-- Content Menu 1 -->
                    <div class="tab-pane fade show active text-center" id="menu-1" role="tabpanel">
                        <div class="gif mb-3">
                            <h2 style="position: absolute; left: 50%; transform: translateX(-50%); margin-top: 12px;">Scan
                                Kode Disini!
                            </h2>
                            <input type="text" class="form-control form-control-user" id="scannerInputSTO"
                                name="scannerInput" required autofocus style="color: transparent; height: 60px;">
                            <img src="{{ asset('images/scan.gif') }}" alt="GIF Image" style="width: 75%">
                        </div>
                    </div>
                    <!-- Content Menu 2 -->
                    <div class="tab-pane fade" id="menu-2" role="tabpanel">
                        <form method="POST" action="">
                            @csrf
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Barang</label>
                                <select id="nama" name="nama" class="form-select" required>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="kodejs" class="form-label">Kode JS</label>
                                <input type="text" class="form-control" id="kodejs" name="kodejs"
                                    placeholder="Input Kode JS" readonly required>
                            </div>
                            <div class="mb-3">
                                <label for="qty" class="form-label">QTY</label>
                                <input type="number" class="form-control" id="qty" name="qty"
                                    placeholder="Input Qty ..." required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="scannerInputSTOModal" tabindex="-1" role="dialog"
        aria-labelledby="scannerInputSTOModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scannerInputSTOModalLabel">Update Stok</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-xxl" id="modal-body">
                        <form method="POST" action="">
                        @csrf
                            <div class="mb-3">
                                <label for="namaBarang" class="form-label">Nama Barang</label>
                                <input type="text" class="form-control" name="namaBarang" id="namaBarang" readonly required>
                            </div>
                            <div class="mb-3">
                                <label for="kodejs" class="form-label">Kode JS</label>
                                <input type="text" class="form-control" id="kodejs" name="kodejs" readonly required>
                            </div>
                            <div class="mb-3">
                                <label for="qty" class="form-label">QTY</label>
                                <input type="number" class="form-control" id="qty" name="qty" required>
                            </div>
                        </div>
                    </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('keypress', function(event) {
            if (event.keyCode === 13) {
                // var scannedData = event.target.value.trim();
                // document.getElementById('scannerInput').value = scannedData;
                var scannedData = document.getElementById('scannerInputSTO').value;
                $.ajax({
                    url : "{{ route('staff.nama-barang')}}",
                    type: 'GET',
                    data: {
                        kode_js: scannedData,
                    },
                    success: function(response){
                        if (response.status) {
                            //$('#scannerInputModal').find('#nama').text(response.nama);
                            $('#scannerInputSTOModal').find('#namaBarang').val(response.barang.nama);
                            $('#scannerInputSTOModal').find('#kodejs').val(response.barang.kode_js);
                            
                            $('#scannerInputSTOModal').modal('show');
                        } else{
                            Swal.fire({
                                title: "Gagal!",
                                text: "Data tidak ditemukan, Coba Scan Ulang!",
                                icon: "error",
                                timer: 3500
                            });
                        }
                    }
                })
                $('#scannerInputSTO').val('');
            }
        });

        $('#nama').select2({
            theme: 'bootstrap-5',
            placeholder: ' Input Nama Barang ...',
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
        $('#nama').on('select2:open', function(e) {
            $('.select2-search__field').focus();
        });

        $('#nama').change(function() {
            var kodejs = $(this).val();
            var kodeJsField = $('#kodejs');
            kodeJsField.val(kodejs);
            //kodeJsField.prop('disabled', false);
        });
    </script>
@endsection
