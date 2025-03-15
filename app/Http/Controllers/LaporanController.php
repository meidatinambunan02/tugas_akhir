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
     * Tampilkan Laporan Laba Rugi.
     */
    public function labaRugi(Request $request): View
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $query = Jurnal::with('coa')
            ->where('user_id', Auth::id()); // ✅ Filter berdasarkan user yang login

        if ($start_date && $end_date) {
            $query->whereBetween('tgl_jurnal', [$start_date, $end_date]);
        }

        // Pendapatan = header akun 4
        $pendapatan = (clone $query)->whereHas('coa', function ($q) {
            $q->where('header_akun', 4);
        })->get();

        // Beban = header akun 5
        $beban = (clone $query)->whereHas('coa', function ($q) {
            $q->where('header_akun', 5);
        })->get();

        $totalPendapatan = $pendapatan->sum('kredit');
        $totalBeban = $beban->sum('debit');
        $labaBersih = $totalPendapatan - $totalBeban;

        return view('laporan.laba-rugi', compact(
            'pendapatan',
            'beban',
            'totalPendapatan',
            'totalBeban',
            'labaBersih'
        ));
    }


    public function exportLabaRugi(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // Ambil pendapatan berdasarkan header akun 4 dan filter berdasarkan user
        $pendapatan = Jurnal::with('coa')
            ->where('user_id', Auth::id()) // ✅ Filter berdasarkan user yang login
            ->whereHas('coa', function ($q) {
                $q->where('header_akun', 4);
            })
            ->whereBetween('tgl_jurnal', [$startDate, $endDate])
            ->get();

        // Ambil beban berdasarkan header akun 5 dan filter berdasarkan user
        $beban = Jurnal::with('coa')
            ->where('user_id', Auth::id()) // ✅ Filter berdasarkan user yang login
            ->whereHas('coa', function ($q) {
                $q->where('header_akun', 5);
            })
            ->whereBetween('tgl_jurnal', [$startDate, $endDate])
            ->get();

        $totalPendapatan = $pendapatan->sum('kredit');
        $totalBeban = $beban->sum('debit');
        $labaBersih = $totalPendapatan - $totalBeban;

        $pdf = Pdf::loadView('laporan.laba-rugi-pdf', compact(
            'pendapatan',
            'beban',
            'totalPendapatan',
            'totalBeban',
            'labaBersih',
            'startDate',
            'endDate'
        ))->setPaper('a4', 'portrait');

        return $pdf->download('laporan-laba-rugi.pdf');
    }
}
