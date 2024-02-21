@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h5 class="card-header">Data Barang</h5>
            <div class="table-responsive text-nowrap pt-0 p-3">
                <table class="table table-striped" id="dataBarang">
                    <thead>
                        <tr>
                            <th style="width: 20px">No</th>
                            <th>No. JS</th>
                            <th>Nama</th>
                            <th>Stok</th>
                            <th>QR Code</th>
                            <th style="width: 30px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barang as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->no_js }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->stok }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary d-flex align-items-center view-qr-code" data-id="{{$item->no_js}}" data-nama="{{$item->nama}}">
                                        <i class="bx bx-show-alt me-1"></i>
                                        QR code
                                    </button>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#"><i
                                                    class="bx bx-edit-alt me-1"></i> Edit</a>
                                            <a class="dropdown-item" href="#"><i
                                                    class="bx bx-trash me-1"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="qrCodeModal" tabindex="-1" role="dialog" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrCodeModalLabel">QR Code</h5>
                    <!-- <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> -->
                </div>
                <div class="modal-body d-flex justify-content-center align-items-center">
                    <div id="qrCodeContainer"></div>
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary download-qr-code">Download QR Code</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var id;
            var nama;
            $(document).on('click', '.view-qr-code', function() {
                id = $(this).data('id');
                nama = $(this).data('nama');

                var qrCodeContent = id;

                $.ajax({
                    url: '{{ route("qr.generate") }}',
                    method: 'POST',
                    data: { qrCodeContent: qrCodeContent },
                    success: function(response) {
                        $('#qrCodeContainer').html('<img src="data:image/png;base64,' + response + '">');
                        $('#qrCodeModal').modal('show');
                    }
                });
            });

            $(document).on('click', '.download-qr-code', function() {
                var qrCodeContent = id;

                $.ajax({
                    url: '{{ route("qr.download") }}',
                    method: 'POST',
                    data: { qrCodeContent: qrCodeContent },
                    xhrFields: {
                        responseType: 'blob'
                    },
                    success: function(blob) {
                        var url = window.URL.createObjectURL(blob);

                        var link = document.createElement('a');
                        link.href = url;
                        link.download = 'qr-code.png';
                        document.body.appendChild(link);

                        link.click();

                        window.URL.revokeObjectURL(url);
                        document.body.removeChild(link);
                    }
                });
            });
        });
    </script>
@endpush