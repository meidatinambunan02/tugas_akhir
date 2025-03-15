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
    public function index(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $query = Penjualan::with('detailPenjualan.obat', 'pelanggan')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc');

        if ($startDate && $endDate) {
            $query->whereBetween('tgl_jual', [$startDate, $endDate]);
        }

        $riwayat = $query->get();

        return view('laporan.penjualan', compact('riwayat', 'startDate', 'endDate'));
    }

    // Export PDF
    public function export(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $query = Penjualan::with('detailPenjualan.obat', 'pelanggan')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc');

        if ($startDate && $endDate) {
            $query->whereBetween('tgl_jual', [$startDate, $endDate]);
        }

        $riwayat = $query->get();

        $pdf = Pdf::loadView('laporan.penjualan-pdf', compact('riwayat', 'startDate', 'endDate'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-penjualan.pdf');
    }
}
