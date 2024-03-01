@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h6 class="text-muted">Data Pesanan</h6>
        <div class="nav-align-top mb-4">
            <ul class="nav nav-tabs nav-fill" role="tablist">
                <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#menu-1"
                        aria-controls="menu-1" aria-selected="true">
                        <i class="tf-icons bx bx-message-alt-detail"></i> Pesanan Masuk
                        <span id="pendingNotif"
                            class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-success">0</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#menu-2"
                        aria-controls="menu-2" aria-selected="false">
                        <i class="tf-icons bx bx-store-alt"></i> Perlu Disiapkan
                        <span id="disiapkanNotif"
                            class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-warning">0</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#menu-3"
                        aria-controls="menu-3" aria-selected="false">
                        <i class="tf-icons bx bx-send"></i> Perlu Dikirim
                        <span id="dikirimNotif"
                            class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-primary">0</span>
                    </button>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane row fade show active" id="menu-1" role="tabpanel">
                    <div class="row" id="pesananMasuk"></div>
                </div>
                <div class="tab-pane fade" id="menu-2" role="tabpanel">
                    <div class="row" id="pesananPerluDisiapkan"></div>
                </div>
                <div class="tab-pane fade" id="menu-3" role="tabpanel">
                    <div class="row" id="pesananPerluDikirim"></div>
                </div>
            </div>
        </div>

        {{-- <div class="card p-3 pb-0 mb-4">
            <a data-bs-toggle="collapse" href="#pesananMasuk" role="button" aria-expanded="false"
                aria-controls="pesananMasuk">
                <h3 class="text-center text-secondary">Pesanan Baru
                    <i class="arrow bx bx-down-arrow-alt" style="font-size: 1em;"></i>
                </h3>
            </a>
        </div>

        <div class="row collapse show" id="pesananMasuk">
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
        <div class="card p-3 pb-0 mb-4">
            <a data-bs-toggle="collapse" href="#pesananPerluDisiapkan" role="button" aria-expanded="false"
                aria-controls="pesananPerluDisiapkan">
                <h3 class="text-center text-secondary">Pesanan Perlu Disiapkan
                    <i class="arrow bx bx-right-arrow-alt" style="font-size: 1em;"></i>
                </h3>
            </a>
        </div>

        <div class="row collapse" id="pesananPerluDisiapkan">
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
        <div class="card p-3 pb-0 mb-4">
            <a data-bs-toggle="collapse" href="#pesananPerluDikirim" role="button" aria-expanded="false"
                aria-controls="pesananPerluDikirim">
                <h3 class="text-center text-secondary">Pesanan Perlu Dikirim
                    <i class="arrow bx bx-right-arrow-alt" style="font-size: 1em;"></i>
                </h3>
            </a>
        </div>

        <div class="row collapse" id="pesananPerluDikirim">
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
        </div> --}}
    </div>

    <div class="modal fade" id="detailKonfirmasiModal" tabindex="-1" role="dialog"
        aria-labelledby="detailKonfirmasiModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailKonfirmasiModalLabel">Detail Pesanan Line ...</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-xxl" id="modal-body">
                        <div class="row mb-3">
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
                        </div>
                        <div class="row justify-content-end">
                            <div class="text-end">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // $('#pesananMasuk').on('show.bs.collapse', function() {
            //     $(this).prev().find('.arrow').removeClass('bx-right-arrow-alt').addClass(
            //         'bx-down-arrow-alt');
            // });
            // $('#pesananMasuk').on('hide.bs.collapse', function() {
            //     $(this).prev().find('.arrow').removeClass('bx-down-arrow-alt').addClass(
            //         'bx-right-arrow-alt');
            // });
            // $('#pesananPerluDisiapkan').on('show.bs.collapse', function() {
            //     $(this).prev().find('.arrow').removeClass('bx-right-arrow-alt').addClass(
            //         'bx-down-arrow-alt');
            // });
            // $('#pesananPerluDisiapkan').on('hide.bs.collapse', function() {
            //     $(this).prev().find('.arrow').removeClass('bx-down-arrow-alt').addClass(
            //         'bx-right-arrow-alt');
            // });
            // $('#pesananPerluDikirim').on('show.bs.collapse', function() {
            //     $(this).prev().find('.arrow').removeClass('bx-right-arrow-alt').addClass(
            //         'bx-down-arrow-alt');
            // });
            // $('#pesananPerluDikirim').on('hide.bs.collapse', function() {
            //     $(this).prev().find('.arrow').removeClass('bx-down-arrow-alt').addClass(
            //         'bx-right-arrow-alt');
            // });

            get_data('pesananMasuk', 'pending');

            get_data('pesananPerluDisiapkan', 'disiapkan');

            get_data('pesananPerluDikirim', 'dikirim');

            //setInterval(updateNotif, 60000);

            setInterval(function() {
                updateContainers('pesananMasuk', 'pending');
                updateContainers('pesananPerluDisiapkan', 'disiapkan');
                updateContainers('pesananPerluDikirim', 'dikirim');
            }, 300000);
        });

        function get_data(containerId, status) {
            $.ajax({
                url: "{{ url()->current() }}",
                method: 'GET',
                data: {
                    status: status
                }, // Pass the status parameter in the request
                success: function(response) {
                    $('#pendingNotif').text(response.counts.pending);
                    $('#disiapkanNotif').text(response.counts.disiapkan);
                    $('#dikirimNotif').text(response.counts.dikirim);
                    var container = $('#' + containerId);
                    container.empty();

                    $.each(response.pesanan, function(index,
                        pesanan) { // Access the 'pesanan' property in the response
                        var card = $('<div class="col-sm-6 col-md-4 col-lg-3 my-2"></div>');
                        var cardBody = $('<div class="card border"></div>');
                        var cardHeader = $('<div class="card-header pb-1"></div>');
                        var cardTitle = $('<h6 class="text-center">Pesanan Line ' + pesanan.id +
                            '</h6>');
                        var hr = $('<hr>');
                        var cardCardBody = $('<div class="card-body"></div>');

                        var row = $('<div class="row"></div>');
                        var nameLabelCol = $(
                            '<div class="col-6"><label for="label">Tanggal</label></div>');
                        var nameValueCol = $('<div class="col-6"><p id="label">: ' + pesanan.user.name +
                            '</p></div>');
                        var detailLabelCol = $(
                            '<div class="col-6"><label for="detail">Detail</label></div>');
                        var detailValueCol = $(
                            '<div class="col-6"><p id="detail">: <button type="button" class="btn btn-sm btn-primary" id="btnDetail" data-pesanan-id="' +
                            pesanan.id +
                            '" data-bs-toggle="modal" data-bs-target="#detailKonfirmasiModal"><i class="bx bx-show"></i></button></p></div>'
                        );
                        var hr = $('<hr>');
                        var confirmButtonCol = $('<div class="col-12"></div>');
                        var confirmButton = $('<button type="button" class="btn w-100"></button>');
                        if (containerId === 'pesananMasuk') {
                            confirmButton.text('Konfirmasi');
                            confirmButton.addClass('btn-success');
                        } else if (containerId === 'pesananPerluDisiapkan') {
                            confirmButton.text('Kirim');
                            confirmButton.addClass('btn-warning');
                        } else if (containerId === 'pesananPerluDikirim') {
                            confirmButton.text('Selesai');
                            confirmButton.addClass('btn-primary');
                        }

                        cardHeader.append(cardTitle);
                        cardHeader.append(hr);

                        row.append(nameLabelCol);
                        row.append(nameValueCol);
                        row.append(detailLabelCol);
                        row.append(detailValueCol);
                        row.append(hr.clone());
                        confirmButtonCol.append(confirmButton);
                        row.append(confirmButtonCol);
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
                    modalTitle.text('Detail Pesanan Line ' + response.id);

                    modalBody.empty();
                    modalBody.append(`
                            <div class="row mb-3">
                                <label class="col-sm-8 col-form-label" for="label">Nama/Label Pesanan</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control text-center" id="label" name="label"
                                        value="${response.user.name}" disabled>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-8 col-form-label" for="Jumlah"></label>
                                <div class="col-sm-4">
                                    <div class="text-muted text-center">Jumlah</div>
                                </div>
                            </div>
                        `);

                    $.each(response.barang, function(index, barang) {
                        modalBody.append(`
                            <div class="row mb-3">
                                <label class="col-sm-8 col-form-label" for="barang-${index}">${barang.nama}</label>
                                <div class="col-sm-4">
                                    <div class="input-group number-spinner">
                                        <input type="text" class="form-control text-center" value="${barang.pivot.qty}" id="barang-${index}" name="barang-${index}" disabled>
                                    </div>
                                </div>
                            </div>
                        `);
                    });

                    $('#detailKonfirmasiModal').modal('show');
                },
                error: function(xhr, status, error) {
                    // Handle errors here
                }
            });
        });
    </script>
@endsection
