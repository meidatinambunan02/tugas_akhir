<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelangganController extends Controller
{
    // ✅ Menampilkan daftar pelanggan
    public function index()
    {
        // Ambil semua data pelanggan dari database
        $datapelanggan = Pelanggan::all();

        // Kirim data pelanggan ke view `pelanggan.index`
        return view('pelanggan.index', compact('datapelanggan'));
    }

    // ✅ Menyimpan data pelanggan baru
    public function store(Request $request)
    {
        // 🔥 Validasi data yang dikirim dari form
        $validated = $request->validate([
            'kode_pelanggan' => 'required|unique:pelanggan|max:255', // Kode pelanggan harus unik
            'nama_pelanggan' => 'required|max:255', // Nama pelanggan wajib diisi dengan maksimal 255 karakter
            'email' => 'required|email|unique:pelanggan', // Email wajib diisi dan harus unik
            'telepon' => 'required|max:15', // Nomor telepon wajib diisi dan maksimal 15 karakter
            'alamat' => 'required' // Alamat wajib diisi
        ]);

        // Tambahkan ID user yang sedang login
        $validated['user_id'] = Auth::id();

        // Buat data pelanggan baru di database
        Pelanggan::create($validated);

        // Redirect ke halaman daftar pelanggan dengan pesan sukses
        return redirect()->route('pelanggan.index')->with('success', 'Data Pelanggan berhasil ditambahkan!');
    }

    // ✅ Mengupdate data pelanggan berdasarkan ID
    public function update(Request $request, $id)
    {
        // 🔥 Validasi data yang dikirim dari form
        $request->validate([
            'kode_pelanggan' => 'required|max:255|unique:pelanggan,kode_pelanggan,' . $id, // Kode pelanggan unik kecuali untuk ID yang sedang diupdate
            'nama_pelanggan' => 'required|max:255', // Nama pelanggan wajib diisi dengan maksimal 255 karakter
            'email' => 'required|email|unique:pelanggan,email,' . $id, // Email wajib unik kecuali untuk ID yang sedang diupdate
            'telepon' => 'required|max:15', // Nomor telepon wajib diisi dan maksimal 15 karakter
            'alamat' => 'required' // Alamat wajib diisi
        ]);

        // Cari data pelanggan berdasarkan ID
        $pelanggan = Pelanggan::findOrFail($id);

        // Update data pelanggan dengan data yang dikirim dari form
        $pelanggan->update($request->all());

        // Redirect ke halaman daftar pelanggan dengan pesan sukses
        return redirect()->route('pelanggan.index')->with('success', 'Data Pelanggan berhasil diperbarui!');
    }

    // ✅ Menghapus data pelanggan berdasarkan ID
    public function destroy($id)
    {
        // Cari data pelanggan berdasarkan ID
        $pelanggan = Pelanggan::findOrFail($id);

        // Hapus data pelanggan dari database
        $pelanggan->delete();

        // Redirect ke halaman daftar pelanggan dengan pesan sukses
        return redirect()->route('pelanggan.index')->with('success', 'Data Pelanggan berhasil dihapus!');
    }
}
