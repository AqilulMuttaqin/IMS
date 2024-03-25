<?php

namespace App\Http\Controllers;

use App\Models\STO;
use App\Http\Requests\StoreSTORequest;
use App\Http\Requests\UpdateSTORequest;
use App\Models\Barang;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

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
    public function store(Request $request)
    {
        $request->validate([
            'kode_js' => 'required',
            'qty' => 'required|numeric'
        ]);

        $kode_js = $request->kode_js;

        $totalQty = Barang::where('kode_js', $kode_js)
            ->with('dataBarang.lokasi')
            ->first()
            ->dataBarang->where('kode_js', $kode_js)
            ->sum(function ($dataBarang) {
                return $dataBarang->lokasi->where('nama', 'GUDANG PRODUKSI')->first()->pivot->qty ?? 0;
            });

        STO::create([
            'kode_js' => $request->kode_js,
            'qty' => $totalQty,
            'actual_qty' => $request->qty
        ]);

        alert()->success('Success', 'Data Berhasil Ditambahkan');
    }

    public function show()
    {
        if(request()->ajax()){
            $sto = STO::with('barang');
            return DataTables::of($sto->limit(10))->make(true);
        };
        return view('staff.hasil-sto', ['title' => 'Data Hasil STO']);
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
