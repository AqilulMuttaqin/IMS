<?php

namespace App\Http\Controllers;

use App\Models\DataBarang;
use App\Http\Requests\StoreDataBarangRequest;
use App\Http\Requests\UpdateDataBarangRequest;
use App\Models\Barang;
use App\Models\Pesanan;

class DataBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()){
            $barang = DataBarang::with('lokasi', 'barang')->get();

            $barang->map(function ($item, $key) {
                $item['DT_RowIndex'] = $key + 1;
                return $item;
            });

            return datatables()->of($barang)->make(true);
        }
        return view('staff.data-detail-barang', [
            'title' => 'Data Detail Barang',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDataBarangRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DataBarang $dataBarang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataBarang $dataBarang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDataBarangRequest $request, DataBarang $dataBarang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataBarang $dataBarang)
    {
        //
    }

    public function tes(){
        $pesanan = Pesanan::with('user')->get();

            return datatables()->of($pesanan)->make(true);
    }
}
