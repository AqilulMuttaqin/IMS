@extends('layout.app')

@section('content')
    <!-- Container Content Dashboard User -->
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-4">
                    <h5>Data Barang Ready</h5>
                </div>
                <!-- Button Keranjang Pesanan -->
                <div class="col-sm-8">
                    <div class="d-flex justify-content-end text-end">
                        <button type="button" class="btn btn-sm btn-warning d-flex align-items-center" id="showCart">
                            <i class="ti ti-shopping-cart me-1"></i>
                            Lihat Keranjang
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Tabel Barang Ready -->
            <div class="table-responsive text-nowrap">
                <table class="table table-striped w-100" id="dataBarangReady">
                    <thead>
                        <tr>
                            <th style="width: 20px">No</th>
                            <th>Nama</th>
                            <th>Satuan</th>
                            <th>Stok</th>
                            <th style="width: 90px;">Check Out</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTable Data Barang Ready -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal - Isi Keranjang -->
    <div class="modal fade" id="keranjangModal" tabindex="-1" role="dialog" aria-labelledby="keranjangModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="keranjangModalLabel">Keranjang Anda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="keranjangForm">
                        <div class="col-xxl" id="isiKeranjang"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="pesanButton">
                        <span class="spinner-border spinner-border-sm" aria-hidden="true" hidden></span>
                        Pesan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal - Tambah Ke-Keranjang / Request Langsung -->
    <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Nama Barangnya</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="keranjangForm">
                        <div class="col-xxl">
                            <div class="row mb-2">
                                <div class="col-sm-8"></div>
                                <div class="col-sm-4 text-center">
                                    <p class="satuan"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="col-sm-8 col-form-label" for="ket">Keterangan</label>
                                </div>
                                <div class="col-sm-5">
                                    <input type="checkbox" unchecked id="ket" data-toggle="toggle" data-on="Tukar" data-off="Request" data-offstyle="success" data-style="slow" data-barang="jumlah" onchange="handleCheckboxChange(this)">
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group number-spinner">
                                        <button type="button" class="btn btn-sm border" onclick="minValue('jumlah')">
                                            <i class="ti ti-minus"></i>
                                        </button>
                                        <input type="text" class="form-control text-center" value="1"
                                            id="barang" name="barang" hidden>
                                        <input type="text" class="form-control text-center" value="1"
                                            id="jumlah" name="jumlah" oninput="validateInput(this)">
                                        <button type="button" class="btn btn-sm border" onclick="plusValue('jumlah')">
                                            <i class="ti ti-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-8 offset-sm-4 text-danger" id="error-message" style="display:none;"></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" id="tambahkan">Tambahkan</button>
                    <button type="button" class="btn btn-primary" id="sbmtPesanLangsung" hidden>Pesan</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        const plusValue = (id) => {
            const inputElement = document.getElementById(id);
            inputElement.value = parseInt(inputElement.value) + 1;
            const maxQty = parseInt($('#' + id).data('max'));
            const maxQtyLoc = parseInt($('#' + id).data('max-loc'));
            const currentQty = parseInt(inputElement.value);
            var keterangan = $('#tambahModal').find('#ket').prop('checked') ? 'tukar' : 'request';
            var keterangan2 = $('#keterangan_'+ id).prop('checked') ? 'tukar' : 'request';
            if (currentQty > maxQtyLoc && keterangan === 'tukar' || currentQty > maxQtyLoc && keterangan2 === 'tukar') {
                $('#error-message').text('Jumlah Di lokasi tidak cukup untuk tukar, kurangi atau ubah ke request!').show();
                $('#error-message-' + id).text('Jumlah Di lokasi tidak cukup!').show();
                $('#tambahkan').prop('disabled', true);
                $('#sbmtPesanLangsung').prop('disabled', true);
                $('#pesanButton').prop('disabled', true);
            } else if (currentQty > maxQty) {
                $('#error-message').text('Jumlah melebihi stok yang tersedia').show();  
                $('#error-message-' + id).text('Jumlah melebihi stok yang tersedia').show();  
                $('#tambahkan').prop('disabled', true);
                $('#sbmtPesanLangsung').prop('disabled', true);
                $('#pesanButton').prop('disabled', true);
            } else {
                $('#error-message').hide();
                $('#error-message-' + id).hide();
                $('#tambahkan').prop('disabled', false);
                $('#sbmtPesanLangsung').prop('disabled', false);
                $('#pesanButton').prop('disabled', false);
                if (id !== 'jumlah') {
                    debounceAjaxRequest('update' ,id, inputElement.value);
                }
            }
        }

        const minValue = (id) => {
            const inputElement = document.getElementById(id);
            const newValue = parseInt(inputElement.value) - 1;
            inputElement.value = newValue >= 0 ? newValue : 0;
            const maxQty = parseInt($('#' + id).data('max'));
            const maxQtyLoc = parseInt($('#' + id).data('max-loc'));
            const currentQty = parseInt(newValue);
            var keterangan = $('#tambahModal').find('#ket').prop('checked') ? 'tukar' : 'request';
            var keterangan2 = $('#keterangan_'+ id).prop('checked') ? 'tukar' : 'request';

            if (currentQty > maxQtyLoc && keterangan === 'tukar' || currentQty > maxQtyLoc && keterangan2 === 'tukar') {
                $('#error-message').text('Jumlah Di lokasi tidak cukup untuk tukar, kurangi atau ubah ke request!').show();
                $('#error-message-' + id).text('Jumlah Di lokasi tidak cukup!').show();
                $('#tambahkan').prop('disabled', true);
                $('#pesanButton').prop('disabled', true);
                $('#sbmtPesanLangsung').prop('disabled', true);
            } else if (currentQty > maxQty) {
                $('#error-message').text('Jumlah melebihi stok yang tersedia').show();
                $('#error-message-' + id).text('Jumlah melebihi stok yang tersedia').show();  
                $('#tambahkan').prop('disabled', true);
                $('#sbmtPesanLangsung').prop('disabled', true);
                $('#pesanButton').prop('disabled', true);
            } else {
                $('#error-message').hide();
                $('#error-message-' + id).hide();
                $('#tambahkan').prop('disabled', false);
                $('#sbmtPesanLangsung').prop('disabled', false);
                $('#pesanButton').prop('disabled', false);
                if (id !== 'jumlah') {
                    debounceAjaxRequest( 'update',id, inputElement.value);
                }
            }
        }

        const validateInput = (input) => {
            input.value = input.value.replace(/[^0-9]/g, '');
            const id = input.id;
            const data = input.value;
            const maxQty = parseInt($('#'+ id).data('max'));
            const maxQtyLoc = parseInt($('#'+ id).data('max-loc'));
            const currentQty = parseInt(data);


            var keterangan = $('#tambahModal').find('#ket').prop('checked') ? 'tukar' : 'request';
            var keterangan2 = $('#keterangan_'+ id).prop('checked') ? 'tukar' : 'request';

            if (currentQty > maxQtyLoc && keterangan === 'tukar' || currentQty > maxQtyLoc && keterangan2 === 'tukar') {
                $('#error-message').text('Jumlah Di lokasi tidak cukup untuk tukar, kurangi atau ubah ke request!').show();
                $('#error-message-' + id).text('Jumlah Di lokasi tidak cukup!').show();
                $('#tambahkan').prop('disabled', true);
                $('#sbmtPesanLangsung').prop('disabled', true);
                $('#pesanButton').prop('disabled', true);
            } else if (currentQty > maxQty) {
                $('#error-message').text('Jumlah melebihi stok yang tersedia').show();
                
                $('#error-message-' + id).text('Jumlah melebihi stok yang tersedia').show();  
                $('#tambahkan').prop('disabled', true);
                $('#sbmtPesanLangsung').prop('disabled', true);
                $('#pesanButton').prop('disabled', true);
            } else {
                $('#error-message').hide();
                $('#error-message-' + id).hide();
                $('#tambahkan').prop('disabled', false);
                $('#sbmtPesanLangsung').prop('disabled', false);
                $('#pesanButton').prop('disabled', false);
                if (id !== 'jumlah') {
                    debounceAjaxRequest('update',id, data);
                }
            }
        }

        function handleCheckboxChange(checkbox) {
            const barangId = checkbox.dataset.barang;
            var isChecked = checkbox.checked;
            isChecked ? (isChecked = 'tukar') : (isChecked = 'request');

            const inputElement = document.getElementById(barangId);
            const maxQty = parseInt($('#' + barangId).data('max'));
            const maxQtyLoc = parseInt($('#' + barangId).data('max-loc'));
            const currentQty = parseInt(inputElement.value);
            var keterangan = $('#tambahModal').find('#ket').prop('checked') ? 'tukar' : 'request';
            var keterangan2 = $('#keterangan_'+ barangId).prop('checked') ? 'tukar' : 'request';

            if (currentQty > maxQtyLoc && keterangan === 'tukar' || currentQty > maxQtyLoc && keterangan2 === 'tukar') {
                $('#error-message').text('Jumlah Di lokasi tidak cukup untuk tukar, kurangi atau ubah ke request!').show();
                $('#error-message-' + barangId).text('Jumlah Di lokasi tidak cukup!').show();
                $('#tambahkan').prop('disabled', true);
                $('#sbmtPesanLangsung').prop('disabled', true);
                $('#pesanButton').prop('disabled', true);
            } else if (currentQty > maxQty) {
                $('#error-message').text('Jumlah melebihi stok yang tersedia').show();
                
                $('#error-message-' + barangId).text('Jumlah melebihi stok yang tersedia').show();  
                $('#tambahkan').prop('disabled', true);
                $('#sbmtPesanLangsung').prop('disabled', true);
                $('#pesanButton').prop('disabled', true);
            } else {
                $('#error-message').hide();
                $('#error-message-' + barangId).hide();
                $('#tambahkan').prop('disabled', false);
                $('#sbmtPesanLangsung').prop('disabled', false);
                $('#pesanButton').prop('disabled', false);
                if (barangId !== 'jumlah') {
                    debounceAjaxRequest('update-keterangan', barangId,null ,isChecked);
                }
            }
        }

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#dataBarangReady').DataTable({
                processing: false,
                serverSide: true,
                scrollX: true,
                ajax: {
                    url: '{{ url()->current() }}',
                    type: 'GET'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'satuan',
                        name: 'satuan'
                    },
                    {
                        data: 'total_qty',
                        name: 'total_qty'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, meta, row) {
                            return `
                                <button type="button" class="btn btn-sm btn-warning" data-id="${row.kode_js}" id="tambahBarang">
                                    + Keranjang
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" data-id="${row.kode_js}" id="pesanLangsung">
                                    Request Langsung
                                </button>
                            `;
                        }
                    }
                ]
            });

            $('#showCart').on('click', function() {
                keranjang('keranjang');
            });
            // $('#deleteBarang').on('click', function() {
            //     var id = $(this).data('id');
            //     console.log('clicked');
            //     keranjang('delete', id);
            // });
            $('#tambahkan').on('click', function() {
                var barang = $('#tambahModal').find('#barang').val();
                var jumlah = $('#tambahModal').find('#jumlah').val();
                var keterangan = $('#tambahModal').find('#ket').prop('checked') ? 'tukar' : 'request';
                keranjang('add', barang, jumlah, keterangan);
            });

            $('#sbmtPesanLangsung').on('click', function() {
                var barang = $('#tambahModal').find('#barang').val();
                var jumlah = $('#tambahModal').find('#jumlah').val();
                var keterangan = $('#tambahModal').find('#ket').prop('checked') ? 'tukar' : 'request';
                pesan(barang, jumlah, keterangan);
                table.draw();
            });

            $('#dataBarangReady').on('click', '#tambahBarang', function() {
                var id = $(this).data('id');
                var rowData = table.row($(this).parents('tr')).data();

                $('#tambahModal').find('.modal-title').text(rowData.nama);
                $('#tambahModal').find('#barang').val(rowData.kode_js);
                $('#tambahModal').find('#jumlah').val('0');
                $('#tambahModal').find('#sbmtPesanLangsung').prop('hidden', true);
                $('#tambahModal').find('#tambahkan').prop('hidden', false);
                $('#tambahModal').find('#jumlah').data('max', rowData.total_qty);
                $('#tambahModal').find('#jumlah').data('max-loc', rowData.qty_on_loc);
                $('#tambahModal').find('.satuan').text('Jumlah (' +  rowData.satuan.toUpperCase() + ')');
                var kategori = rowData.kategori;
                if (kategori === 'tukar') {
                    $('#ket').bootstrapToggle('enable');
                    $('#ket').bootstrapToggle('on');
                } else {
                    $('#ket').bootstrapToggle('off');
                    $('#ket').bootstrapToggle('disable');
                }
                $('#error-message').hide();
                $('#tambahModal').find('#tambahkan').prop('disabled', true);
                $('#tambahModal').modal('show')
            });
            $('#dataBarangReady').on('click', '#pesanLangsung', function() {
                var id = $(this).data('id');
                var rowData = table.row($(this).parents('tr')).data();

                $('#tambahModal').find('.modal-title').text(rowData.nama);
                $('#tambahModal').find('#barang').val(rowData.kode_js);
                $('#tambahModal').find('#jumlah').val('0');
                $('#tambahModal').find('#sbmtPesanLangsung').prop('hidden', false);
                $('#tambahModal').find('#tambahkan').prop('hidden', true);
                $('#tambahModal').find('#jumlah').data('max', rowData.total_qty);
                $('#tambahModal').find('#jumlah').data('max-loc', rowData.qty_on_loc);
                $('#tambahModal').find('.satuan').text('Jumlah (' +  rowData.satuan.toUpperCase() + ')');
                var kategori = rowData.kategori;
                if (kategori === 'tukar') {
                    $('#ket').bootstrapToggle('enable');
                    $('#ket').bootstrapToggle('on');
                } else {
                    $('#ket').bootstrapToggle('off');
                    $('#ket').bootstrapToggle('disable');
                }
                $('#tambahModal').find('#sbmtPesanLangsung').prop('disabled', true);
                $('#error-message').hide();
                $('#tambahModal').modal('show')
            });
        });

        function togglePesanButtonState(disabled) {
            $('#pesanButton').prop('disabled', disabled);
            $('.spinner-border').prop('hidden', !disabled);
        }

        $(document).ready(function() {
            $('#pesanButton').on('click', function() {
                $.ajax({
                    url: "{{ route('user.pesan') }}",
                    method: 'GET',
                    data: {},
                    success: function(response) {
                        $('#keranjangModal').modal('hide');
                        Swal.fire({
                            title: "Success",
                            text: "Pesanan berhasil dibuat, silahkan tunggu konfirmasi",
                            icon: "success",
                            timer: 3500
                        });
                        table.draw();
                    }
                });
            });
        });

        function deleteBarang(kode_js) {
            keranjang('delete', kode_js);
        }

        var debounceTimers = {};
        var pendingAjaxRequests = [];

        function debounceAjaxRequest(action ,itemId, data, keterangan) {
            if (!debounceTimers[itemId] || debounceTimers[itemId].data !== data) {
                if (debounceTimers[itemId]) {
                    clearTimeout(debounceTimers[itemId].timer);
                }

                const existingIndex = pendingAjaxRequests.indexOf(itemId);
                if (existingIndex === -1) {
                    pendingAjaxRequests.push(itemId);
                }
                debounceTimers[itemId] = {
                    data: data,
                    timer: setTimeout(function() {
                        keranjang(action, itemId, data, keterangan);
                        console.log("Sending AJAX request for item with ID:", itemId);
                        console.log("Pending AJAX requests:", pendingAjaxRequests);
                        var index = pendingAjaxRequests.indexOf(itemId);
                        if (index !== -1) {
                            pendingAjaxRequests.splice(index, 1);
                        }
                        if (pendingAjaxRequests.length === 0) {
                            togglePesanButtonState(false);
                        }
                        delete debounceTimers[itemId];
                    }, 3000)
                };
            }
            if (pendingAjaxRequests.length > 0) {
                togglePesanButtonState(true);
            }
        }

        function appendKeranjang(response) {
            var modalTitle = $('#keranjangModal').find('.modal-title');
            var modalBody = $('#keranjangModal').find('#isiKeranjang');
            modalBody.empty();

            modalBody.append(`
                <div class="table-responsive text-nowrap">
                    <table class="table table-sm">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 20px">No</th>
                                <th>Nama Barang</th>
                                <th>Keterangan</th>
                                <th style="width: 180px">Qty</th>
                                <th style="width: 20px">Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
            `);

            if (response.barang && response.barang.length > 0) {
                response.barang.forEach(function (barang, index) {
                    var isChecked = (barang.pivot.keterangan === 'tukar') ? 'checked' : '';
                    var isRequest = (barang.kategori === 'request') ? 'disabled' : '';
                    modalBody.find('tbody').append(`
                        <tr class="text-center align-middle justify-content-center">
                            <td>${index + 1}</td>
                            <td>${barang.nama}<br>(${barang.satuan})</td>
                            <td>
                                <input class="form-check-input" type="checkbox" id="keterangan_${barang.kode_js}" data-barang="${barang.kode_js}" data-toggle="toggle" ${isChecked} ${isRequest} onchange="handleCheckboxChange(this)">    
                            </td>
                            <td>
                                <div class="input-group number-spinner">
                                    <button type="button" class="btn btn-sm border" onclick="minValue('${barang.kode_js}')">
                                        <i class="ti ti-minus"></i>
                                    </button>
                                    <input type="text" class="form-control form-control-sm text-center" value="${barang.pivot.qty}" id="${barang.kode_js}"
                                        name="${barang.kode_js}" data-max="${barang.total_qty}" data-max-loc="${barang.qty_on_loc}" oninput="validateInput(this)">
                                    <button type="button" class="btn btn-sm border" onclick="plusValue('${barang.kode_js}')">
                                        <i class="ti ti-plus"></i>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger" onclick="deleteBarang('${barang.kode_js}')">
                                    <i class="ti ti-trash"></i>
                                </button>    
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-center text-danger" id="error-message-${barang.kode_js}" style="display:none;"></td>
                        </tr>
                    `);

                    $(`#keterangan_${barang.kode_js}`).bootstrapToggle({
                        on: 'Tukar',
                        off: 'Request',
                        offstyle: 'success',
                        style: 'slow'
                    });
                });
            } else {
                modalBody.find('tbody').append(`
                    <tr>
                        <td colspan="5" class="text-center">No data available</td>
                    </tr>
                `);
            }

            modalBody.append(`
                        </tbody>
                    </table>
                </div>
            `);

            $('#keranjangModal').modal('show');
        }

        function keranjang(action, kode_js, qty, keterangan) {

            $.ajax({
                url: "{{ route('user.keranjang') }}",
                method: 'GET',
                data: {
                    action: action,
                    kode_js: kode_js,
                    qty: qty,
                    keterangan: keterangan
                },
                success: function(response) {
                    if (action === 'keranjang') {
                        appendKeranjang(response);
                    } else if (action === 'add') {
                        $('#tambahModal').modal('hide');
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            text: "Barang dimasukan ke-keranjang",
                            icon: "success",
                            timer: 3500
                        });
                    } else if (action === 'delete') {
                        appendKeranjang(response);
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            text: "Barang dihapus dari keranjang",
                            icon: "success",
                            timer: 3500
                        });
                    }
                }
            })
        }

        function pesan(kode_js, qty, keterangan) {
            $.ajax({
                url: "{{ route('user.pesan1') }}",
                method: 'GET',
                data: {
                    kode_js: kode_js,
                    qty: qty,
                    keterangan: keterangan
                },
                success: function(response) {
                    $('#tambahModal').modal('hide');
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        text: "Pesanan berhasil dibuat, silahkan tunggu konfirmasi",
                        icon: "success",
                        timer: 3500
                    });
                }
            })
        }
    </script>
@endsection
