<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class JurnalController extends Controller
{
    /**
     * Tampilkan data jurnal umum.
     */
    public function index(Request $request)
    {
        // ✅ Ambil data jurnal beserta relasi ke tabel `coa`
        $query = Jurnal::with('coa')
            ->where('user_id', Auth::id()) // ✅ Filter berdasarkan user yang sedang login
            ->orderBy('tgl_jurnal', 'desc'); // ✅ Urutkan berdasarkan tanggal jurnal dari terbaru ke terlama

        // ✅ Filter berdasarkan tanggal jika tersedia dalam request
        if ($request->filled('start_date') && $request->filled('end_date')) {
            try {
                // ✅ Konversi tanggal dari format string ke objek Carbon (untuk mempermudah manipulasi tanggal)
                $startDate = Carbon::createFromFormat('Y-m-d', $request->start_date)->startOfDay(); // Mulai dari awal hari
                $endDate = Carbon::createFromFormat('Y-m-d', $request->end_date)->endOfDay(); // Sampai akhir hari

                // ✅ Filter berdasarkan rentang tanggal
                $query->whereBetween('tgl_jurnal', [$startDate, $endDate]);
            } catch (\Exception $e) {
                // ✅ Jika terjadi error pada format tanggal, kembalikan pesan error
                return back()->with('error', 'Format tanggal salah.');
            }
        }

        // ✅ Eksekusi query untuk mengambil data jurnal
        $jurnals = $query->get();

        // ✅ Kirim data ke view `jurnal-umum`
        return view('jurnal.jurnal-umum', compact('jurnals'));
    }

    /**
     * Tampilkan data buku besar.
     */
    public function bukuBesar(Request $request)
    {
        // ✅ Ambil data jurnal beserta relasi ke tabel `coa`
        $query = Jurnal::with('coa')
            ->where('user_id', Auth::id()) // ✅ Filter berdasarkan user yang sedang login
            ->orderBy('tgl_jurnal', 'asc'); // ✅ Urutkan berdasarkan tanggal jurnal dari terlama ke terbaru (untuk saldo berjalan)

        // ✅ Filter berdasarkan tanggal jika tersedia dalam request
        if ($request->filled('start_date') && $request->filled('end_date')) {
            try {
                // ✅ Konversi tanggal dari format string ke objek Carbon
                $startDate = Carbon::createFromFormat('Y-m-d', $request->start_date)->startOfDay();
                $endDate = Carbon::createFromFormat('Y-m-d', $request->end_date)->endOfDay();

                // ✅ Filter berdasarkan rentang tanggal
                $query->whereBetween('tgl_jurnal', [$startDate, $endDate]);
            } catch (\Exception $e) {
                // ✅ Jika terjadi error pada format tanggal, kembalikan pesan error
                return back()->with('error', 'Format tanggal salah.');
            }
        }

        // ✅ Eksekusi query dan kelompokkan hasilnya berdasarkan `kode_coa`
        $jurnals = $query->get()->groupBy('coa.kode_coa');

        // ✅ Koleksi untuk menyimpan data buku besar
        $bukuBesar = collect();

        // ✅ Iterasi setiap grup `kode_coa`
        foreach ($jurnals as $kodeCoa => $items) {
            $saldo = 0; // ✅ Variabel untuk menyimpan saldo berjalan

            // ✅ Iterasi setiap item jurnal dalam grup
            foreach ($items as $item) {
                // ✅ Hitung saldo berjalan (debit - kredit)
                $saldo += $item->debit - $item->kredit;

                // ✅ Tambahkan data ke dalam koleksi `bukuBesar`
                $bukuBesar->push([
                    'kode_coa' => $kodeCoa,
                    'nama_akun' => $item->coa->nama_akun ?? '-', // Jika nama akun tidak tersedia, isi dengan '-'
                    'tanggal' => $item->tgl_jurnal,
                    'deskripsi' => $item->deskripsi,
                    'debit' => $item->debit,
                    'kredit' => $item->kredit,
                    'saldo' => $saldo, // ✅ Saldo berjalan
                ]);
            }
        }

        // ✅ Kirim data ke view `buku-besar` dalam format collection
        return view('jurnal.buku-besar', compact('bukuBesar'));
    }
}
