<?php

namespace App\Http\Controllers;

use App\Exports\LokasiExport;
use App\Models\Lokasi;
use App\Http\Requests\StoreLokasiRequest;
use App\Http\Requests\UpdateLokasiRequest;
use App\Imports\LokasiImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
            'nama' => 'required|unique:lokasi,nama',
        ]);

        Lokasi::create($request->all());
        alert()->success('SuccessAlert','Lorem ipsum dolor sit amet.');
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
            'nama' => 'required|unique:lokasi,nama,'.$id,
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
        if (!$lokasi) {
            return redirect()->back()->with('error', 'User not found');
        }

        $lokasi->delete();
    }

    public function export()
    {
        return Excel::download(new LokasiExport, 'Lokasi.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
        
        $importer = new LokasiImport();
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
}
