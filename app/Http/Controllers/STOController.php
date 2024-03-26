<?php

namespace App\Http\Controllers;

use App\Exports\STOExport;
use App\Models\STO;
use App\Http\Requests\StoreSTORequest;
use App\Http\Requests\UpdateSTORequest;
use App\Models\Barang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
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

        if (Auth::check() && Auth::user()->role === 'admin'){
            return view('staff.input-sto', ['title' => 'Input Data STO']);
        } else if (Auth::check() && Auth::user()->role === 'user'){
            return view('user.input-sto', ['title' => 'Input Data STO']);
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
        $request->validate([
            'kode_js' => 'required',
            'qty' => 'required|numeric'
        ]);

        
        $kodeJs = $request->kode_js;
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $totalQty = Barang::where('kode_js', $kodeJs)
            ->with('dataBarang.lokasi')
            ->first()
            ->dataBarang->where('kode_js', $kodeJs)
            ->sum(function ($dataBarang) {
                return $dataBarang->lokasi->where('nama', 'GUDANG PRODUKSI')->first()->pivot->qty ?? 0;
            });

        $existingSto = STO::where('kode_js', $kodeJs)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->first();

        if ($existingSto) {
            $existingSto->update([
            'qty' => $totalQty,
            'actual_qty' => $request->qty
            ]);

            alert()->success('Success', 'Data Stok Diperbaharui');
        } else {
            STO::create([
            'kode_js' => $kodeJs,
            'qty' => $totalQty,
            'actual_qty' => $request->qty
            ]);

            alert()->success('Success', 'Data Berhasil Ditambahkan');
        }
    }

    public function show()
    {
        if(request()->ajax()){
            $sto = STO::with('barang');

            if(request()->filled('date')){
                list($selectedYear, $selectedMonth) = explode('-', request()->date);

                $sto->whereYear('created_at', $selectedYear)
                    ->whereMonth('created_at', $selectedMonth);
            }

            return DataTables::of($sto->limit(10))->make(true);
        };

        $currentMonth = Carbon::now()->format('Y-m');
        
        if (Auth::check() && Auth::user()->role === 'admin'){
            return view('staff.hasil-sto', [
                'bulan' => $currentMonth,
                'title' => 'Data Hasil STO']);
        } else if (Auth::check() && Auth::user()->role === 'user'){
            return view('user.hasil-sto', [
                'bulan' => $currentMonth,
                'title' => 'Data Hasil STO']);    
        }
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

    public function export(Request $request){
        if ($request->filled('start_date')) {
            $start_date = $request->input('start_date');
            $filename = 'STO Gudang (' . Carbon::parse($start_date)->format('d-m-Y'). ').xlsx';

            $export = new STOExport($start_date);
            
            return Excel::download($export, $filename);
        }
    }
}
