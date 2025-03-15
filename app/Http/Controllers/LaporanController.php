<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LaporanController extends Controller
{
    /**
     * ✅ Tampilkan Laporan Laba Rugi.
     * 
     * Laporan ini menghitung total pendapatan dan total beban,
     * kemudian menghasilkan laba bersih dengan rumus:
     * 
     * **Laba Bersih = Total Pendapatan - Total Beban**
     */
    public function labaRugi(Request $request): View
    {
        // ✅ Ambil tanggal dari request (format: Y-m-d)
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // ✅ Ambil data jurnal dengan relasi ke `coa` (akun)
        $query = Jurnal::with('coa')
            ->where('user_id', Auth::id()); // ✅ Filter berdasarkan user yang sedang login

        // ✅ Filter berdasarkan tanggal jika tersedia
        if ($start_date && $end_date) {
            $query->whereBetween('tgl_jurnal', [$start_date, $end_date]);
        }

        // ✅ Ambil data pendapatan (header akun 4)
        $pendapatan = (clone $query)->whereHas('coa', function ($q) {
            $q->where('header_akun', 4); // ✅ Kode header 4 untuk pendapatan
        })->get();

        // ✅ Ambil data beban (header akun 5)
        $beban = (clone $query)->whereHas('coa', function ($q) {
            $q->where('header_akun', 5); // ✅ Kode header 5 untuk beban
        })->get();

        // ✅ Hitung total pendapatan (jumlah kolom `kredit`)
        $totalPendapatan = $pendapatan->sum('kredit');

        // ✅ Hitung total beban (jumlah kolom `debit`)
        $totalBeban = $beban->sum('debit');

        // ✅ Hitung laba bersih (pendapatan - beban)
        $labaBersih = $totalPendapatan - $totalBeban;

        // ✅ Kirim data ke view `laporan.laba-rugi`
        return view('laporan.laba-rugi', compact(
            'pendapatan',
            'beban',
            'totalPendapatan',
            'totalBeban',
            'labaBersih'
        ));
    }

    /**
     * ✅ Export Laporan Laba Rugi ke PDF.
     * 
     * Laporan ini akan dibuat dalam bentuk file PDF menggunakan library DomPDF.
     */
    public function exportLabaRugi(Request $request)
    {
        // ✅ Ambil tanggal dari request
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // ✅ Ambil data pendapatan (header akun 4)
        $pendapatan = Jurnal::with('coa')
            ->where('user_id', Auth::id()) // ✅ Filter berdasarkan user yang sedang login
            ->whereHas('coa', function ($q) {
                $q->where('header_akun', 4); // ✅ Header akun 4 untuk pendapatan
            })
            ->whereBetween('tgl_jurnal', [$startDate, $endDate])
            ->get();

        // ✅ Ambil data beban (header akun 5)
        $beban = Jurnal::with('coa')
            ->where('user_id', Auth::id()) // ✅ Filter berdasarkan user yang sedang login
            ->whereHas('coa', function ($q) {
                $q->where('header_akun', 5); // ✅ Header akun 5 untuk beban
            })
            ->whereBetween('tgl_jurnal', [$startDate, $endDate])
            ->get();

        // ✅ Hitung total pendapatan dan total beban
        $totalPendapatan = $pendapatan->sum('kredit');
        $totalBeban = $beban->sum('debit');
        $labaBersih = $totalPendapatan - $totalBeban;

        // ✅ Load data ke dalam template view PDF (laporan.laba-rugi-pdf)
        $pdf = Pdf::loadView('laporan.laba-rugi-pdf', compact(
            'pendapatan',
            'beban',
            'totalPendapatan',
            'totalBeban',
            'labaBersih',
            'startDate',
            'endDate'
        ))->setPaper('a4', 'portrait'); // ✅ Set ukuran kertas A4 dalam mode potret

        // ✅ Download file PDF dengan nama `laporan-laba-rugi.pdf`
        return $pdf->download('laporan-laba-rugi.pdf');
    }
}
