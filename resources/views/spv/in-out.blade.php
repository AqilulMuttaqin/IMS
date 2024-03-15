@extends('layout.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-5">
                    <h5>Data In-Out Barang</h5>
                </div>
                <div class="col-sm-7">
                    <div class="d-flex justify-content-end text-end">
                        <button type="button" class="btn btn-sm btn-success d-flex align-items-center" id="exportBtn">
                            <i class="ti ti-file-export me-1"></i>
                            Export Excel
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row align-items-center mb-3">
                <div class="col-auto d-flex">
                    <div class="label">Filter Data Pesanan : </div>
                </div>
                <div class="col-auto d-flex align-items-center">
                    <label for="start_date" class="me-1">Start,</label>
                    <input type="date" class="form-control" id="start_date" name="start_date"
                        value="">
                </div>
                <div class="col-auto d-flex align-items-center">
                    <label for="end_date" class="me-1">End,</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="">
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-striped w-100" id="dataInOutPesanan">
                    <thead>
                        <tr>
                            <th style="width: 20px">No</th>
                            <th>-------</th>
                            <th>-------</th>
                            <th>-------</th>
                            <th>-------</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
