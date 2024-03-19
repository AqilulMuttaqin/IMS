<?php

namespace App\Http\Controllers;

use App\Exports\PerubahanExport;
use App\Models\Perubahan;
use App\Http\Requests\StorePerubahanRequest;
use App\Http\Requests\UpdatePerubahanRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PerubahanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()){
            $perubahan = Perubahan::with('data_barang.barang', 'lokasi_awal', 'lokasi_akhir');

            if(request()->filled('start_date') && request()->filled('end_date')){
                $start_date = Carbon::parse(request('start_date'))->startOfDay();
                $end_date = Carbon::parse(request('end_date'))->endOfDay();
                $perubahan = $perubahan->whereBetween('created_at', [$start_date, $end_date]);
            }

            return datatables()->of($perubahan->limit(10))->make(true);
        }
        
        return view('spv.in-out', ['title' => 'In-Out Barang']);
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
    public function store(StorePerubahanRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Perubahan $perubahan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Perubahan $perubahan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePerubahanRequest $request, Perubahan $perubahan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Perubahan $perubahan)
    {
        //
    }

    public function export(Request $request)
    {
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $filename = 'Histori Perubahan Barang ' . Carbon::parse($start_date)->format('d-m-Y') . ' sampai ' . Carbon::parse($end_date)->format('d-m-Y') . '.xlsx';
            
            $export = new PerubahanExport($start_date, $end_date);
            
            return Excel::download($export, $filename);
            
        } else {
            $filename = 'Histori Perubahan Barang.xlsx';
            $export = new PerubahanExport(null, null);
            
            return Excel::download($export, $filename);
        }
    }
}
