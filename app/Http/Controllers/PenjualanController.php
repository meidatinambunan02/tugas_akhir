<?php

namespace App\Http\Controllers;

use App\Models\penjualan;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datapenjualan = penjualan::all();
        return view('penjualan.index', compact('datapenjualan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('penjualan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'id_jual' => 'required|max:255',
            'no_trans' => 'required|max:255',
            'tgl_jual' => 'required|date',
            'nama_obat' => 'required|max:255',
            'jmlh_jual' => 'required|max:255',
            'harga_satuan' => 'required|max:255',
            'total_jual' => 'required|max:255',
        ]);

        // Menyimpan data obat ke database
        Penjualan::create($validated);

        // Redirect kembali ke halaman list obat atau halaman lain yang diinginkan
        return redirect()->route('penjualan.index')->with('success', 'Transaksi Penjualan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(penjualan $penjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(penjualan $penjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, penjualan $penjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(penjualan $penjualan)
    {
        //
    }
}
