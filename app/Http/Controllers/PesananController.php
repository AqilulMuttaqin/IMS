<?php

namespace App\Http\Controllers;

use App\Exports\HistoryPesananExport;
use App\Models\Pesanan;
use App\Http\Requests\StorePesananRequest;
use App\Http\Requests\UpdatePesananRequest;
use App\Models\Barang;
use App\Models\BarangPesanan;
use App\Models\Keranjang;
use App\Models\Lokasi;
use App\Models\TokenCounter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $today = Carbon::now()->toDateString();
        if(request()->ajax()){
            $pesanan = Pesanan::with('user', 'barang', 'lokasi');

            if (auth()->user()->role === 'admin') {
                $pesanan = $pesanan->orderby('created_at', 'desc')->get();
            } else if (auth()->user()->role === 'user') {
                $pesanan = $pesanan->where('user_id', auth()->id())->orderby('created_at', 'desc')->get();
            } else if (auth()->user()->role === 'spv') {
                $start_date = Carbon::parse(request('start_date'))->startOfDay();
                $end_date = Carbon::parse(request('end_date'))->endOfDay();
                $pesanan = $pesanan->whereBetween('updated_at', [$start_date, $end_date])->where('status', 'selesai')->orderby('created_at', 'asc')->get();
            }

            $pesanan->map(function ($item, $key) {
                $item['DT_RowIndex'] = $key + 1;
                return $item;
            });

            return datatables()->of($pesanan)->make(true);
        };

        if (auth()->user()->role === 'admin') {
            return view('staff.pesanan', ['title' => 'Pesanan']);
        } else if (auth()->user()->role === 'user') {
            return view('user.pesanan', ['title' => 'Pesanan']);
        } else if (auth()->user()->role === 'spv') {
            return view('spv.history-pesanan', ['title' => 'History Pesanan', 'today' => $today]);
        }
    }

    public function historyPesanan()
    {
        $today = Carbon::now()->toDateString();
        if(request()->ajax()){
            $start_date = Carbon::parse(request('start_date'))->startOfDay();
            $end_date = Carbon::parse(request('end_date'))->endOfDay();
            $barangPesanan = BarangPesanan::with('barang', 'pesanan', 'pesanan.user', 'pesanan.lokasi')
                ->whereHas('pesanan', function ($query) use ($start_date, $end_date) {
                    $query->whereBetween('updated_at', [$start_date, $end_date])->where('status', 'selesai')->orderBy('created_at', 'asc');
                })->get();
                
            $barangPesanan->map(function ($item, $key) {
                $item['DT_RowIndex'] = $key + 1;
                return $item;
            });
                
            return datatables()->of($barangPesanan)->make(true);
        }
            
        return view('spv.history-pesanan', ['title' => 'History Pesanan', 'today' => $today]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userKeranjang = Keranjang::where('user_id', auth()->id())->firstOrFail();

        $pesanan = new Pesanan();
        $pesanan->user_id = auth()->id();
        $pesanan->lokasi_id = auth()->user()->lokasi_id;
        $pesanan->kode_pesanan = $this->generateUniqueID();
        $pesanan->save();

        $userKeranjang->barang()->each(function ($barang) use ($pesanan) {
            $qty = $barang->pivot->qty;
            $pesanan->barang()->attach($barang->kode_js, ['qty' => $qty, 'keterangan' => $barang->pivot->keterangan]);

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
            'qty' => 'required',
            'keterangan' => 'required'
        ]);

        $pesanan = new Pesanan();
        $pesanan->user_id = auth()->id();
        $pesanan->lokasi_id = auth()->user()->lokasi_id;
        $pesanan->kode_pesanan = $this->generateUniqueID();
        $pesanan->save();
        
        $pesanan->barang()->attach($request->input('kode_js'), ['qty' => $request->input('qty'), 'keterangan' => $request->input('keterangan')]);

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
        if(request()->ajax()){
            $action = request('action');
            switch ($action) {
                case 'delete':
                    $pesanan = Pesanan::where('id', request('pesanan'))->firstOrFail();

                    $barang = $pesanan->barang()->where('barang.kode_js', request('kode_js'))->first();
                    if ($barang) {
                        $barang->update(['requested_qty' => $barang->requested_qty - $barang->pivot->qty]);
                    }
                    $pesanan->barang()->detach(request('kode_js'));

                    $pesanan = Pesanan::with('barang')->where('id', request('pesanan'))->first();
                    break;
                case 'update':
                    $pesanan = Pesanan::where('id', request('pesanan'))->firstOrFail();

                    $existingQty = $pesanan->barang()->where('barang.kode_js', request('kode_js'))->first()->pivot->qty;

                    $pesanan->barang()->updateExistingPivot(request('kode_js'), ['qty' => request('qty')]);

                    $qtyDifference = request('qty') - $existingQty;

                    $barang = Barang::where('kode_js', request('kode_js'))->first();
                    if ($barang) {
                        $barang->update(['requested_qty' => $barang->requested_qty + $qtyDifference]);
                    }
                    break;
                case 'update-keterangan':
                    $pesanan = Pesanan::where('id', request('pesanan'))->firstOrFail();

                    $pesanan->barang()->updateExistingPivot(request('kode_js'), ['keterangan' => request('keterangan')]);
                    break;
                case 'catatan':
                    $pesanan = Pesanan::where('id', request('pesanan'))->firstOrFail();

                    $pesanan->update(['catatan' => request('catatan')]);

                    $pesanan->save();
                    break;
                default:
                    return response()->json([]);
            }

            return response()->json($pesanan);

        }
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

        if ($request->status === 'ditolak') {
            $pesanan->barang->each(function ($barang) {
                $barang->update(['requested_qty' => $barang->requested_qty - $barang->pivot->qty]);
            });
        };

        $oldStatus = $pesanan->status;

        $pesanan->update(['status' => $request->status]);

        if ($pesanan->status === 'terkirim' || $pesanan->status === 'selesai' && $oldStatus !== 'terkirim') {
            $lokasiAkhir = $pesanan->lokasi_id;
            
            $pesanan->barang->each(function ($barang) use ($lokasiAkhir){
                $lokasiAwal = '1';
                $qty = $barang->pivot->qty;
                $remark = $barang->pivot->keterangan;
                $barang->moveToLocation($lokasiAwal, $lokasiAkhir, $qty, $remark);
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
        $pesanan = Pesanan::with('barang', 'user', 'lokasi')->where('id', $request->input('pesanan_id'))->first();
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

    public function exportHistory (Request $request) {
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $filename = 'History Pesanan Selesai (' . Carbon::parse($start_date)->format('d-m-Y') . ' - ' . Carbon::parse($end_date)->format('d-m-Y') . ').xlsx';

            $export = new HistoryPesananExport($start_date, $end_date);
            
            return Excel::download($export, $filename);
        }
    }

}
