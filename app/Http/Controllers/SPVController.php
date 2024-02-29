<?php

namespace App\Http\Controllers;

use App\Models\SPV;
use App\Http\Requests\StoreSPVRequest;
use App\Http\Requests\UpdateSPVRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        if(request()->ajax()){
            $user = User::all();
            $user->map(function ($item, $key) {
                $item['DT_RowIndex'] = $key + 1;
                return $item;
            });

            return datatables()->of($user)->make(true);
        }

        return view('spv.user', [
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

        alert()->success('Success', 'Data Berhasil Ditambahkan');

    }

    public function update_user(Request $request, $user){

        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where('NIK', $user)->first();

        if (!$user) {
            return redirect()->route('admin.data-user')->with('error', 'User not found');
        }

        $user->update([
            'name' => $request->input('name'),
            'role' => $request->input('role'),
            'password' => Hash::make($request->input('password'),),
            'pw' => $request->input('password'),
        ]);

        alert()->success('Success', 'Data Berhasil Diedit');
    }

    public function delete_user($user){
        $user = User::where('NIK', $user)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        $user->delete();

        alert()->success('Success', 'Data Berhasil Dihapus');

        return redirect()->back();
    }
}
