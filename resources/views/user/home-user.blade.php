@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="row">
                <div class="col-sm-4">
                    <h5 class="card-header">Data Barang Ready</h5>
                </div>
                <div class="col-sm-8">
                    <div class="d-flex justify-content-end text-end pt-3 pe-3 mb-3">
                        <button type="button" class="btn btn-sm btn-warning d-flex align-items-center" id="showCart"
                            data-bs-toggle="modal" data-bs-target="#keranjangModal">
                            <i class="bx bxs-cart-alt me-1"></i>
                            Lihat Keranjang
                        </button>
                    </div>
                </div>
            </div>
            <div class="table-responsive text-nowrap pt-0 p-3">
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
                        <div class="col-xxl">
                            <div class="row mb-3">
                                <label class="col-sm-8 col-form-label" for="label">Nama/Label Pesanan</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control text-center" id="label" name="label">
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
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-8 col-form-label" for="barang-2">Kertas</label>
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
                            </div>
                            <div class="row justify-content-end">
                                <div class="text-end">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">Pesan</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const plusValue = (id) => {
            const inputElement = document.getElementById(id);
            inputElement.value = parseInt(inputElement.value) + 1;
        }

        const minValue = (id) => {
            const inputElement = document.getElementById(id);
            const newValue = parseInt(inputElement.value) - 1;
            inputElement.value = newValue >= 0 ? newValue : 0;
        }

        const validateInput = (input) => {
            input.value = input.value.replace(/[^0-9]/g, ''); // Hanya menerima angka
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
                        render: function() {
                            return `
                                <button type="button" class="btn btn-sm btn-warning">
                                    <i class="bx bxs-cart-add"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger">
                                    Request Langsung
                                </button>
                            `;
                        }
                    }
                ]
            });
        });
    </script>
@endsection
