<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Http\Requests\StorePesananRequest;
use App\Http\Requests\UpdatePesananRequest;
use App\Models\Barang;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()){
            $pesanan = Pesanan::with('user', 'barang')->get();

            $pesanan->map(function ($item, $key) {
                $item['DT_RowIndex'] = $key + 1;
                return $item;
            });

            return datatables()->of($pesanan)->make(true);
        };

        return view('staff.pesanan', ['title' => 'Pesanan']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userKeranjang = Keranjang::where('user_id', auth()->id())->firstOrFail();

        $pesanan = new Pesanan();
        $pesanan->user_id = auth()->id();
        $pesanan->save();

        $userKeranjang->barang()->each(function ($barang) use ($pesanan) {
            $qty = $barang->pivot->qty;
            Log::info('check qty.'.$qty.' barang id.'.$barang->kode_js.' pesanan id.'.$pesanan->id.' user id.'.$pesanan->user_id.'.');
            $pesanan->barang()->attach($barang->kode_js, ['qty' => $qty]);
        });

        $userKeranjang->delete();

        alert()->success('Pesanan berhasil dibuat, silahkan tunggu konfirmasi', 'Berhasil');
        //return response()->json($pesanan);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePesananRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pesanan $pesanan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pesanan $pesanan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePesananRequest $request, Pesanan $pesanan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pesanan $pesanan)
    {
        //
    }

    public function detail(Request $request) {
        // $pesanan = Barang::whereHas('pesanan', function ($query) use ($id) {
        //     $query->where('id', $id);});
        $pesanan = Pesanan::with('barang', 'user')->where('id', $request->input('pesanan_id'))->first();
        return response()->json($pesanan);
    }
}
