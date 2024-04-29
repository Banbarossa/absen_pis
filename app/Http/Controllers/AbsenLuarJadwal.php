<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AbsenLuarJadwal extends Controller
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
    public function store(Request $request)
    {
        Absensekolah::create([
            'user_id'=>$this->user_id,
            'tanggal'=>Carbon::now()->toDateString(),
            'jam_ke'=>$this->jam_ke,
            'mulai_kbm'=>$this->mulai_kbm,
            'akhir_kbm'=>$this->akhir_kbm,
            'akhir_kbm'=>$this->,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
