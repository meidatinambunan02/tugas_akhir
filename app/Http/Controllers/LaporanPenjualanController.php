<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanPenjualanExport;
use Illuminate\Support\Facades\Auth;

class LaporanPenjualanController extends Controller
{
    /**
     * ✅ Menampilkan Laporan Penjualan
     * 
     * Laporan ini akan menampilkan daftar transaksi penjualan 
     * berdasarkan periode tanggal yang dipilih.
     */
    public function index(Request $request)
    {
        // ✅ Ambil tanggal dari request (format: Y-m-d)
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // ✅ Ambil data penjualan dengan relasi ke detail dan pelanggan
        $query = Penjualan::with('detailPenjualan.obat', 'pelanggan')
            ->where('user_id', Auth::id()) // ✅ Filter berdasarkan user yang sedang login
            ->orderBy('created_at', 'desc'); // ✅ Urutkan dari transaksi terbaru

        // ✅ Filter berdasarkan tanggal jika tersedia
        if ($startDate && $endDate) {
            $query->whereBetween('tgl_jual', [$startDate, $endDate]);
        }

        // ✅ Ambil hasil query
        $riwayat = $query->get();

        // ✅ Kirim data ke view `laporan.penjualan`
        return view('laporan.penjualan', compact('riwayat', 'startDate', 'endDate'));
    }

    /**
     * ✅ Export Laporan Penjualan ke PDF.
     * 
     * Laporan ini akan diekspor ke dalam file PDF menggunakan DomPDF.
     */
    public function export(Request $request)
    {
        // ✅ Ambil tanggal dari request
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // ✅ Ambil data penjualan dengan relasi ke detail dan pelanggan
        $query = Penjualan::with('detailPenjualan.obat', 'pelanggan')
            ->where('user_id', Auth::id()) // ✅ Filter berdasarkan user yang sedang login
            ->orderBy('created_at', 'desc'); // ✅ Urutkan dari transaksi terbaru

        // ✅ Filter berdasarkan tanggal jika tersedia
        if ($startDate && $endDate) {
            $query->whereBetween('tgl_jual', [$startDate, $endDate]);
        }

        // ✅ Ambil hasil query
        $riwayat = $query->get();

        // ✅ Load data ke dalam template view PDF (`laporan.penjualan-pdf`)
        $pdf = Pdf::loadView('laporan.penjualan-pdf', compact('riwayat', 'startDate', 'endDate'))
            ->setPaper('a4', 'landscape'); // ✅ Set ukuran kertas A4 dalam mode landscape

        // ✅ Download file PDF dengan nama `laporan-penjualan.pdf`
        return $pdf->download('laporan-penjualan.pdf');
    }
}
