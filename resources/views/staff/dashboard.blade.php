@extends('layout.app')

@section('content')
    <!-- Container Content Dashboard Staff Gudang -->
    <h6 class="text-muted">Data Pesanan</h6>
    <!-- Filled Tabs Menu Pesanan -->
    <div class="card">
        <div class="nav-align-top mb-4">
            <ul class="nav nav-pills nav-fill border" role="tablist" style="border-radius: 8px;">
                <!-- Menu 1 - Pesanan Masuk -->
                <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#menu-1"
                        aria-controls="menu-1" aria-selected="true">
                        <i class="ti ti-message me-1"></i> Pesanan Masuk
                        <span id="pendingNotif" class="badge rounded-pill bg-success ms-1">0</span>
                    </button>
                </li>
                <!-- Menu 2 - Pesanan Perlu Disiapkan -->
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#menu-2"
                        aria-controls="menu-2" aria-selected="false">
                        <i class="ti ti-refresh-alert me-1"></i> Perlu Disiapkan
                        <span id="disiapkanNotif" class="badge rounded-pill bg-warning ms-1">0</span>
                    </button>
                </li>
                <!-- Menu 3 - Pesanan Perlu Dikirim -->
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#menu-3"
                        aria-controls="menu-3" aria-selected="false">
                        <i class="ti ti-send me-1"></i> Perlu Dikirim
                        <span id="dikirimNotif" class="badge rounded-pill bg-primary ms-1">0</span>
                    </button>
                </li>
            </ul>
    
            <!-- Content Filled Tabs -->
            <div class="card-body">
                <div class="tab-content">
                    <!-- Content Menu 1 -->
                    <div class="tab-pane fade show active" id="menu-1" role="tabpanel">
                        <div class="row" id="pesananMasuk"></div>
                    </div>
                    <!-- Content Menu 2 -->
                    <div class="tab-pane fade" id="menu-2" role="tabpanel">
                        <div class="row" id="pesananPerluDisiapkan"></div>
                    </div>
                    <!-- Content Menu 3 -->
                    <div class="tab-pane fade" id="menu-3" role="tabpanel">
                        <div class="row" id="pesananPerluDikirim"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal - Detail Pesanan -->
    <div class="modal fade" id="detailKonfirmasiModal" tabindex="-1" role="dialog"
        aria-labelledby="detailKonfirmasiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailKonfirmasiModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-xxl" id="modal-body">
                        {{-- <div class="row mb-3">
                            <label class="col-sm-8 col-form-label" for="label">Tanggal Pesan</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control text-center" id="label" name="label"
                                    value="pesanan 1" disabled>
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
                        </div> --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary edit-detail" hidden>save</button>
                    <button type="button" class="btn btn-primary edit-detail" >Edit</button>
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
            const maxQty = parseInt($('#jumlah').data('max'));
            const currentQty = parseInt(inputElement.value);
            if (currentQty > maxQty) {
                $('#error-message').text('Jumlah melebihi stok yang tersedia').show();
                $('#tambahkan').prop('disabled', true);
            } else {
                $('#error-message').hide();
                $('#tambahkan').prop('disabled', false);
                if (id !== 'jumlah') {
                    debounceAjaxRequest(id, inputElement.value);
                }
            }
        }

        const minValue = (id) => {
            const inputElement = document.getElementById(id);
            const newValue = parseInt(inputElement.value) - 1;
            inputElement.value = newValue >= 0 ? newValue : 0;
            const maxQty = parseInt($('#jumlah').data('max'));
            const currentQty = parseInt(newValue);
            if (currentQty > maxQty) {
                $('#error-message').text('Jumlah melebihi stok yang tersedia').show();
                $('#tambahkan').prop('disabled', true);
            } else {
                $('#error-message').hide();
                $('#tambahkan').prop('disabled', false);
                if (id !== 'jumlah') {
                    debounceAjaxRequest(id, inputElement.value);
                }
            }
        }

        const validateInput = (input) => {
            input.value = input.value.replace(/[^0-9]/g, '');
            const id = input.id;
            const data = input.value;
            const maxQty = parseInt($('#jumlah').data('max'));
            const currentQty = parseInt(data);
            if (currentQty > maxQty) {
                $('#error-message').text('Jumlah melebihi stok yang tersedia').show();
                $('#tambahkan').prop('disabled', true);
            } else {
                $('#error-message').hide();
                $('#tambahkan').prop('disabled', false);
                if (id !== 'jumlah') {
                    debounceAjaxRequest(id, data);
                }
            }
        }
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            get_data('pesananMasuk', 'pending');
            get_data('pesananPerluDisiapkan', 'disiapkan');
            get_data('pesananPerluDikirim', 'dikirim');

            // $('#statusPesanan').click(function() {
            //     console.log('tombol diklik');
            //     var pesananId = $(this).data('pesanan-id');
            //     var status = $(this).data('status');

            //     $.ajax({
            //         url: "{{ route('staff.update-pesanan') }}",
            //         method: 'POST',
            //         data: {
            //             pesanan_id: pesananId,
            //             status: status
            //         },
            //         success: function(response) {
            //             if (response.status === 'success') {
            //                 alert('Pesanan berhasil di' + status);
            //                 get_data('pesananMasuk', 'pending');
            //                 get_data('pesananPerluDisiapkan', 'disiapkan');
            //                 get_data('pesananPerluDikirim', 'dikirim');
            //             }
            //         }
            //     });
            // });

            setInterval(function() {
                updateContainers('pesananMasuk', 'pending');
                updateContainers('pesananPerluDisiapkan', 'disiapkan');
                updateContainers('pesananPerluDikirim', 'dikirim');
            }, 300000);
        });

        $(document).on('click', '#rejectPesanan', function() {
            var pesananId = $(this).data('pesanan-id');
            var status = $(this).data('status');

            Swal.fire({
                    title: 'Tolak Pesanan',
                    text: "Apakah anda yakin ingin menolak pesanan ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Batalkan'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('staff.update-pesanan') }}",
                            method: 'POST',
                            data: {
                                pesanan_id: pesananId,
                                status: status
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: "Success",
                                        text: "Pesanan " + status,
                                        icon: "success",
                                        timer:3500
                                    });
                                    get_data('pesananMasuk', 'pending');
                                    get_data('pesananPerluDisiapkan', 'disiapkan');
                                    get_data('pesananPerluDikirim', 'dikirim');
                                }
                            }
                        });
                    }
                });          
        });

        $(document).on('click', '#statusPesanan', function() {
            var pesananId = $(this).data('pesanan-id');
            var status = $(this).data('status');

            $.ajax({
                url: "{{ route('staff.update-pesanan') }}",
                method: 'POST',
                data: {
                    pesanan_id: pesananId,
                    status: status
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            title: "Success",
                            text: "Pesanan " + status,
                            icon: "success",
                            timer:3500
                        });
                        get_data('pesananMasuk', 'pending');
                        get_data('pesananPerluDisiapkan', 'disiapkan');
                        get_data('pesananPerluDikirim', 'dikirim');
                    }
                }
            });
        });

        function get_data(containerId, status) {
            $.ajax({
                url: "{{ url()->current() }}",
                method: 'GET',
                data: {
                    status: status
                },
                success: function(response) {
                    $('#pendingNotif').text(response.counts.pending);
                    $('#disiapkanNotif').text(response.counts.disiapkan);
                    $('#dikirimNotif').text(response.counts.dikirim);
                    var container = $('#' + containerId);
                    container.empty();

                    $.each(response.pesanan, function(index, pesanan) {
                        var card = $('<div class="col-sm-6 col-md-4 col-lg-3 my-2"></div>');
                        var cardBody = $('<div class="card border"></div>');
                        var cardHeader = $('<div class="card-header pb-0 mb-0"></div>');
                        console.log(pesanan);
                        var cardTitle = $('<h6 class="text-center">Kode Pesan <br> ' + pesanan.kode_pesanan + '</h6>');
                        var hr = $('<hr>');
                        var cardCardBody = $('<div class="card-body pt-0"></div>');
                        var row = $('<div class="row"></div>');
                        var namaLabelCol = $('<div class="col-4"><label for="nama">Nama</label></div>');
                        var namaValueCol = $('<div class="col-8"><p id="nama">: ' + pesanan.user.name +'</p></div>');
                        var tanggalLabelCol = $('<div class="col-4"><label for="tanggal">Tanggal</label></div>');
                        var tanggal = moment.utc(pesanan.created_at).tz('Asia/Jakarta').format('D MMM YYYY');
                        var tanggalValueCol = $('<div class="col-8"><p id="tanggal">: ' + tanggal + '</p></div>');
                        var lokasiLabelCol = $('<div class="col-4"><label for="lokasi">Line</label></div>');
                        var lokasiValueCol = $('<div class="col-8"><p id="lokasi">: ' + pesanan.user.lokasi.nama +'</p></div>');
                        var detailLabelCol = $('<div class="col-4"><label for="detail">Detail</label></div>');
                        var detailValueCol = $('<div class="col-8"><p id="detail">: <button type="button" class="btn btn-sm btn-primary" id="btnDetail" data-pesanan-id="'
                            + pesanan.id + '" data-bs-toggle="modal" data-bs-target="#detailKonfirmasiModal"><i class="ti ti-eye"></i></button></p></div>'
                        );
                        var hr = $('<hr>');
                        //var confirmButtonCol = $('<div class="col-12"></div>');
                        var actionButtonCol = $('<div class="col-12 d-flex"></div>');
                        var confirmButton = $('<button type="button" id="statusPesanan" class="btn w-100"></button>');
                        var rejectButton = $('<button type="button" id="rejectPesanan" class="btn w-100"></button>');

                        if (containerId === 'pesananMasuk') {
                            confirmButton.text('Terima');
                            confirmButton.addClass('btn-success');
                            confirmButton.data('status', 'disiapkan');
                            confirmButton.data('pesanan-id', pesanan.id);
                            
                            rejectButton.text('Tolak');
                            rejectButton.addClass('btn-danger');
                            rejectButton.data('status', 'ditolak');
                            rejectButton.data('pesanan-id', pesanan.id);
                            
                            actionButtonCol.append(rejectButton);
                            actionButtonCol.append(confirmButton);
                        } else if (containerId === 'pesananPerluDisiapkan') {
                            confirmButton.text('Kirim');
                            confirmButton.addClass('btn-warning');
                            confirmButton.data('status', 'dikirim');
                            confirmButton.data('pesanan-id', pesanan.id);
                            
                            actionButtonCol.append(confirmButton);
                        } else if (containerId === 'pesananPerluDikirim') {
                            confirmButton.text('Selesai');
                            confirmButton.addClass('btn-primary');
                            confirmButton.data('status', 'terkirim');
                            confirmButton.data('pesanan-id', pesanan.id);
                            
                            actionButtonCol.append(confirmButton);
                        }

                        cardHeader.append(cardTitle);
                        cardHeader.append(hr);
                        row.append(namaLabelCol);
                        row.append(namaValueCol);
                        row.append(tanggalLabelCol);
                        row.append(tanggalValueCol);
                        row.append(lokasiLabelCol);
                        row.append(lokasiValueCol);
                        row.append(detailLabelCol);
                        row.append(detailValueCol);
                        row.append(hr.clone());
                        //confirmButtonCol.append(confirmButton);
                        // row.append(confirmButtonCol);
                        row.append(actionButtonCol);
                        cardCardBody.append(row);
                        cardBody.append(cardHeader);
                        cardBody.append(cardCardBody);
                        card.append(cardBody);
                        container.append(card);
                    });
                }
            });
        }


        $(document).on('click', '#btnDetail', function() {
            var pesananId = $(this).data('pesanan-id');
            var modalTitle = $('#detailKonfirmasiModal').find('.modal-title');
            var modalBody = $('#detailKonfirmasiModal').find('#modal-body');

            $.ajax({
                url: "{{ route('staff.detail-pesanan') }}",
                method: 'GET',
                data: {
                    pesanan_id: pesananId
                },
                success: function(response) {
                    modalTitle.text('Detail Pesanan');

                    modalBody.empty();
                    modalBody.append(`
                        <div class="row mb-3">
                            <div class="col-sm-3 mb-2">Nama</div>
                            <div class="col-sm-1">:</div>
                            <div class="col-sm-8">${response.user.name}</div>
                            <div class="col-sm-3 mb-2">Tanggal</div>
                            <div class="col-sm-1">:</div>
                            <div class="col-sm-8">${moment.utc(response.created_at).tz('Asia/Jakarta').format('D MMM YYYY')}</div>
                            <div class="col-sm-3 mb-2">Kode Pesan</div>
                            <div class="col-sm-1">:</div>
                            <div class="col-sm-8">${response.kode_pesanan}</div>
                        </div>
                        <div class="table-responsive border text-nowrap" style="border-radius: 10px;">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 20px">No</th>
                                        <th>Nama Barang</th>
                                        <th>Keterangan</th>
                                        <th style="width: 200px">Qty</th>
                                        <th style="width: 20px">Hapus</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `);
                    
                    response.barang.forEach(function(barang, index) {
                        modalBody.find('tbody').append(`
                            <tr class="text-center align-middle justify-content-center">
                                <td>${index + 1}</td>
                                <td>${barang.nama}</td>
                                <td>
                                    <input class="form-check-input" type="checkbox" id="keterangan_${index}" data-toggle="toggle" disabled>     
                                </td>
                                <td>
                                    <div class="input-group number-spinner">
                                        <button type="button" class="btn btn-sm border" onclick="minValue('${barang.kode_js}')" disabled>
                                            <i class="ti ti-minus"></i>
                                        </button>
                                        <input type="text" class="form-control form-control-sm text-center" value="${barang.pivot.qty}" id="${barang.kode_js}"
                                            name="${barang.kode_js}" oninput="validateInput(this)">
                                        <button type="button" class="btn btn-sm border" onclick="plusValue('${barang.kode_js}')" disabled>
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
                        `);
                        $(`#keterangan_${index}`).bootstrapToggle({
                            on: 'Tukar',
                            off: 'Request',
                            offstyle: 'success',
                            style: 'slow'
                        });
                    });

                    modalBody.append(`
                                </tbody>
                            </table>
                        </div>
                    `);

                    $('#detailKonfirmasiModal').modal('show');
                },
                error: function(xhr, status, error) {
                    // Handle errors here
                }
            });
        });
    </script>
@endsection
