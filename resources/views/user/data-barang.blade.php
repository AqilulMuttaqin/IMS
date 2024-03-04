@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="row">
                <div class="col-sm-4">
                    <h5 class="card-header">Data Barang Line {{$lokasi}}</h5>
                </div>
            </div>
            <div class="table-responsive text-nowrap pt-0 p-3">
                <table class="table table-striped" id="dataBarangLine">
                    <thead>
                        <tr>
                            <th style="width: 20px">No</th>
                            <th>Kode JS</th>
                            <th>Nama Barang</th>
                            <th class="text-center">Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#dataBarangLine').DataTable({
            processing: true,
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
                    data: 'kode_js',
                    name: 'kode_js'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'total_qty',
                    name: 'total_qty'
                },
            ]
        });
    });
</script>
@endsection
