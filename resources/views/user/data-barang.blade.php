@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="row">
                <div class="col-sm-4">
                    <h5 class="card-header">Data Barang Line blablabla</h5>
                </div>
            </div>
            <div class="table-responsive text-nowrap pt-0 p-3">
                <table class="table table-striped" id="dataBarang">
                    <thead>
                        <tr>
                            <th style="width: 20px">No</th>
                            <th>Kode JS</th>
                            <th>Nama Barang</th>
                            <th class="text-center">Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td>2E2E32RJ</td>
                                <td>Bolpoint</td>
                                <td class="text-center">16</td>
                            </tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td>89CCSD90</td>
                                <td>Sepatu Safety</td>
                                <td class="text-center">3</td>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
