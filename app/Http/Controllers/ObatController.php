<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateobatRequest;
use App\Models\coa;
use App\Models\Jurnal;
use App\Models\obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ObatController extends Controller
{
    /**
     * ✅ Menampilkan daftar obat.
     */
    public function index()
    {
        // Mengambil semua data obat dari database
        $dataobat = obat::all();

        // Menampilkan data obat ke dalam view 'obat.index'
        return view('obat.index', compact('dataobat'));
    }

    /**
     * ✅ Menampilkan form untuk menambah data obat baru.
     */
    public function create()
    {
        // Menampilkan halaman form tambah obat
        return view('obat.create');
    }

    /**
     * ✅ Menyimpan data obat baru ke dalam database.
     */
    public function store(Request $request)
    {
        // Melakukan validasi data yang dikirim dari form
        $validated = $request->validate([
            'kode_obat' => 'required|max:255', // Kode obat wajib diisi, maksimal 255 karakter
            'nama_obat' => 'required|max:255', // Nama obat wajib diisi, maksimal 255 karakter
            'jmlh_stok' => 'required|numeric', // Jumlah stok wajib diisi dan harus berupa angka
            'harga' => 'required|numeric', // Harga wajib diisi dan harus berupa angka
            'satuan'=> 'required|max:255', // satuan wajib diisi
            'tgl_beli' => 'required|date', // Tanggal beli wajib diisi dan harus berupa format tanggal
        ]);

        // Menambahkan ID user yang sedang login ke data yang divalidasi
        $validated['user_id'] = Auth::id();

        // Menyimpan data obat ke dalam database
        $obat = Obat::create($validated);

        // Menghitung total harga pembelian (jumlah stok * harga satuan)
        $total = $obat->jmlh_stok * $obat->harga;

        // 🔥 Ambil data COA (Chart of Account) untuk mencatat jurnal
        $coaPersediaan = coa::where('kode_coa', '114')->first(); // Kode COA untuk Persediaan Barang Dagang
        $coaKas = coa::where('kode_coa', '111')->first(); // Kode COA untuk Kas (pembayaran tunai)

        // 🔥 Pencatatan jurnal untuk pembelian obat secara TUNAI
        if ($coaPersediaan && $coaKas) {
            // ✅ Mencatat ke jurnal sebagai DEBIT pada akun Persediaan Barang Dagang
            Jurnal::create([
                'no_jurnal' => 'J-' . time(), // Format nomor jurnal dengan timestamp agar unik
                'tgl_jurnal' => $obat->tgl_beli, // Tanggal jurnal sesuai tanggal pembelian
                'coa_id' => $coaPersediaan->id, // ID akun Persediaan Barang Dagang
                'deskripsi' => 'Pembelian Obat ' . $obat->nama_obat, // Keterangan transaksi
                'debit' => $total, // Mencatat sebagai DEBIT (penambahan aset)
                'kredit' => 0, // Tidak ada kredit di sisi ini
                'user_id' => Auth::id(), // ID user yang melakukan transaksi
            ]);

            // ✅ Mencatat ke jurnal sebagai KREDIT pada akun Kas (karena pembelian tunai)
            Jurnal::create([
                'no_jurnal' => 'J-' . time(), // Format nomor jurnal dengan timestamp agar unik
                'tgl_jurnal' => $obat->tgl_beli, // Tanggal jurnal sesuai tanggal pembelian
                'coa_id' => $coaKas->id, // ID akun Kas (pembayaran tunai)
                'deskripsi' => 'Pembayaran Obat ' . $obat->nama_obat, // Keterangan transaksi
                'debit' => 0, // Tidak ada debit di sisi ini
                'kredit' => $total, // Mencatat sebagai KREDIT (pengurangan kas)
                'user_id' => Auth::id(), // ID user yang melakukan transaksi
            ]);
        }

        // Redirect kembali ke halaman list obat dengan pesan sukses
        return redirect()->route('obat.index')->with('success', 'Data Obat berhasil ditambahkan!');
    }

    /**
     * ✅ Menampilkan detail data obat (opsional).
     */
    public function show(obat $obat)
    {
        // Kosong (bisa diisi jika ingin menampilkan detail data obat)
    }

    /**
     * ✅ Menampilkan form untuk mengedit data obat.
     */
    public function edit($id)
    {
        // Mencari data obat berdasarkan ID
        $obat = Obat::findOrFail($id);

        // Menampilkan data obat ke dalam form edit
        return view('obat.edit', compact('obat'));
    }

    /**
     * ✅ Mengupdate data obat yang sudah ada di dalam database.
     */
    public function update(UpdateobatRequest $request, $id)
    {
        // Melakukan validasi data yang dikirim dari form
        $request->validate([
            'kode_obat' => 'required|max:255', // Kode obat wajib diisi, maksimal 255 karakter
            'nama_obat' => 'required|max:255', // Nama obat wajib diisi, maksimal 255 karakter
            'jmlh_stok' => 'required|max:255', // Jumlah stok wajib diisi
            'harga' => 'required|max:255', // Harga wajib diisi
            'satuan' => 'required|max:255',
            'tgl_beli' => 'required|date', // Tanggal beli wajib diisi dan harus berupa format tanggal
        ]);

        // Cari data obat berdasarkan ID
        $obat = Obat::findOrFail($id);

        // Update data obat
        $obat->update([
            'kode_obat' => $request->kode_obat,
            'nama_obat' => $request->nama_obat,
            'jmlh_stok' => $request->jmlh_stok,
            'harga' => $request->harga,
            'satuan' => $request->satuan,
            'tgl_beli' => $request->tgl_beli,
        ]);

        // Redirect ke halaman list obat dengan pesan sukses
        return redirect()->route('obat.index')->with('success', 'Data Obat berhasil diperbaharui');
    }

    /**
     * ✅ Menghapus data obat dari database.
     */
    public function destroy($id)
    {
        // Cari data obat berdasarkan ID
        $obat = Obat::findOrFail($id);

        // Hapus data obat dari database
        $obat->delete();

        // Redirect ke halaman list obat dengan pesan sukses
        return redirect()->route('obat.index')->with('success', 'Data Obat berhasil dihapus!');
    }
}
