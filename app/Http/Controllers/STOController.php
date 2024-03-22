<?php

namespace App\Http\Controllers;

use App\Models\STO;
use App\Http\Requests\StoreSTORequest;
use App\Http\Requests\UpdateSTORequest;
use App\Models\Barang;

class STOController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $barang = [];

            if(request()->has('q')){
                $search = request()->q;
                $barang =Barang::select("kode_js", "nama")
                        ->where('nama', 'LIKE', "%$search%")
                        ->get();
            }
            return response()->json($barang);
        }

        return view('staff.input-sto', ['title' => 'Input Data STO']);
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
    public function store(StoreSTORequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(STO $sTO)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(STO $sTO)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSTORequest $request, STO $sTO)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(STO $sTO)
    {
        //
    }
}
