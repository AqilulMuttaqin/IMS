<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Http\Requests\StoreKeranjangRequest;
use App\Http\Requests\UpdateKeranjangRequest;
use App\Models\Barang;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()){
            $action = request('action');
            switch ($action) {
                case 'keranjang':
                    $keranjang = Keranjang::with('barang')->where('user_id', auth()->user()->id)->first();
                    break;
                case 'add':
                    $user = auth()->user();
                    $keranjang = $user->keranjang()->firstOrCreate([]);
                    $barang = Barang::where('kode_js', request('kode_js'))->firstOrFail();
                    $keranjang->barang()->attach($barang->kode_js, ['qty' => request('qty'), 'keterangan' => request('keterangan')]);
                    break;
                case 'delete':
                    $user = auth()->user();
                    $keranjang = $user->keranjang()->firstOrFail();

                    $keranjang->barang()->detach(request('kode_js'));

                    $keranjang = Keranjang::with('barang')->where('user_id', auth()->user()->id)->first();
                    break;
                case 'update':
                    $user = auth()->user();
                    $keranjang = $user->keranjang()->firstOrFail();

                    $keranjang->barang()->updateExistingPivot(request('kode_js'), ['qty' => request('qty')]);
                    break;
                case 'update-keterangan':
                    $user = auth()->user();
                    $keranjang = $user->keranjang()->firstOrFail();

                    $keranjang->barang()->updateExistingPivot(request('kode_js'), ['keterangan' => request('keterangan')]);
                    break;
                default:
                    return response()->json([]);
            }

            return response()->json($keranjang);

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
    public function store(Request $request)
    {
        $user = auth()->user();
        
        $keranjang = $user->keranjang()->firstOrCreate([]);

        $barang = Barang::where('kode_js', $request->kode_js)->firstOrFail();

        $keranjang->barang()->attach($barang->kode_js, ['qty' => $request->qty]);

        return response()->json(['message' => 'Barang appended to keranjang successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Keranjang $keranjang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Keranjang $keranjang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKeranjangRequest $request, Keranjang $keranjang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keranjang $keranjang)
    {
        //
    }
}
