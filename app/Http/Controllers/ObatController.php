<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateobatRequest;
use App\Models\coa;
use App\Models\Jurnal;
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
            'jmlh_stok' => 'required|numeric',
            'harga' => 'required|numeric',
            'tgl_beli' => 'required|date',
        ]);

        // Menyimpan data obat ke database
        $obat = Obat::create($validated);

        // Hitung total harga pembelian
        $total = $obat->jmlh_stok * $obat->harga;

        // 🔥 Ambil COA berdasarkan kode yang sudah disediakan di seeder
        $coaPersediaan = coa::where('kode_coa', '114')->first(); // Persediaan Barang Dagang
        $coaKas = coa::where('kode_coa', '111')->first(); // Kas


        // 🔥 Pencatatan jurnal untuk pembelian obat secara TUNAI
        if ($coaPersediaan && $coaKas) {
            // ✅ Debit → Persediaan Barang Dagang
            Jurnal::create([
                'no_jurnal' => 'J-' . time(),
                'tgl_jurnal' => $obat->tgl_beli,
                'coa_id' => $coaPersediaan->id,
                'deskripsi' => 'Pembelian Obat ' . $obat->nama_obat,
                'debit' => $total,
                'kredit' => 0,
            ]);

            // ✅ Kredit → Kas (jika tunai) atau Utang Usaha (jika kredit)
            Jurnal::create([
                'no_jurnal' => 'J-' . time(),
                'tgl_jurnal' => $obat->tgl_beli,
                'coa_id' => $coaKas->id, // Jika pembelian tunai
                'deskripsi' => 'Pembayaran Obat ' . $obat->nama_obat,
                'debit' => 0,
                'kredit' => $total,
            ]);
        }

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
        $obat = Obat::findOrFail($id);
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
