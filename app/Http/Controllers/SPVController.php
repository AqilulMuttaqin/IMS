<?php

namespace App\Http\Controllers;

use App\Models\SPV;
use App\Http\Requests\StoreSPVRequest;
use App\Http\Requests\UpdateSPVRequest;

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
}
