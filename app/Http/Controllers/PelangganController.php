<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $datapelanggan = Pelanggan::all();
        return view('pelanggan.index', compact('datapelanggan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_pelanggan' => 'required|unique:pelanggan|max:255',
            'nama_pelanggan' => 'required|max:255',
            'email' => 'required|email|unique:pelanggan',
            'telepon' => 'required|max:15',
            'alamat' => 'required'
        ]);

        Pelanggan::create($validated);

        return redirect()->route('pelanggan.index')->with('success', 'Data Pelanggan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_pelanggan' => 'required|max:255|unique:pelanggan,kode_pelanggan,' . $id,
            'nama_pelanggan' => 'required|max:255',
            'email' => 'required|email|unique:pelanggan,email,' . $id,
            'telepon' => 'required|max:15',
            'alamat' => 'required'
        ]);

        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update($request->all());

        return redirect()->route('pelanggan.index')->with('success', 'Data Pelanggan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')->with('success', 'Data Pelanggan berhasil dihapus!');
    }
}
