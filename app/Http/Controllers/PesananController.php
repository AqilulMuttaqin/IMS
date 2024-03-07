<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Http\Requests\StorePesananRequest;
use App\Http\Requests\UpdatePesananRequest;
use App\Models\Barang;
use App\Models\Keranjang;
use App\Models\TokenCounter;
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
            $pesanan = Pesanan::with('user', 'barang');

            if (auth()->user()->role === 'admin') {
                $pesanan = $pesanan->get();
            } elseif (auth()->user()->role === 'user') {
                $pesanan = $pesanan->where('user_id', auth()->id())->orderby('created_at', 'desc')->get();
            }

            $pesanan->map(function ($item, $key) {
                $item['DT_RowIndex'] = $key + 1;
                return $item;
            });

            return datatables()->of($pesanan)->make(true);
        };

        if (auth()->user()->role === 'admin') {
            return view('staff.pesanan', ['title' => 'Pesanan']);
        } elseif (auth()->user()->role === 'user') {
            return view('user.pesanan', ['title' => 'Pesanan']);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userKeranjang = Keranjang::where('user_id', auth()->id())->firstOrFail();

        $pesanan = new Pesanan();
        $pesanan->user_id = auth()->id();
        $pesanan->kode_pesanan = $this->generateUniqueID();
        $pesanan->save();

        $userKeranjang->barang()->each(function ($barang) use ($pesanan) {
            $qty = $barang->pivot->qty;
            $pesanan->barang()->attach($barang->kode_js, ['qty' => $qty]);

            $barang->update(['requested_qty' => $barang->requested_qty + $qty]);
        });

        $userKeranjang->delete();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_js' => 'required',
            'qty' => 'required'
        ]);

        $pesanan = new Pesanan();
        $pesanan->user_id = auth()->id();
        $pesanan->kode_pesanan = $this->generateUniqueID();
        $pesanan->save();
        
        $pesanan->barang()->attach($request->input('kode_js'), ['qty' => $request->input('qty')]);

        $barang = Barang::where('kode_js', $request->input('kode_js'))->firstOrFail();
        $barang->update(['requested_qty' => $barang->requested_qty + $request->input('qty')]);
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
    public function update(Request $request)
    {
        $request->validate([
            'pesanan_id' => 'required',
            'status' => 'required'
        ]);
        $pesanan = Pesanan::findOrFail($request->pesanan_id);

        if ($request->status === 'batal') {
            $pesanan->barang->each(function ($barang) {
                $barang->update(['requested_qty' => $barang->requested_qty - $barang->pivot->qty]);
            });
            $pesanan->delete();
        };

        $pesanan->update(['status' => $request->status]);

        if ($pesanan->status === 'terkirim' || $pesanan->status === 'selesai') {
            $lokasiAkhir = $pesanan->user->lokasi_id;
            
            $pesanan->barang->each(function ($barang) use ($lokasiAkhir){
                $lokasiAwal = '1';
                $qty = $barang->pivot->qty;
                $barang->moveToLocation($lokasiAwal, $lokasiAkhir, $qty);
                $barang->update(['requested_qty' => $barang->requested_qty - $qty]);
            });
        }

        return response()->json(['status' => 'success']);
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

    function generateUniqueID() {
        $currentDate = date('ymd');
    
        $tokenCounter = TokenCounter::where('date', $currentDate)->first();
    
        if (!$tokenCounter) {
            $tokenCounter = TokenCounter::create([
                'date' => $currentDate,
                'counter' => 1
            ]);
        } else {
            $tokenCounter->increment('counter');
        }
    
        $formattedCounter = str_pad($tokenCounter->counter, 4, '0', STR_PAD_LEFT);
    
        $uniqueID = 'SIMS-' . $currentDate . '-' . $formattedCounter;
    
        return $uniqueID;
    }

}
