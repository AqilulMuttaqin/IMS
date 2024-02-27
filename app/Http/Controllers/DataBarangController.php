<?php

namespace App\Http\Controllers;

use App\Models\DataBarang;
use App\Http\Requests\StoreDataBarangRequest;
use App\Http\Requests\UpdateDataBarangRequest;
use App\Models\Barang;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

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

        if (Auth::check() && Auth::user()->role === 'admin' ) {
            return view('staff.data-detail-barang', [
                'title' => 'Data Detail Barang',
            ]);
        } else if (Auth::check() && Auth::user()->role === 'spv') {
            return view('spv.detail-barang', [
                'title' => 'Data Detail Barang'
            ]);
        }
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
        $pesanan = Pesanan::with('barang');

        return response()->json($pesanan);
    }
}
