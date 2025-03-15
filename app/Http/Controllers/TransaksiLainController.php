<?php

namespace App\Http\Controllers;

use App\Models\Coa;
use App\Models\Jurnal;
use App\Models\TransaksiLain;
use App\Models\TransaksiLainDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiLainController extends Controller
{
    // ✅ Fungsi untuk menampilkan daftar transaksi lain
    public function index()
    {
        // 🔥 Ambil data transaksi lain berdasarkan user yang login
        $transaksi = TransaksiLain::where('user_id', Auth::id()) 
            ->orderBy('tgl_trans', 'desc') // Urutkan berdasarkan tanggal transaksi (terbaru di atas)
            ->get();

        // 🔥 Ambil data akun dari tabel COA dengan header akun yang mengandung '5' (biaya atau pengeluaran)
        $coas = Coa::where('header_akun', 'LIKE', '%5%')->get();

        // 🔥 Kirim data ke view
        return view('transaksi.index', compact('transaksi', 'coas'));
    }

    // ✅ Fungsi untuk menyimpan transaksi baru
    public function store(Request $request)
    {
        // 🔥 Validasi data input dari request
        $request->validate([
            'tgl_trans' => 'required|date', // Tanggal transaksi wajib diisi dan harus berupa tanggal
            'coa_id' => 'required|exists:coa,id', // ID COA harus ada di tabel COA
            'total' => 'required|numeric', // Total transaksi wajib diisi dan harus berupa angka
            'deskripsi' => 'nullable|string', // Deskripsi bersifat opsional
        ]);

        DB::beginTransaction(); // 🔥 Mulai transaksi database (untuk memastikan data konsisten)

        try {
            // 🔹 Buat nomor transaksi unik dengan format: TRX-YYYYMMDDHHMMSS
            $no_trans = 'TRX-' . now()->format('YmdHis');

            // 🔹 **Simpan Data Transaksi Lain**
            $transaksi = TransaksiLain::create([
                'no_trans' => $no_trans, // Nomor transaksi
                'tgl_trans' => $request->tgl_trans, // Tanggal transaksi
                'coa_id' => $request->coa_id, // ID COA yang dipilih
                'user_id' => Auth::id(), // ID user yang sedang login
                'total' => $request->total, // Total transaksi
                'keterangan' => $request->deskripsi, // Keterangan transaksi (jika ada)
            ]);

            // 🔹 Buat nomor jurnal unik dengan format: JRN-YYYYMMDDHHMMSS
            $no_jurnal = 'JRN-' . now()->format('YmdHis');

            // 🔹 **Jurnal untuk DEBIT (Biaya)**
            $coaDebit = Coa::findOrFail($request->coa_id); // Ambil data akun yang dipilih (DEBIT)
            Jurnal::create([
                'no_jurnal' => $no_jurnal, // Nomor jurnal
                'tgl_jurnal' => now(), // Tanggal jurnal
                'coa_id' => $coaDebit->id, // ID COA (akun debit)
                'deskripsi' => 'Biaya dari Transaksi No. ' . $no_trans, // Keterangan jurnal
                'debit' => $request->total, // Jumlah di sisi debit
                'kredit' => 0, // Sisi kredit kosong
                'user_id' => Auth::id(), // ID user yang sedang login
            ]);

            // 🔹 **Jurnal untuk KREDIT (Kas)**
            $coaKas = Coa::where('kode_coa', '111')->first(); // Ambil akun kas dengan kode '111'
            Jurnal::create([
                'no_jurnal' => $no_jurnal, // Nomor jurnal
                'tgl_jurnal' => now(), // Tanggal jurnal
                'coa_id' => $coaKas->id, // ID COA (akun kas)
                'deskripsi' => 'Pengeluaran untuk Transaksi No. ' . $no_trans, // Keterangan jurnal
                'debit' => 0, // Sisi debit kosong
                'kredit' => $request->total, // Jumlah di sisi kredit (karena kas berkurang)
                'user_id' => Auth::id(), // ID user yang sedang login
            ]);

            DB::commit(); // 🔥 Commit transaksi jika semua proses berhasil

            // ✅ Redirect ke halaman daftar transaksi dengan pesan sukses
            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack(); // 🔥 Rollback transaksi jika terjadi error

            // ✅ Redirect ke halaman daftar transaksi dengan pesan error
            return redirect()->route('transaksi.index')->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }
}
