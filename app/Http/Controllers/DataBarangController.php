<?php

namespace App\Http\Controllers;

use App\Exports\DataBarangExport;
use App\Models\DataBarang;
use App\Http\Requests\StoreDataBarangRequest;
use App\Http\Requests\UpdateDataBarangRequest;
use App\Imports\DataBarangImport;
use App\Models\Barang;
use App\Models\Lokasi;
use App\Models\Perubahan;
use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class DataBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check() && Auth::user()->role === 'user' || Auth::user()->role === 'admin') {
            if (request()->ajax()) {
                $barangs = Barang::with('dataBarang.lokasi')->get();

                $barangs->map(function ($barang, $key) {
                    $barang['DT_RowIndex'] = $key + 1;
                    $totalQty = $barang->dataBarang->sum(function ($dataBarang) {
                        return $dataBarang->lokasi->where('nama', 'GUDANG PRODUKSI')->sum('pivot.qty');
                    });
                    
                    if (auth()->user()->role === 'user') {
                        $requestedQty = $barang->requested_qty;
                        $adjustedQty = $totalQty - $requestedQty;
                        $barang['total_qty'] = $adjustedQty < 0 ? 0 : $adjustedQty;

                        $total_on_loc = $barang->dataBarang->sum(function ($dataBarang) {
                            return $dataBarang->lokasi->where('id', auth()->user()->lokasi_id)->sum('pivot.qty');
                        });

                        $barang['qty_on_loc'] = $total_on_loc < 0 ? 0 : $total_on_loc;
                    } else {
                        $barang['total_qty'] = $totalQty;
                    }
                    
                    return $barang;
                });

                return datatables()->of($barangs)->make(true);
            } if (Auth::check() && Auth::user()->role === 'user'){
                return view('user.home-user', [
                    'title' => 'Dashboard',
                ]);
            } else if (Auth::check() && Auth::user()->role === 'admin'){
                return view('staff.barang-gudang', [
                    'title' => 'Barang Gudang',
                ]);
            }
        } else if (Auth::check() && Auth::user()->role === 'spv') {
            if(request()->ajax()){
                $barang = DataBarang::with('lokasi', 'barang')->orderBy('kode_js', 'asc')->get();
    
                $barang->map(function ($item, $key) {
                    $item['DT_RowIndex'] = $key + 1;
                    return $item;
                });

                $barang->each(function ($item) {
                    $totalQty = 0;
            
                    foreach ($item->lokasi as $lokasi) {
                        $totalQty += $lokasi->pivot->qty;
                    }
            
                    $item->total_qty = $totalQty;
                });
    
                return DataTables::of($barang)->make(true);
            }
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
    public function store(Request $request)
    {
        $lokasi = auth()->user()->lokasi_id;

        $barang = DataBarang::create([
            'kode_js' => $request->kodejs,
            'inv_number' => $request->inv_number,
            'PO_number' => $request->PO_number,
        ]);

        $cekBarang = Barang::where('kode_js', $request->kodejs)->first();

        $totalQty = $cekBarang->dataBarang->sum(function ($dataBarang) use ($lokasi) {
            return $dataBarang->lokasi->where('id', $lokasi)->sum('pivot.qty');
        });

        $barang->lokasi()->attach($lokasi, ['qty' => $request->qty]);

        $barang->save();

        Perubahan::create([
            'data_barang_id' => $barang->id,
            'lokasi_awal_id' => null,
            'lokasi_akhir_id' => $lokasi,
            'remark' => "Barang Masuk",
            'qty' => $request->qty,
            'qty_awal' => $totalQty,
            'qty_akhir' => $totalQty + $request->qty,
        ]);

        alert()->success('Success', 'Stok Berhasil Ditambahkan');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        if (request()->ajax()) {
            $barangs = Barang::whereHas('dataBarang.lokasi', function ($query) {
                $query->where('id', auth()->user()->lokasi_id);
            })->with('dataBarang.lokasi')->get();
        
            $barangs->map(function ($barang, $key) {
                $barang['DT_RowIndex'] = $key + 1;
                $barang['total_qty'] = $barang->dataBarang->sum(function ($dataBarang) {
                    return $dataBarang->lokasi->where('id', auth()->user()->lokasi_id)->sum('pivot.qty');
                });
                return $barang;
            });
        
            return datatables()->of($barangs)->make(true);
        }
        
        return view('user.data-barang', [
            'title' => 'Data Barang',
            'lokasi' => Lokasi::where('id', auth()->user()->lokasi_id)->pluck('nama')->first()
        ]);
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

    public function getLokasiQty()
    {
        $barang = Barang::where('nama', request('nama'))->firstOrFail();
        $lokasiQuantities = [];

        foreach ($barang->dataBarang as $dataBarang) {
            foreach ($dataBarang->lokasi as $lokasi) {
                $lokasiName = $lokasi->nama;
                $qty = $lokasi->pivot->qty;

                if (!isset($lokasiQuantities[$lokasiName])) {
                    $lokasiQuantities[$lokasiName] = 0;
                }

                $lokasiQuantities[$lokasiName] += $qty;
            }
        }

        $data = [];
        $index = 1;
        foreach ($lokasiQuantities as $location => $quantity) {
            $data[] = [
                'DT_RowIndex' => $index++,
                'lokasi' => $location,
                'total_qty' => $quantity
            ];
        }

        return datatables()->of($data)->make(true);
    }

    public function tes(){
        $lokasiId = 1;
        $barang_id = 2;
        $pesanan = DataBarang::with('barang', 'lokasi')->get();

        $pesanan->each(function ($item) {
            $totalQty = 0;
    
            foreach ($item->lokasi as $lokasi) {
                $totalQty += $lokasi->pivot->qty;
            }
    
            $item->total_qty = $totalQty;
        });

        $dataBarang = DataBarang::whereHas('lokasi', function ($query) use ($lokasiId) {
            $query->where('lokasi_id', $lokasiId);
        })->with(['barang', 'lokasi' => function ($query) use ($lokasiId) {
            $query->where('lokasi_id', $lokasiId);
        }])->get();
    
        $dataBarang->each(function ($item) use ($lokasiId) {
            $item->qty = $item->lokasi->firstWhere('id', $lokasiId)->pivot->qty;
        });

        $lokasi = Lokasi::whereHas('dataBarang', function ($query) use ($barang_id) {
            $query->where('id', $barang_id);
        })->with(['dataBarang' => function ($query) use ($barang_id) {
            $query->where('id', $barang_id);
        }])->get();

        $pesanan = Pesanan::with('user.lokasi', 'barang')->get();
        // $pesanan = Barang::whereHas('pesanan', function ($query) use ($lokasiId) {
        //     $query->where('id', $lokasiId);
        // })->get();
        return response()->json($dataBarang);
    }

    public function add(Request $request)
    {
        $lokasi = $request->input('lokasi');

        $barang = DataBarang::create([
            'kode_js' => $request->kodejs,
            'inv_number' => $request->inv_number,
            'PO_number' => $request->PO_number,
        ]);

        $cekBarang = Barang::where('kode_js', $request->kodejs)->first();

        $totalQty = $cekBarang->dataBarang->sum(function ($dataBarang) use ($lokasi) {
            return $dataBarang->lokasi->where('id', $lokasi)->sum('pivot.qty');
        });

        $barang->lokasi()->attach($lokasi, ['qty' => $request->qty]);

        $barang->save();

        Perubahan::create([
            'data_barang_id' => $barang->id,
            'lokasi_awal_id' => null,
            'lokasi_akhir_id' => $lokasi,
            'remark' => "Barang Masuk",
            'qty' => $request->qty,
            'qty_awal' => $totalQty,
            'qty_akhir' => $totalQty + $request->qty
        ]);

        toast()->success('Stok Berhasil ditambahkan');
        return redirect()->back();
    }

    public function mutasi(Request $request){
        $barang = Barang::where('kode_js', $request->input('kodejsMutasi'))->firstOrFail();
        $lokasiAwal = $request->input('lokasiMutasi');
        $lokasiAkhir = $request->input('lokasiAkhir');
        $qty = $request->input('qtyMutasi');
        $remark = $request->input('remark') !== "Other" ? $request->input('remark') : $request->input('otherRemark');

        $barang->moveToLocation($lokasiAwal, $lokasiAkhir, $qty, $remark);

        toast()->success('Mutasi Berhasil');
        return redirect()->back();
    }

    public function export(Request $request)
    {
        $today = Carbon::now()->format('d-m-Y');
        if ($request->filled('lokasi')){
            $lokasi = $request->input('lokasi');
            return Excel::download(new DataBarangExport($lokasi), 'Data-Barang-Gudang '. $today .' .xlsx');
        } else{
            return Excel::download(new DataBarangExport(null), 'Data-Barang '. $today .'.xlsx');
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
        
        $importer = new DataBarangImport();
        $importResult = $importer->import(request()->file('file'));

        if ($importResult['skipped_rows'] == null) {
            alert()->success('Success', $importResult['imported_count'] . ' Data Berhasil Ditambah');

            return redirect()->back()->with('success', 'Wire loss data imported successfully.')
                ->with('imported_count', $importResult['imported_count'])
                ->with('skipped_rows', $importResult['skipped_rows']);
        } else {
            $importedCount = $importResult['imported_count'];
            $skippedRowCount = count($importResult['skipped_rows']);

            $emptyColumns = [];
            $emptyRows = [];
            foreach ($importResult['skipped_rows'] as $skippedRow) {
                $emptyRows[] = $skippedRow['row'];
                $emptyColumns = array_merge($emptyColumns, $skippedRow['empty_columns']);
            }

            // $uniqueEmptyColumns = array_unique($emptyColumns);

            $errorMessage = $importedCount . ' Data Tersimpan, ' . $skippedRowCount . ' Data Gagal Ditambahkan';
            // if (!empty($uniqueEmptyColumns)) {
            //     $errorMessage .= ', Kolom kosong: ' . implode(', ', $uniqueEmptyColumns);
            // }
            if (!empty($emptyRows)) {
                $errorMessage .= ', Baris kosong: ' . implode(', ', $emptyRows);
            }

            alert()->error('Error', $errorMessage)->persistent(true);

            return redirect()->back()->with('error', $errorMessage);
        }
    }

    public function tes_data(){
        $lokasiId = 1;
        $dataBarang = DataBarang::whereHas('lokasi', function ($query) use ($lokasiId) {
            $query->where('lokasi_id', $lokasiId);
        })->with(['barang', 'lokasi' => function ($query) use ($lokasiId) {
            $query->where('lokasi_id', $lokasiId);
        }])->get();
    
        $dataBarang->each(function ($item) use ($lokasiId) {
            $item->qty = $item->lokasi->firstWhere('id', $lokasiId)->pivot->qty;
        });

        return response()->json($dataBarang);
    }

}
