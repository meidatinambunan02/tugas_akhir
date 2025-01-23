<?php

namespace App\Http\Controllers;

use App\Models\coa;
use App\Http\Requests\StorecoaRequest;
use App\Http\Requests\UpdatecoaRequest;
use Illuminate\Http\Request;

class CoaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $datacoa= coa::all();
        return view('coa.index', compact('datacoa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('coa.create');
    }

    // Menyimpan data COA ke database
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'kode_coa' => 'required|max:255',
            'nama_akun' => 'required|max:255',
            'header_akun' => 'required|max:255',
        ]);

        // Menyimpan data COA ke database
        COA::create($validated);

        // Redirect kembali ke halaman list COA atau halaman lain yang diinginkan
        return redirect()->route('coa.index')->with('success', 'Data COA berhasil ditambahkan!');
    }
    /**
     * Display the specified resource.
     */
    public function show(coa $coa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $coa=Coa::findOrFail($id);
        return view('coa.edit', compact('coa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatecoaRequest $request, $id)
    {
        $request->validate([
            'kode_coa'=>'required|string|max:255|unique:coa,kode_coa'.$id,
            'nama_akun'=>'required|string|max:255',
            'header_akun'=>'required|string|max:255',
        ]);

        $coa=Coa::findOrFail($id);
        $coa->update([
            'kode_coa'=> $request->kode_coa,
            'nama_akun'=>$request->nama_akun,
            'header_akun'=>$request->header_akun,
        ]);

        return redirect()->route('coa.index')->with('success', 'Data COA berhasil diperbaharui');
    
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(coa $coa)
    {
        //
    }
}
