<?php

namespace App\Http\Controllers;

use App\Models\TokenCounter;
use App\Http\Requests\StoreTokenCounterRequest;
use App\Http\Requests\UpdateTokenCounterRequest;

class TokenCounterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreTokenCounterRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TokenCounter $tokenCounter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TokenCounter $tokenCounter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTokenCounterRequest $request, TokenCounter $tokenCounter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TokenCounter $tokenCounter)
    {
        //
    }
}
