<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barang = Barang::all();
        return view('staff.data-barang', [
            'title' => 'Data Barang',
            'barang' => $barang,
        ]);
    }

    public function detail()
    {
        $barang = Barang::all();
        return view('staff.data-detail-barang', [
            'title' => 'Data Detail Barang',
            'barang' => $barang,
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
    public function store(Request $request)
    {
        request()->validate([
            'kode_js' => 'required',
            'nama' => 'required',
            'harga' => 'required',
        ]);

        Barang::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBarangRequest $request, Barang $barang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        //
    }
}
