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
    public function index()
    {
        $transaksi = TransaksiLain::where('user_id', Auth::id()) // 🔥 Filter berdasarkan user yang login
            ->orderBy('tgl_trans', 'desc')
            ->get();

        $coas = Coa::where('header_akun', 'LIKE', '%5%')->get();
        return view('transaksi.index', compact('transaksi', 'coas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tgl_trans' => 'required|date',
            'coa_id' => 'required|exists:coa,id',
            'total' => 'required|numeric',
            'deskripsi' => 'nullable|string',
        ]);

        DB::beginTransaction(); // 🔥 Mulai transaksi database

        try {
            $no_trans = 'TRX-' . now()->format('YmdHis');

            // 🔹 **Simpan Data Transaksi Lain**
            $transaksi = TransaksiLain::create([
                'no_trans' => $no_trans,
                'tgl_trans' => $request->tgl_trans,
                'coa_id' => $request->coa_id,
                'user_id' => Auth::id(),
                'total' => $request->total,
                'keterangan' => $request->deskripsi,
            ]);

            $no_jurnal = 'JRN-' . now()->format('YmdHis');

            // 🔹 **Jurnal untuk DEBIT (Biaya Listrik)**
            $coaDebit = Coa::findOrFail($request->coa_id);
            Jurnal::create([
                'no_jurnal' => $no_jurnal,
                'tgl_jurnal' => now(),
                'coa_id' => $coaDebit->id,
                'deskripsi' => 'Biaya dari Transaksi No. ' . $no_trans,
                'debit' => $request->total,
                'kredit' => 0,
                'user_id' => Auth::id(),
            ]);

            // 🔹 **Jurnal untuk KREDIT (Kas)**
            $coaKas = Coa::where('kode_coa', '111')->first(); // Kas
            Jurnal::create([
                'no_jurnal' => $no_jurnal,
                'tgl_jurnal' => now(),
                'coa_id' => $coaKas->id,
                'deskripsi' => 'Pengeluaran untuk Transaksi No. ' . $no_trans,
                'debit' => 0,
                'kredit' => $request->total,
                'user_id' => Auth::id(),
            ]);

            DB::commit(); // 🔥 Commit jika sukses

            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack(); // 🔥 Rollback jika terjadi error
            return redirect()->route('transaksi.index')->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }
}
