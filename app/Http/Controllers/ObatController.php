<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateobatRequest;
use App\Models\obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataobat = obat::all();
        return view('obat.index', compact('dataobat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('obat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'kode_obat' => 'required|max:255',
            'nama_obat' => 'required|max:255',
            'jmlh_stok' => 'required|max:255',
            'harga' => 'required|max:255',
            'tgl_beli' => 'required|date',
        ]);

        // Menyimpan data obat ke database
        Obat::create($validated);

        // Redirect kembali ke halaman list obat atau halaman lain yang diinginkan
        return redirect()->route('obat.index')->with('success', 'Data Obat berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(obat $obat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $obat= Obat::findOrFail($id);
        return view('obat.edit', compact('obat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateobatRequest $request, $id)
    {
        $request->validate([
            'kode_obat' => 'required|max:255',
            'nama_obat' => 'required|max:255',
            'jmlh_stok' => 'required|max:255',
            'harga' => 'required|max:255',
            'tgl_beli' => 'required|date',
        ]);

        $obat = Obat::findOrFail($id);
        $obat->update([
            'kode_obat' => $request->kode_obat,
            'nama_obat' => $request->nama_obat,
            'jmlh_stok' => $request->jmlh_stok,
            'harga' => $request->harga,
            'tgl_beli' => $request->tgl_beli,
        ]);

        return redirect()->route('obat.index')->with('success', 'Data Obat berhasil diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //cari data berdasarkan id
        $obat = Obat::findOrFail($id);

        //hapus data
        $obat->delete();

        //redirect kembali ke halaman list dengan pesan sukses
        return redirect()->route('obat.index')->with('success', 'Data Obat berhasil dihapus!');
    }
}
