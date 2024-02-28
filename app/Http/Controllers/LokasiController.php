<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Http\Requests\StoreLokasiRequest;
use App\Http\Requests\UpdateLokasiRequest;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()){
            $lokasi = Lokasi::all();

            $lokasi->map(function ($item, $key) {
                $item['DT_RowIndex'] = $key + 1;
                return $item;
            });

            return datatables()->of($lokasi)->make(true);
        }
        
        return view('spv.lokasi', [
            'title' => 'Data Lokasi'
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
            'nama' => 'required',
        ]);

        Lokasi::create($request->all());
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Lokasi $lokasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lokasi $lokasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'nama' => 'required',   
        ]);

        $lokasi = Lokasi::where('id', $id)->first();
        $lokasi->update([
            'nama' => $request->input('nama'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lokasi $lokasi)
    {
        $lokasi->delete();

        return redirect()->back();
    }
}
