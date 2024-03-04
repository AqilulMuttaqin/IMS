@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-4">
                        <h5>Data Barang Ready</h5>
                    </div>
                    <div class="col-sm-8">
                        <div class="d-flex justify-content-end text-end">
                            <button type="button" class="btn btn-sm btn-warning d-flex align-items-center" id="showCart">
                                <i class="bx bxs-cart-alt me-1"></i>
                                Lihat Keranjang
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-striped" id="dataBarangReady">
                        <thead>
                            <tr>
                                <th style="width: 20px">No</th>
                                <th>Nama</th>
                                <th>Stok</th>
                                <th style="width: 30px;">Check Out</th>
                            </tr>
                        </thead>
                        <tbody>
    
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="keranjangModal" tabindex="-1" role="dialog" aria-labelledby="keranjangModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="keranjangModalLabel">Keranjang Anda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="keranjangForm">
                        <div class="col-xxl" id="isiKeranjang">
                            <div class="row mb-3">
                                <label class="col-sm-6 col-form-label" for="Jumlah"></label>
                                <div class="col-sm-4">
                                    <div class="text-muted text-center">Jumlah</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-6 col-form-label" for="barang-1">Bolpoin</label>
                                <div class="col-sm-4">
                                    <div class="input-group number-spinner">
                                        <button type="button" class="btn btn-sm border" onclick="minValue('barang-1')">
                                            <i class="bx bx-minus"></i>
                                        </button>
                                        <input type="text" class="form-control text-center" value="1" id="barang-1"
                                            name="barang-1" oninput="validateInput(this)">
                                        <button type="button" class="btn btn-sm border" onclick="plusValue('barang-1')">
                                            <i class="bx bx-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-danger">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-6 col-form-label" for="barang-2">Kertas</label>
                                <div class="col-sm-4">
                                    <div class="input-group number-spinner">
                                        <button type="button" class="btn btn-sm border" onclick="minValue('barang-2')">
                                            <i class="bx bx-minus"></i>
                                        </button>
                                        <input type="text" class="form-control text-center" value="1" id="barang-2"
                                            name="barang-2" oninput="validateInput(this)">
                                        <button type="button" class="btn btn-sm border" onclick="plusValue('barang-2')">
                                            <i class="bx bx-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-danger">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary" id="pesanButton">Pesan</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Nama Barangnya</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="keranjangForm">
                        <div class="col-xxl">
                            <div class="row mb-3">
                                <label class="col-sm-8 col-form-label" for="jumlah">Jumlah Barang</label>
                                <div class="col-sm-4">
                                    <div class="input-group number-spinner">
                                        <button type="button" class="btn btn-sm border" onclick="minValue('jumlah')">
                                            <i class="bx bx-minus"></i>
                                        </button>
                                        <input type="text" class="form-control text-center" value="1"
                                            id="barang" name="barang" hidden>
                                        <input type="text" class="form-control text-center" value="1"
                                            id="jumlah" name="jumlah" oninput="validateInput(this)">
                                        <button type="button" class="btn btn-sm border" onclick="plusValue('jumlah')">
                                            <i class="bx bx-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-warning" id="tambahkan">Tambahkan</button>
                    <button type="button" class="btn btn-sm btn-danger" id="sbmtPesanLangsung" hidden>Pesan</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const plusValue = (id) => {
            const inputElement = document.getElementById(id);
            inputElement.value = parseInt(inputElement.value) + 1;
            if(id !== 'jumlah'){
                debounceAjaxRequest(id, inputElement.value);
            }
        }

        const minValue = (id) => {
            const inputElement = document.getElementById(id);
            const newValue = parseInt(inputElement.value) - 1;
            inputElement.value = newValue >= 0 ? newValue : 0;
            if(id !== 'jumlah'){
                debounceAjaxRequest(id, inputElement.value);
            }
        }

        const validateInput = (input) => {
            input.value = input.value.replace(/[^0-9]/g, '');
            const id = input.id;
            const data = input.value;
            console.log(id);
            console.log(data);
            if(id !== 'jumlah'){
                debounceAjaxRequest(id, data);
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
                                    <i class="bx bxs-cart-add"></i>
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
                keranjang('add', barang, jumlah);
            });

            $('#sbmtPesanLangsung').on('click', function() {
                var barang = $('#tambahModal').find('#barang').val();
                var jumlah = $('#tambahModal').find('#jumlah').val();
                pesan(barang, jumlah);
            });

            $('#dataBarangReady').on('click', '#tambahBarang', function() {
                var id = $(this).data('id');
                var rowData = table.row($(this).parents('tr')).data();

                $('#tambahModal').find('.modal-title').text(rowData.nama);
                $('#tambahModal').find('#barang').val(rowData.kode_js);
                $('#tambahModal').find('#jumlah').val('1');
                $('#tambahModal').find('#sbmtPesanLangsung').prop('hidden', true);
                $('#tambahModal').find('#tambahkan').prop('hidden', false);
                $('#tambahModal').modal('show')
            });
            $('#dataBarangReady').on('click', '#pesanLangsung', function() {
                var id = $(this).data('id');
                var rowData = table.row($(this).parents('tr')).data();

                $('#tambahModal').find('.modal-title').text(rowData.nama);
                $('#tambahModal').find('#barang').val(rowData.kode_js);
                $('#tambahModal').find('#jumlah').val('1');
                $('#tambahModal').find('#sbmtPesanLangsung').prop('hidden', false);
                $('#tambahModal').find('#tambahkan').prop('hidden', true);
                $('#tambahModal').modal('show')
            });
        });

        function togglePesanButtonState(disabled) {
            $('#pesanButton').prop('disabled', disabled);
        }

        $(document).ready(function() {
            $('#pesanButton').on('click', function() {
                $.ajax({
                    url: "{{ route('user.pesan') }}",
                    method: 'GET',
                    data: { 
                    },
                    success: function(response) {
                        window.location.reload();
                    }
                });
            });
        });

        function deleteBarang(kode_js){
            keranjang('delete', kode_js);
        }

        var debounceTimers = {};
        var pendingAjaxRequests = [];

        function debounceAjaxRequest(itemId, data) {
            if (!debounceTimers[itemId]) {
                pendingAjaxRequests.push(itemId);
                debounceTimers[itemId] = setTimeout(function () {
                    keranjang('update', itemId, data);
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
                }, 3000);
                togglePesanButtonState(true);
            }
        }

        function appendKeranjang(response){
            var modalTitle = $('#keranjangModal').find('.modal-title');
            var modalBody = $('#keranjangModal').find('#isiKeranjang');
            modalBody.empty();
                        
            modalBody.append(`
            <div class="row mb-3">
            <label class="col-sm-6 col-form-label" for="Jumlah"></label>
            <div class="col-sm-4">
            <div class="text-muted text-center">Jumlah</div>
            </div>
            </div>
            `);

            $.each(response.barang, function(index, barang) {
                modalBody.append(
                    `
                <div class="row mb-3">
                    <label class="col-sm-6 col-form-label" for="${barang.kode_js}">${barang.nama}</label>
                    <div class="col-sm-4">
                        <div class="input-group number-spinner">
                            <button type="button" class="btn btn-sm border" onclick="minValue('${barang.kode_js}')">
                                <i class="bx bx-minus"></i>
                            </button>
                            <input type="text" class="form-control text-center" value="${barang.pivot.qty}" id="${barang.kode_js}"
                                name="${barang.kode_js}" oninput="validateInput(this)">
                            <button type="button" class="btn btn-sm border" onclick="plusValue('${barang.kode_js}')">
                                <i class="bx bx-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <button type="button" class="btn btn-danger" onclick="deleteBarang('${barang.kode_js}')">
                            <i class="bx bx-trash"></i>
                        </button>
                    </div>
                </div>

                    `
                );
            });

            $('#keranjangModal').modal('show')
        }

        function keranjang(action, kode_js, qty){
            
            $.ajax({
                url: "{{ route('user.keranjang') }}",
                method: 'GET',
                data: { 
                    action: action,
                    kode_js: kode_js,
                    qty: qty
                },
                success: function(response) {
                    if(action === 'keranjang'){
                        appendKeranjang(response);
                    } else if (action === 'add'){
                        $('#tambahModal').modal('hide');
                        Swal.fire({
                            title: "Success",
                            text: "Barang dimasukan keranjang",
                            icon: "success",
                            timer: 1000
                        });
                    } else if (action === 'delete'){
                        appendKeranjang(response);
                        Swal.fire({
                            title: "Success",
                            text: "Barang dimasukan keranjang",
                            icon: "success",
                            timer: 1000
                        });
                    }
                }
            })
        }
        function pesan(kode_js, qty){
            
            $.ajax({
                url: "{{ route('user.pesan1') }}",
                method: 'GET',
                data: { 
                    kode_js: kode_js,
                    qty: qty
                },
                success: function(response) {
                        Swal.fire({
                            title: "Success",
                            text: "Pesanan Berhasil Dibuat",
                            icon: "success",
                            timer: 1000
                        });
                }
            })
        }
    </script>
@endsection
