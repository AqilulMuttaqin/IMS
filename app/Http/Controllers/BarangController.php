<?php

namespace App\Http\Controllers;

use App\Exports\BarangExport;
use App\Exports\FormatBarangImport;
use App\Models\Barang;
use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use App\Imports\BarangImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            // $barang = Barang::all();

            // $barang->map(function ($item, $key) {
            //     $item['DT_RowIndex'] = $key + 1;
            //     return $item;
            // });

            // return datatables()->of($barang)->make(true);
            $barangs = Barang::with('dataBarang.lokasi')->get();

            $barangs->map(function ($barang, $key) {
                $barang['DT_RowIndex'] = $key + 1;
                $totalQty = $barang->dataBarang->sum(function ($dataBarang) {
                    return $dataBarang->lokasi->sum('pivot.qty');
                });
                $totalQtyGudang = $barang->dataBarang->sum(function ($dataBarang) {
                    return $dataBarang->lokasi->where('nama', 'GUDANG PRODUKSI')->sum('pivot.qty');
                });

                $barang['total_qty'] = max(0, $totalQty);
                $barang['total_qty_gudang'] = $totalQtyGudang;

                return $barang;
            });

            return datatables()->of($barangs)->make(true);
        }
        if (Auth::check() && Auth::user()->role === 'spv') {
            return view('spv.master-barang', [
                'title' => 'Data Master Barang'
            ]);
        } else if (Auth::check() && Auth::user()->role === 'admin') {
            return view('staff.data-barang', [
                'title' => 'Data Master Barang',
            ]);
        }
    }

    public function stok()
    {
        if (request()->ajax()) {
            $barangs = Barang::with('dataBarang.lokasi')->get();

            $barangs->map(function ($barang, $key) {
                $barang['DT_RowIndex'] = $key + 1;
                $totalQty = $barang->dataBarang->sum(function ($dataBarang) {
                    return $dataBarang->lokasi->sum('pivot.qty');
                });
                $totalQtyGudang = $barang->dataBarang->sum(function ($dataBarang) {
                    return $dataBarang->lokasi->where('nama', 'GUDANG PRODUKSI')->sum('pivot.qty');
                });

                $barang['total_qty'] = max(0, $totalQty);
                $barang['total_qty_gudang'] = $totalQtyGudang;

                return $barang;
            });

            return datatables()->of($barangs)->make(true);
        }
        return view('spv.level-stok', [
            'title' => 'Data Stok Barang'
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
        return redirect()->back();
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
    public function update(Request $request, $kode_js)
    {
        request()->validate([
            'kode_js' => 'required',
            'nama' => 'required',
            'harga' => 'required',
            'min_stok' => 'required',
            'max_stok' => 'required',
            'kategori' => 'required',
            'satuan' => 'required'
        ]);

        $barang = Barang::find($kode_js);
        $barang->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        $barang->delete();
    }

    public function export()
    {
        return Excel::download(new BarangExport, 'barang.xlsx');
    }

    public function import_format()
    {
        return Excel::download(new FormatBarangImport, 'Format Input Master Barang.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
        
        $importer = new BarangImport();
        $importResult = $importer->import(request()->file('file'));

        if ($importResult['skipped_rows'] == null) {
            //alert()->success('Success', $importResult['imported_count'] . ' Data Berhasil Ditambah');

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

            //alert()->error('Error', $errorMessage)->persistent(true);

            return redirect()->back()->with('error', $errorMessage);
        }
    }
}
