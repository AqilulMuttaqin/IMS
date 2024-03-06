<?php

namespace App\Http\Controllers;

use App\Models\SPV;
use App\Http\Requests\StoreSPVRequest;
use App\Http\Requests\UpdateSPVRequest;
use App\Models\Barang;
use App\Models\Lokasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isEmpty;

class SPVController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('spv.dashboard', ['title' => 'Dashboard']);
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
    public function store(StoreSPVRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SPV $sPV)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SPV $sPV)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSPVRequest $request, SPV $sPV)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SPV $sPV)
    {
        //
    }

    public function show_user(){
        $lokasi = Lokasi::all();
        if(request()->ajax()){
            $user = User::with('lokasi')->get();
            $user->map(function ($item, $key) {
                $item['DT_RowIndex'] = $key + 1;
                return $item;
            });

            return datatables()->of($user)->make(true);
        }

        return view('spv.user', [
            'lokasi' => $lokasi,
            'title' => 'Data User'
        ]);
    }

    public function add_user(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'NIK' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|string',
        ]);

        $user = User::create([
            'NIK' => $request->input('NIK'),
            'name' => $request->input('name'),
            'password' => Hash::make($request->input('password'),),
            'pw' => $request->input('password'),
            'role' => $request->input('role'),
        ]);

        if (!empty($request->input('lokasi'))) {
            $user->lokasi_id = $request->input('lokasi');
            $user->save();
        }
    }

    public function update_user(Request $request, $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where('NIK', $user)->first();

        if (!$user) {
            return redirect()->route('admin.data-user')->with('error', 'User not found');
        }

        $userData = [
            'name' => $request->input('name'),
            'role' => $request->input('role'),
            'password' => Hash::make($request->input('password')),
            'pw' => $request->input('password'),
        ];

        if (!empty($request->input('lokasi'))) {
            $userData['lokasi_id'] = $request->input('lokasi');
        }

        $user->update($userData);

        // return redirect()->route('admin.data-user')->with('success', 'User updated successfully');
    }


    public function delete_user($user){
        $user = User::where('NIK', $user)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        $user->delete();

        alert()->success('Deleted!', 'Data Berhasil dihapus');
        return redirect()->back();
    }

    public function update_stok(){
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

        return view('spv.control-barang', ['title' => 'Control Barang']);
    }

    public function get_barang(){
        if (request()->ajax()) {
            $barang = [];

            if(request()->has('q')){
                $search = request()->q;
                $barang =Barang::select("kode_js", "nama")
                        ->where('nama', 'LIKE', "%$search%")
                        ->whereHas('dataBarang.lokasi', function ($query) {
                            $query->where('id', request('lokasi'));
                        })
                        ->get();
            }
            return response()->json($barang);
        }
    }

    public function get_lokasi(){
        $lokasi = [];

        if(request()->has('q')){
            $search = request()->q;
            $lokasi =Lokasi::select("id", "nama")
                    ->where('nama', 'LIKE', "%$search%")
                    ->get();
        }
        return response()->json($lokasi);
    }

    public function get_qty(){
        $barang = Barang::where('kode_js', request('kode_js'))
            ->with(['dataBarang.lokasi' => function ($query) {
                $query->where('id', request('lokasi'));
            }])
            ->first();

        $totalQty = 0;
        if ($barang) {
            foreach ($barang->dataBarang as $dataBarang) {
                foreach ($dataBarang->lokasi as $lokasi) {
                    if ($lokasi->id == request('lokasi')) {
                        $totalQty += $lokasi->pivot->qty;
                    }
                }
            }
        }

        return response()->json($totalQty);
    }
}
