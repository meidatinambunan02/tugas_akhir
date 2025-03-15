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
        $query = Jurnal::with('coa')
            ->where('user_id', Auth::id()) // ✅ Filter berdasarkan user yang login
            ->orderBy('tgl_jurnal', 'desc');

        // ✅ Filter berdasarkan tanggal jika ada
        if ($request->filled('start_date') && $request->filled('end_date')) {
            try {
                $startDate = Carbon::createFromFormat('Y-m-d', $request->start_date)->startOfDay();
                $endDate = Carbon::createFromFormat('Y-m-d', $request->end_date)->endOfDay();

                $query->whereBetween('tgl_jurnal', [$startDate, $endDate]);
            } catch (\Exception $e) {
                return back()->with('error', 'Format tanggal salah.');
            }
        }

        // ✅ Ambil data jurnal
        $jurnals = $query->get();

        return view('jurnal.jurnal-umum', compact('jurnals'));
    }

    public function bukuBesar(Request $request)
    {
        $query = Jurnal::with('coa')
            ->where('user_id', Auth::id())
            ->orderBy('tgl_jurnal', 'asc'); // ✅ Urutkan berdasarkan tanggal ASC (untuk saldo berjalan)

        // ✅ Filter berdasarkan tanggal jika ada
        if ($request->filled('start_date') && $request->filled('end_date')) {
            try {
                $startDate = Carbon::createFromFormat('Y-m-d', $request->start_date)->startOfDay();
                $endDate = Carbon::createFromFormat('Y-m-d', $request->end_date)->endOfDay();

                $query->whereBetween('tgl_jurnal', [$startDate, $endDate]);
            } catch (\Exception $e) {
                return back()->with('error', 'Format tanggal salah.');
            }
        }

        // ✅ Ambil data jurnal dan kelompokkan berdasarkan kode COA (bukan coa_id)
        $jurnals = $query->get()->groupBy('coa.kode_coa');

        // ✅ Ubah menjadi collection agar first() dapat digunakan di Blade
        $bukuBesar = collect();

        foreach ($jurnals as $kodeCoa => $items) {
            $saldo = 0;

            foreach ($items as $item) {
                // ✅ Hitung saldo berjalan
                $saldo += $item->debit - $item->kredit;

                $bukuBesar->push([
                    'kode_coa' => $kodeCoa,
                    'nama_akun' => $item->coa->nama_akun ?? '-',
                    'tanggal' => $item->tgl_jurnal,
                    'deskripsi' => $item->deskripsi,
                    'debit' => $item->debit,
                    'kredit' => $item->kredit,
                    'saldo' => $saldo,
                ]);
            }
        }

        // ✅ Kirim ke view dalam format collection
        return view('jurnal.buku-besar', compact('bukuBesar'));
    }
}
