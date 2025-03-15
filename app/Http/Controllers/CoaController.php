<?php

namespace App\Http\Controllers;

use App\Models\Coa;
use App\Http\Requests\StorecoaRequest;
use App\Http\Requests\UpdatecoaRequest;
use Illuminate\Http\Request;

class CoaController extends Controller
{
    /**
     * Menampilkan daftar COA.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil semua data COA dari database
        $datacoa = Coa::all();

        // Menampilkan view 'coa.index' dengan data COA
        return view('coa.index', compact('datacoa'));
    }

    /**
     * Menampilkan form untuk membuat data COA baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('coa.create');
    }

    /**
     * Menyimpan data COA baru ke dalam database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input dari request
        $validated = $request->validate([
            'kode_coa' => 'required|max:255', // Kode COA wajib diisi dan maksimal 255 karakter
            'nama_akun' => 'required|max:255', // Nama akun wajib diisi dan maksimal 255 karakter
            'header_akun' => 'required|max:255', // Header akun wajib diisi dan maksimal 255 karakter
        ]);

        // Menyimpan data COA ke database
        Coa::create($validated);

        // Redirect ke halaman daftar COA dengan pesan sukses
        return redirect()->route('coa.index')->with('success', 'Data COA berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit data COA yang dipilih.
     *
     * @param int $id ID dari COA yang akan diedit
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Mengambil data COA berdasarkan ID
        $coa = Coa::findOrFail($id);

        // Menampilkan view 'coa.edit' dengan data COA yang dipilih
        return view('coa.edit', compact('coa'));
    }

    /**
     * Memperbarui data COA yang dipilih di database.
     *
     * @param \App\Http\Requests\UpdatecoaRequest $request
     * @param int $id ID dari COA yang akan diperbarui
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdatecoaRequest $request, $id)
    {
        // Validasi input dari request
        $request->validate([
            'kode_coa' => 'required|integer|max:255', // Kode COA wajib diisi, berupa integer, dan maksimal 255 karakter
            'nama_akun' => 'required|string|max:255', // Nama akun wajib diisi dan berupa string maksimal 255 karakter
            'header_akun' => 'required|string|max:255', // Header akun wajib diisi dan berupa string maksimal 255 karakter
        ]);

        // Mengambil data COA berdasarkan ID
        $coa = Coa::findOrFail($id);

        // Mengupdate data COA dengan data yang baru
        $coa->update([
            'kode_coa' => $request->kode_coa,
            'nama_akun' => $request->nama_akun,
            'header_akun' => $request->header_akun,
        ]);

        // Redirect ke halaman daftar COA dengan pesan sukses
        return redirect()->route('coa.index')->with('success', 'Data COA berhasil diperbarui!');
    }

    /**
     * Menghapus data COA yang dipilih dari database.
     *
     * @param int $id ID dari COA yang akan dihapus
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Mencari data COA berdasarkan ID
        $coa = Coa::findOrFail($id);

        // Menghapus data COA
        $coa->delete();

        // Redirect ke halaman daftar COA dengan pesan sukses
        return redirect()->route('coa.index')->with('success', 'Data COA berhasil dihapus!');
    }
}
