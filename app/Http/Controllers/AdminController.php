<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Pesanan;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pending = Pesanan::where('status', 'pending')->count();
        $disiapkan = Pesanan::where('status', 'disiapkan')->count();
        $dikirim = Pesanan::where('status', 'dikirim')->count();

        if (request()->ajax()) {
            $status = request('status');
            $counts = [
                'pending' => Pesanan::where('status', 'pending')->count(),
                'disiapkan' => Pesanan::where('status', 'disiapkan')->count(),
                'dikirim' => Pesanan::where('status', 'dikirim')->count(),
            ];
            
            switch ($status) {
                case 'pending':
                    $pesanan = Pesanan::with('user.lokasi', 'barang')->where('status', 'pending')->get();
                    break;
                case 'disiapkan':
                    $pesanan = Pesanan::with('user.lokasi', 'barang')->where('status', 'disiapkan')->get();
                    break;
                case 'dikirim':
                    $pesanan = Pesanan::with('user.lokasi', 'barang')->where('status', 'dikirim')->get();
                    break;
                default:
                    return response()->json([]);
            }
    
            return response()->json(['pesanan' => $pesanan, 'counts' => $counts]);
        }

        return view('staff.dashboard', 
        [
            'title' => 'Dashboard',
            'pending' => $pending,
            'disiapkan' => $disiapkan,
            'dikirim' => $dikirim
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
    public function store(StoreAdminRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }

    public function pesanan()
    {
        return view('staff.pesanan', ['title' => 'Pesanan']);
    }

    public function stok()
    {
        return view('admin.stok');
    }

    public function updateStok()
    {
        return view('staff.update-stok', ['title' => 'Update Stok']);
    }

    public function barang()
    {
        return view('staff.data-barang', ['title' => 'Data Barang']);
    }

}
